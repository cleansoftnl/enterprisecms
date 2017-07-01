<?php
namespace WebEd\Modules\Relations\Http\Controllers;

use Illuminate\Http\Request;
use WebEd\Base\Http\Controllers\BaseAdminController;
use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Modules\Relations\Http\DataTables\RelationsListDataTable;
use WebEd\Modules\Relations\Http\Requests\CreateRelationsRequest;
use WebEd\Modules\Relations\Http\Requests\UpdateRelationsRequest;
use WebEd\Modules\Relations\Repositories\BlogTagRepository;
use WebEd\Modules\Relations\Repositories\Contracts\BlogTagRepositoryContract;
use WebEd\Modules\Relations\Repositories\Contracts\RelationsRepositoryContract;
use WebEd\Modules\Relations\Repositories\RelationsRepository;
use Yajra\Datatables\Engines\BaseEngine;

class RelationsController extends BaseAdminController
{
    protected $module = 'webed-relations';

    /**
     * @var RelationsRepository
     */
    protected $repository;

    /**
     * @param RelationsRepository $repository
     */
    public function __construct(RelationsRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->middleware(function (Request $request, $next) {
            $this->getDashboardMenu($this->module . '-relations');

            $this->breadcrumbs
                ->addLink(trans('relations::base.page_title'))
                ->addLink(trans('relations::base.relations.page_title'), route('admin::relations.relations.index.get'));

            return $next($request);
        });
    }

    /**
     * @param AbstractDataTables|BaseEngine $dataTables
     * @return @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(RelationsListDataTable $dataTables)
    {
        $this->setPageTitle(trans('relations::base.relations.page_title'));

        $this->dis['dataTable'] = $dataTables->run();

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_RELATIONS_POSTS, 'index.get', $dataTables)->viewAdmin('relations.index');
    }

    /**
     * @param AbstractDataTables|BaseEngine $dataTables
     * @return mixed
     */
    public function relationListing(RelationsListDataTable $dataTables)
    {
        $data = $dataTables->with($this->groupAction());
        return do_filter(BASE_FILTER_CONTROLLER, $data, WEBED_RELATIONS_POSTS, 'index.relation', $this);
    }

    /**
     * Handle group actions
     * @return array
     */
    protected function groupAction()
    {
        $data = [];
        if ($this->request->get('customActionType', null) === 'group_action') {
            if (!$this->userRepository->hasPermission($this->loggedInUser, ['your-permission'])) {
                return [
                    'customActionMessage' => trans('webed-acl::base.do_not_have_permission'),
                    'customActionStatus' => 'danger',
                ];
            }

            $ids = (array)$this->request->get('id', []);
            $actionValue = $this->request->get('customActionValue');

            switch ($actionValue) {
                case 'deleted':
                    if (!$this->userRepository->hasPermission($this->loggedInUser, ['your-permission'])) {
                        return [
                            'customActionMessage' => trans('webed-acl::base.do_not_have_permission'),
                            'customActionStatus' => 'danger',
                        ];
                    }
                    $ids = do_filter(BASE_FILTER_BEFORE_DELETE, $ids, WEBED_RELATIONS_POSTS);

                    $result = $this->repository->deleteRelations($ids);

                    do_action(BASE_ACTION_AFTER_DELETE, WEBED_RELATIONS_POSTS, $ids, $result);
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
    public function relationUpdateStatus($id, $status)
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
     * @param BlogTagRepository $relationsTagRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate(BlogTagRepositoryContract $relationsTagRepository)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_RELATIONS_POSTS, 'create.get');

        $allCategories = get_categories();

        $selectArr = ['' => trans('webed-core::base.form.select') . '...',];
        foreach ($allCategories as $category) {
            $selectArr[$category->id] = $category->indent_text . $category->title;
        }
        $this->dis['baseCategories'] = $selectArr;

        $this->assets
            ->addJavascripts([
                'jquery-ckeditor',
                'jquery-select2'
            ])
            ->addStylesheets(['jquery-select2']);

        $this->dis['categories'] = get_categories_with_children();
        $this->dis['tags'] = $relationsTagRepository
            ->get(['id', 'title'])
            ->pluck('title', 'id')
            ->toArray();

        $this->setPageTitle(trans('relations::base.relations.form.create_relation'));
        $this->breadcrumbs->addLink(trans('relations::base.relations.form.create_relation'));

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_RELATIONS_POSTS, 'create.get')->viewAdmin('relations.create');
    }

