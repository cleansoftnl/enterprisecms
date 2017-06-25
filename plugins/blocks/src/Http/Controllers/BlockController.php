<?php namespace WebEd\Plugins\Blocks\Http\Controllers;

use WebEd\Base\Core\Http\Controllers\BaseAdminController;
use WebEd\Plugins\Blocks\Http\DataTables\BlocksListDataTable;
use WebEd\Plugins\Blocks\Http\Requests\CreateBlockRequest;
use WebEd\Plugins\Blocks\Http\Requests\UpdateBlockRequest;
use WebEd\Plugins\Blocks\Repositories\BlockRepository;
use WebEd\Plugins\Blocks\Repositories\Contracts\BlockRepositoryContract;
use Yajra\Datatables\Engines\BaseEngine;

class BlockController extends BaseAdminController
{
    protected $module = 'webed-blocks';

    /**
     * @var BlockRepository
     */
    protected $repository;

    public function __construct(BlockRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->breadcrumbs->addLink('Blocks', route('admin::blocks.index.get'));

        $this->getDashboardMenu($this->module);
    }

    /**
     * Show index block
     * @method GET
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(BlocksListDataTable $blocksListDataTable)
    {
        $this->setPageTitle('CMS blocks', 'All available cms blocks');

        $this->dis['dataTable'] = $blocksListDataTable->run();

        return do_filter('blocks.index.get', $this, $blocksListDataTable)->viewAdmin('index');
    }

    /**
     * @param BlocksListDataTable|BaseEngine $blocksListDataTable
     * @return mixed
     */
    public function postListing(BlocksListDataTable $blocksListDataTable)
    {
        $data = $blocksListDataTable->with($this->groupAction());

        return do_filter('datatables.blocks.index.post', $data, $this, $blocksListDataTable);
    }

    /**
     * Handle group actions
     * @return array
     */
    protected function groupAction()
    {
        $data = [];
        if ($this->request->get('customActionType', null) === 'group_action') {
            if (!$this->userRepository->hasPermission($this->loggedInUser, ['edit-blocks'])) {
                return [
                    'customActionMessage' => 'You do not have permission',
                    'customActionStatus' => 'danger',
                ];
            }

            $ids = (array)$this->request->get('id', []);
            $actionValue = $this->request->get('customActionValue');

            switch ($actionValue) {
                case 'deleted':
                    if (!$this->userRepository->hasPermission($this->loggedInUser, ['delete-blocks'])) {
                        return [
                            'customActionMessage' => 'You do not have permission',
                            'customActionStatus' => 'danger',
                        ];
                    }
                    /**
                     * Delete blocks
                     */
                    $result = $this->repository->delete($ids);
                    break;
                case 'activated':
                case 'disabled':
                    $result = $this->repository->updateMultiple($ids, [
                        'status' => $actionValue,
                    ], true);
                    break;
                default:
                    $result = [
                        'messages' => 'Method not allowed',
                        'error' => true
                    ];
                    break;
            }
            $data['customActionMessage'] = $result['messages'];
            $data['customActionStatus'] = $result['error'] ? 'danger' : 'success';

        }
        return $data;
    }

    /**
     * Update block status
     * @param $id
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateStatus($id, $status)
    {
        $data = [
            'status' => $status
        ];
        $result = $this->repository->editWithValidate($id, $data);
        return response()->json($result, $result['response_code']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate()
    {
        $this->setPageTitle('Create block');
        $this->breadcrumbs->addLink('Create block');

        $this->dis['object'] = $this->repository->getModel();
        $this->dis['currentId'] = 0;

        $oldInputs = old();
        if ($oldInputs) {
            foreach ($oldInputs as $key => $row) {
                $this->dis['object']->$key = $row;
            }
        }

        return do_filter('blocks.create.get', $this)->viewAdmin('create');
    }

    public function postCreate(CreateBlockRequest $request)
    {
        $data = $this->parseDataUpdate();

        $data['created_by'] = $this->loggedInUser->id;

        $result = $this->repository->editWithValidate(null, $data, true);

        do_action('blocks.after-create.post', $result, $this);

        $msgType = $result['error'] ? 'danger' : 'success';

        $this->flashMessagesHelper
            ->addMessages($result['messages'], $msgType)
            ->showMessagesOnSession();

        if ($result['error']) {
            return redirect()->back()->withInput();
        }

        if ($this->request->has('_continue_edit')) {
            return redirect()->to(route('admin::blocks.edit.get', ['id' => $result['data']->id]));
        }

        return redirect()->to(route('admin::blocks.index.get'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        $item = $this->repository->find($id);

        if (!$item) {
            $this->flashMessagesHelper
                ->addMessages('This block not exists', 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        $item = do_filter('blocks.before-edit.get', $item);

        $this->assets
            ->addJavascripts([
                'jquery-ckeditor'
            ]);

        $this->setPageTitle('Edit block', $item->title);
        $this->breadcrumbs->addLink('Edit block');

        $this->dis['object'] = $item;
        $this->dis['currentId'] = $id;

        return do_filter('blocks.edit.get', $this, $id)->viewAdmin('edit');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(UpdateBlockRequest $request, $id)
    {
        $id = do_filter('blocks.before-edit.post', $id);

        $item = $this->repository->find($id);

        if (!$item) {
            $this->flashMessagesHelper
                ->addMessages('This block not exists', 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        $data = $this->parseDataUpdate();

        $result = $this->repository->editWithValidate($id, $data, false, true);

        do_action('blocks.after-edit.post', $id, $result, $this);

        $msgType = $result['error'] ? 'danger' : 'success';

        $this->flashMessagesHelper
            ->addMessages($result['messages'], $msgType)
            ->showMessagesOnSession();

        if ($this->request->has('_continue_edit')) {
            return redirect()->back();
        }

        return redirect()->to(route('admin::blocks.index.get'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteDelete($id)
    {
        $id = do_filter('blocks.before-delete.delete', $id);

        $result = $this->repository->delete($id);

        do_action('blocks.after-delete.delete', $id, $result, $this);

        return response()->json($result, $result['response_code']);
    }

    protected function parseDataUpdate()
    {
        return [
            'page_template' => $this->request->get('page_template', null),
            'status' => $this->request->get('status'),
            'title' => $this->request->get('title'),
            'content' => $this->request->get('content'),
            'updated_by' => $this->loggedInUser->id,
        ];
    }
}
