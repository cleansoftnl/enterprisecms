<?php namespace WebEd\Modules\Relations\Http\Controllers;

use Illuminate\Http\Request;
use WebEd\Base\Http\Controllers\BaseAdminController;
use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Modules\Relations\Http\DataTables\TagsListDataTable;
use WebEd\Modules\Relations\Http\Requests\CreateRelationTagRequest;
use WebEd\Modules\Relations\Http\Requests\UpdateRelationTagRequest;
use WebEd\Modules\Relations\Repositories\RelationTagRepository;
use WebEd\Modules\Relations\Repositories\Contracts\RelationTagRepositoryContract;
use Yajra\Datatables\Engines\BaseEngine;

class RelationTagController extends BaseAdminController
{
    protected $module = 'webed-relations';

    /**
     * @var RelationTagRepository
     */
    protected $repository;

    public function __construct(RelationTagRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->middleware(function (Request $request, $next) {
            $this->getDashboardMenu($this->module . '-tags');

            $this->breadcrumbs
                ->addLink(trans('relations::base.page_title'))
                ->addLink(trans('relations::base.tags.page_title'), route('admin::relations.tags.index.get'));

            return $next($request);
        });
    }

    /**
     * @param AbstractDataTables|BaseEngine $dataTables
     * @return @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(TagsListDataTable $dataTables)
    {
        $this->setPageTitle(trans('relations::base.tags.page_title'));

        $this->dis['dataTable'] = $dataTables->run();

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_RELATIONS_TAGS, 'index.get', $dataTables)->viewAdmin('tags.index');
    }

    /**
     * @param AbstractDataTables|BaseEngine $dataTables
     * @return mixed
     */
    public function postListing(TagsListDataTable $dataTables)
    {
        $data = $dataTables->with($this->groupAction());

        return do_filter(BASE_FILTER_CONTROLLER, $data, WEBED_RELATIONS_TAGS, 'index.post', $this);
    }

    /**
     * Handle group actions
     * @return array
     */
    protected function groupAction()
    {
        $data = [];
        if ($this->request->get('customActionType', null) === 'group_action') {
            if (!$this->userRepository->hasPermission($this->loggedInUser, ['edit-tags'])) {
                return [
                    'customActionMessage' => trans('webed-acl::base.do_not_have_permission'),
                    'customActionStatus' => 'danger',
                ];
            }

            $ids = (array)$this->request->get('id', []);
            $actionValue = $this->request->get('customActionValue');

            switch ($actionValue) {
                case 'deleted':
                    if (!$this->userRepository->hasPermission($this->loggedInUser, ['delete-tags'])) {
                        return [
                            'customActionMessage' => trans('webed-acl::base.do_not_have_permission'),
                            'customActionStatus' => 'danger',
                        ];
                    }
                    /**
                     * Delete items
                     */
                    $ids = do_filter(BASE_FILTER_BEFORE_DELETE, $ids, WEBED_RELATIONS_TAGS);

                    $result = $this->repository->deleteRelationTag($ids);

                    do_action(BASE_ACTION_AFTER_DELETE, WEBED_RELATIONS_TAGS, $ids, $result);
                    break;
                case 'activated':
                case 'disabled':
                    $result = $this->repository->updateMultiple($ids, [
                        'status' => $actionValue,
                    ]);
                    break;
                default:
                    return [
                        'customActionMessage' => trans('webed-core::errors.' . \Constants::METHOD_NOT_ALLOWED . '.message'),
                        'customActionStatus' => 'danger'
                    ];
                    break;
            }
            $data['customActionMessage'] = $result ? trans('webed-core::base.form.request_completed') : trans('webed-core::base.form.error_occurred');
            $data['customActionStatus'] = !$result ? 'danger' : 'success';

        }
        return $data;
    }