    public function relationCreate(CreateRelationsRequest $request)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_RELATIONS_POSTS, 'create.relation');

        $data = $this->parseData($request);
        $data['created_by'] = $this->loggedInUser->id;

        $result = $this->repository->createRelations($data, $request->get('categories', []), $request->get('tags', []));

        do_action(BASE_ACTION_AFTER_CREATE, WEBED_RELATIONS_POSTS, $result);

        $msgType = !$result ? 'danger' : 'success';
        $msg = $result ? trans('webed-core::base.form.request_completed') : trans('webed-core::base.form.error_occurred');

        flash_messages()
            ->addMessages($msg, $msgType)
            ->showMessagesOnSession();

        if (!$result) {
            return redirect()->back()->withInput();
        }

        if ($this->request->has('_continue_edit')) {
            return redirect()->to(route('admin::relations.relations.edit.get', ['id' => $result]));
        }

        return redirect()->to(route('admin::relations.relations.index.get'));
    }

    /**
     * @param BlogTagRepository $relationsTagRepository
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit(BlogTagRepositoryContract $relationsTagRepository, $id)
    {
        $item = $this->repository->find($id);

        if (!$item) {
            flash_messages()
                ->addMessages(trans('relations::base.item_not_exists'), 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_RELATIONS_POSTS, 'edit.get');

        $allCategories = get_categories();

        $selectArr = ['' => trans('webed-core::base.form.select') . '...',];
        foreach ($allCategories as $category) {
            $selectArr[$category->id] = $category->indent_text . $category->title;
        }
        $this->dis['baseCategories'] = $selectArr;

        $this->assets
            ->addJavascripts([
                'jquery-ckeditor',
                'jquery-select2'
            ])
            ->addStylesheets(['jquery-select2']);

        $this->dis['categories'] = get_categories_with_children();
        $this->dis['selectedCategories'] = $this->repository->getRelatedCategoryIds($item);

        $this->dis['tags'] = $relationsTagRepository
            ->get(['id', 'title'])
            ->pluck('title', 'id')
            ->toArray();
        $this->dis['selectedTags'] = $this->repository->getRelatedTagIds($item);

        $this->setPageTitle(trans('relations::base.relations.form.edit_item') . ' #' . $item->id);
        $this->breadcrumbs->addLink(trans('relations::base.relations.form.edit_item'));

        $this->dis['object'] = $item;

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_RELATIONS_POSTS, 'edit.get', $id)->viewAdmin('relations.edit');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function relationEdit(UpdateRelationsRequest $request, $id)
    {
        $item = $this->repository->find($id);

        if (!$item) {
            flash_messages()
                ->addMessages(trans('relations::base.item_not_exists'), 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_RELATIONS_POSTS, 'edit.relation');

        $data = $this->parseData($request);
        $data['updated_by'] = $this->loggedInUser->id;

        $result = $this->repository->updateRelations($item, $data, $request->get('categories', []), $request->get('tags', []));

        do_action(BASE_ACTION_AFTER_UPDATE, WEBED_RELATIONS_POSTS, $id, $result);

        $msgType = !$result ? 'danger' : 'success';
        $msg = $result ? trans('webed-core::base.form.request_completed') : trans('webed-core::base.form.error_occurred');

        flash_messages()
            ->addMessages($msg, $msgType)
            ->showMessagesOnSession();

        if ($this->request->has('_continue_edit')) {
            return redirect()->back();
        }

        return redirect()->to(route('admin::relations.relations.index.get'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteDelete($id)
    {
        $id = do_filter(BASE_FILTER_BEFORE_DELETE, $id, WEBED_RELATIONS_POSTS);

        $result = $this->repository->delete($id);

        do_action(BASE_ACTION_AFTER_DELETE, WEBED_RELATIONS_POSTS, $id, $result);

        $msg = $result ? trans('webed-core::base.form.request_completed') : trans('webed-core::base.form.error_occurred');
        $code = $result ? \Constants::SUCCESS_NO_CONTENT_CODE : \Constants::ERROR_CODE;
        return response()->json(response_with_messages($msg, !$result, $code), $code);
    }

    protected function parseData(\WebEd\Base\Http\Requests\Request $request)
    {
        $data = $request->get('relation');
        if (!$data['slug']) {
            $data['slug'] = str_slug($data['title']);
        }
        return $data;
    }
}