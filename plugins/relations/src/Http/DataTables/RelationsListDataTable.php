<?php namespace WebEd\Modules\Relations\Http\DataTables;

use Illuminate\Database\Eloquent\Builder;
use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Modules\Relations\Models\Relation;
use Yajra\Datatables\Engines\CollectionEngine;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Engines\QueryBuilderEngine;

class RelationsListDataTable extends AbstractDataTables
{
    /**
     * @var Relation|Builder
     */
    protected $model;

    public function __construct()
    {
        $this->model = Relation::select('id', 'created_at', 'relationname', 'slug');
    }

    public function headings()
    {
        return [
            'id' => [
                'title' => 'ID',
                'width' => '5%',
            ],
            'relationname' => [
                'title' => trans('relations::base.datatables.heading.relationname'),
                'width' => '35%',
            ],
            'slug' => [
                'title' => trans('webed-core::datatables.heading.slug'),
                'width' => '20%',
            ],
            'created_at' => [
                'title' => trans('webed-core::datatables.heading.created_at'),
                'width' => '10%',
            ],
            'actions' => [
                'title' => trans('webed-core::datatables.heading.actions'),
                'width' => '30%',
            ],
        ];
    }

    public function columns()
    {
        return [
            ['data' => 'id', 'name' => 'id', 'searchable' => false, 'orderable' => false],
            ['data' => 'viewID', 'name' => 'id'],
            ['data' => 'relationname', 'name' => 'relationname'],
            ['data' => 'slug', 'name' => 'slug'],
            ['data' => 'created_at', 'name' => 'created_at', 'searchable' => false],
            ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
        ];
    }