    /**
     * Update page status
     * @param $id
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateStatus($id, $status)
    {
        $data = [
            'status' => $status
        ];
        $result = $this->repository->update($id, $data);
        $msg = $result ? trans('webed-core::base.form.request_completed') : trans('webed-core::base.form.error_occurred');
        $code = $result ? \Constants::SUCCESS_NO_CONTENT_CODE : \Constants::ERROR_CODE;
        return response()->json(response_with_messages($msg, !$result, $code), $code);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate()
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_RELATIONS_TAGS, 'create.get');

        $this->assets
            ->addJavascripts([
                'jquery-ckeditor'
            ]);

        $this->setPageTitle(trans('relations::base.tags.form.create_tag'));
        $this->breadcrumbs->addLink(trans('relations::base.tags.form.create_tag'));

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_RELATIONS_TAGS, 'create.get')->viewAdmin('tags.create');
    }

    public function postCreate(CreateRelationTagRequest $request)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_RELATIONS_TAGS, 'create.post');

        $data = $this->parseData($request);
        $data['created_by'] = $this->loggedInUser->id;

        $result = $this->repository->createRelationTag($data);

        do_action(BASE_ACTION_AFTER_CREATE, WEBED_RELATIONS_TAGS, $result);

        $msgType = !$result ? 'danger' : 'success';
        $msg = $result ? trans('webed-core::base.form.request_completed') : trans('webed-core::base.form.error_occurred');

        flash_messages()
            ->addMessages($msg, $msgType)
            ->showMessagesOnSession();

        if (!$result) {
            return redirect()->back()->withInput();
        }

        if ($this->request->has('_continue_edit')) {
            return redirect()->to(route('admin::relations.tags.edit.get', ['id' => $result]));
        }

        return redirect()->to(route('admin::relations.tags.index.get'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        $item = $this->repository->find($id);

        if (!$item) {
            flash_messages()
                ->addMessages(trans('relations::base.item_not_exists'), 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_RELATIONS_TAGS, 'edit.get');

        $this->assets
            ->addJavascripts([
                'jquery-ckeditor'
            ]);

        $this->setPageTitle(trans('relations::base.tags.edit_item') . ' #' . $item->id);
        $this->breadcrumbs->addLink(trans('relations::base.tags.edit_item'));

        $this->dis['object'] = $item;

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_RELATIONS_TAGS, 'edit.get', $id)->viewAdmin('tags.edit');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(UpdateRelationTagRequest $request, $id)
    {
        $item = $this->repository->find($id);

        if (!$item) {
            flash_messages()
                ->addMessages(trans('relations::base.item_not_exists'), 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_RELATIONS_TAGS, 'edit.post');

        $data = $this->parseData($request);
        $data['updated_by'] = $this->loggedInUser->id;

        $result = $this->repository->updateRelationTag($item, $data);

        do_action(BASE_ACTION_AFTER_UPDATE, WEBED_RELATIONS_TAGS, $id, $result);

        $msgType = !$result ? 'danger' : 'success';
        $msg = $result ? trans('webed-core::base.form.request_completed') : trans('webed-core::base.form.error_occurred');

        flash_messages()
            ->addMessages($msg, $msgType)
            ->showMessagesOnSession();

        if ($this->request->has('_continue_edit')) {
            return redirect()->back();
        }

        return redirect()->to(route('admin::relations.tags.index.get'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteDelete($id)
    {
        $id = do_filter(BASE_FILTER_BEFORE_DELETE, $id, WEBED_RELATIONS_TAGS);

        $result = $this->repository->deleteRelationTag($id);

        do_action(BASE_ACTION_AFTER_DELETE, WEBED_RELATIONS_TAGS, $id, $result);

        $msg = $result ? trans('webed-core::base.form.request_completed') : trans('webed-core::base.form.error_occurred');
        $code = $result ? \Constants::SUCCESS_NO_CONTENT_CODE : \Constants::ERROR_CODE;
        return response()->json(response_with_messages($msg, !$result, $code), $code);
    }

    /**
     * @param \WebEd\Base\Http\Requests\Request $request
     * @return mixed
     */
    protected function parseData($request)
    {
        $data = $request->get('tag', []);
        $data['slug'] = $data['slug'] ? str_slug($data['slug']) : str_slug($data['title']);
        return $data;
    }
}