    /**
     * @return string
     */
    public function run()
    {
        $this->setAjaxUrl(route('admin::relations.relations.index.post'), 'POST');

        $this
            ->addFilter(1, form()->text('id', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(2, form()->text('relationname', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(3, form()->select('slug', get_templates('slug'), null, [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(4, form()->select('status', [
                '' => '',
                'activated' => 'Activated',
                'disabled' => 'Disabled',
                'is_featured' => 'Featured'
            ], null, ['class' => 'form-control form-filter input-sm']));

        $this->withGroupActions([
            '' => trans('webed-core::datatables.select') . '...',
            'activated' => trans('webed-core::datatables.activate_these_items'),
            'disabled' => trans('webed-core::datatables.disable_these_items'),
        ]);

        return $this->view();
    }

    /**
     * @return CollectionEngine|EloquentEngine|QueryBuilderEngine|mixed
     */
    protected function fetchDataForAjax()
    {
        return datatable()->of($this->model)
            //'status'
            ->rawColumns(['actions'])
            /*
            ->filterColumn('status', function ($query, $keyword) {
                /**
                 * @var Relation|Builder $query
                 *  /
                if ($keyword === 'is_featured') {
                    return $query->where('is_featured', '=', 1);
                } else {
                    return $query->where('status', '=', $keyword);
                }
            })
            */
            ->addColumn('viewID', function ($item) {
                return $item->id;
            })
            ->editColumn('id', function ($item) {
                return form()->customCheckbox([['id[]', $item->id]]);
            })

/*
->addColumn('actions', function ($item) {
    $activeBtn = (!array_get($item, 'enabled')) ? form()->button(trans('webed-modules-management::datatables.active'), [
        'title' => trans('webed-modules-management::datatables.activate_this_plugin'),
        'data-ajax' => route('admin::plugins.change-status.post', [
            'module' => array_get($item, 'alias'),
            'status' => 1,
        ]),
        'data-method' => 'POST',
        'data-toggle' => 'confirmation',
        'class' => 'btn btn-outline green btn-sm ajax-link',
    ]) : '';

    $disableBtn = (array_get($item, 'enabled')) ? form()->button(trans('webed-modules-management::datatables.disable'), [
        'title' => trans('webed-modules-management::datatables.disable_this_plugin'),
        'data-ajax' => route('admin::plugins.change-status.post', [
            'module' => array_get($item, 'alias'),
            'status' => 0,
        ]),
        'data-method' => 'POST',
        'data-toggle' => 'confirmation',
        'class' => 'btn btn-outline yellow-lemon btn-sm ajax-link',
    ]) : '';

    $installBtn = (array_get($item, 'enabled') && !array_get($item, 'installed')) ? form()->button(trans('webed-modules-management::datatables.install'), [
        'title' => trans('webed-modules-management::datatables.install_this_plugin'),
        'data-ajax' => route('admin::plugins.install.post', [
            'module' => array_get($item, 'alias'),
        ]),
        'data-method' => 'POST',
        'data-toggle' => 'confirmation',
        'class' => 'btn btn-outline blue btn-sm ajax-link',
    ]) : '';

    $updateBtn = (
        array_get($item, 'enabled') &&
        array_get($item, 'installed') &&
        version_compare(array_get($item, 'installed_version'), array_get($item, 'version'), '<')
    )
        ? form()->button(trans('webed-modules-management::datatables.update'), [
            'title' => trans('webed-modules-management::datatables.update_this_plugin'),
            'data-ajax' => route('admin::plugins.update.post', [
                'module' => array_get($item, 'alias'),
            ]),
            'data-method' => 'POST',
            'data-toggle' => 'confirmation',
            'class' => 'btn btn-outline purple btn-sm ajax-link',
        ])
        : '';

    $uninstallBtn = (array_get($item, 'enabled') && array_get($item, 'installed')) ? form()->button(trans('webed-modules-management::datatables.uninstall'), [
        'title' => trans('webed-modules-management::datatables.uninstall_this_plugin'),
        'data-ajax' => route('admin::plugins.uninstall.post', [
            'module' => array_get($item, 'alias'),
        ]),
        'data-method' => 'POST',
        'data-toggle' => 'confirmation',
        'class' => 'btn btn-outline red-sunglo btn-sm ajax-link',
    ]) : '';

    return $activeBtn . $disableBtn . $installBtn . $updateBtn . $uninstallBtn;
});
 **/



            /*
            ->editColumn('status', function ($item) {
                $featured = ($item->is_featured) ? '<br><br>' . html()->label('featured', 'purple') : '';
                return html()->label(trans('webed-core::base.status.' . $item->status), $item->status) . $featured;
            })
            */
            ->addColumn('actions', function ($item) {
                /*Edit link*/
                $activeLink = route('admin::relations.relations.update-status.post', ['id' => $item->id, 'status' => 'activated']);
                $disableLink = route('admin::relations.relations.update-status.post', ['id' => $item->id, 'status' => 'disabled']);
                $deleteLink = route('admin::relations.relations.delete.delete', ['id' => $item->id]);

                /*Buttons*/
                $editBtn = link_to(route('admin::relations.relations.edit.get', ['id' => $item->id]), trans('webed-core::datatables.edit'), ['class' => 'btn btn-sm btn-outline green']);
                $activeBtn = ($item->status != 'activated') ? form()->button(trans('webed-core::datatables.active'), [
                    'title' => trans('webed-core::datatables.activate_this_item'),
                    'data-ajax' => $activeLink,
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline blue btn-sm ajax-link',
                    'type' => 'button',
                ]) : '';
                $disableBtn = ($item->status != 'disabled') ? form()->button(trans('webed-core::datatables.disable'), [
                    'title' => trans('webed-core::datatables.disable_this_item'),
                    'data-ajax' => $disableLink,
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline yellow-lemon btn-sm ajax-link',
                    'type' => 'button',
                ]) : '';
                $deleteBtn = form()->button(trans('webed-core::datatables.delete'), [
                    'title' => trans('webed-core::datatables.delete_this_item'),
                    'data-ajax' => $deleteLink,
                    'data-method' => 'DELETE',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline red-sunglo btn-sm ajax-link',
                    'type' => 'button',
                ]);

                return $editBtn . $activeBtn . $disableBtn . $deleteBtn;
            });
    }
}
