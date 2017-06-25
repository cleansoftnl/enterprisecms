<?php namespace WebEd\Plugins\ContactForm\Http\DataTables;

use WebEd\Base\Http\DataTables\AbstractDataTables;
use WebEd\Plugins\ContactForm\Models\Contact;
use Yajra\Datatables\Engines\CollectionEngine;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Engines\QueryBuilderEngine;

class ContactsListDataTable extends AbstractDataTables
{
    protected $model;

    public function __construct()
    {
        $this->model = Contact::select('id', 'created_at', 'title', 'name', 'email', 'status');
    }

    public function headings()
    {
        return [
            'title' => [
                'title' => trans('webed-core::datatables.heading.title'),
                'width' => '25%',
            ],
            'name' => [
                'title' => trans('webed-contact-form::datatables.name'),
                'width' => '15%',
            ],
            'email' => [
                'title' => trans('webed-contact-form::datatables.email'),
                'width' => '15%',
            ],
            'status' => [
                'title' => trans('webed-core::datatables.heading.status'),
                'width' => '10%',
            ],
            'created_at' => [
                'title' => trans('webed-core::datatables.heading.created_at'),
                'width' => '10%',
            ],
            'actions' => [
                'title' => trans('webed-core::datatables.heading.actions'),
                'width' => '20%',
            ],
        ];
    }

    public function columns()
    {
        return [
            ['data' => 'id', 'name' => 'id', 'searchable' => false, 'orderable' => false],
            ['data' => 'title', 'name' => 'title'],
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'email', 'name' => 'email'],
            ['data' => 'status', 'name' => 'status'],
            ['data' => 'created_at', 'name' => 'created_at', 'searchable' => false],
            ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
        ];
    }

    /**
     * @return string
     */
    public function run()
    {
        $this->setAjaxUrl(route('admin::contact-forms.index.post'), 'POST');

        $this
            ->addFilter(1, form()->text('title', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]));

        $this
            ->addFilter(1, form()->text('title', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(2, form()->text('name', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(3, form()->text('email', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]))
            ->addFilter(4, form()->select('status', [
                'read' => trans('webed-contact-form::datatables.statuses.read'),
                'unread' => trans('webed-contact-form::datatables.statuses.unread'),
            ], null, [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]));

        $this->withGroupActions([
            '' => trans('webed-core::datatables.select') . '...',
            'read' => trans('webed-contact-form::datatables.group_actions.read'),
            'unread' => trans('webed-contact-form::datatables.group_actions.unread'),
            'deleted' => trans('webed-core::datatables.delete_these_items'),
        ]);

        return $this->view();
    }

    /**
     * @return CollectionEngine|EloquentEngine|QueryBuilderEngine|mixed
     */
    protected function fetchDataForAjax()
    {
        return datatable()->of($this->model)
            ->rawColumns(['actions'])
            ->editColumn('id', function ($item) {
                return form()->customCheckbox([['id[]', $item->id]]);
            })
            ->editColumn('status', function ($item) {
                $statusType = $item->status == 'unread' ? 'danger' : 'green';
                return html()->label(trans('webed-contact-form::datatables.statuses.' . $item->status), $statusType);
            })
            ->addColumn('actions', function ($item) {
                /*Edit link*/
                $deleteLink = route('admin::contact-forms.delete.delete', ['id' => $item->id]);

                $editBtn = link_to(route('admin::contact-forms.edit.get', ['id' => $item->id]), trans('webed-core::datatables.view'), ['class' => 'btn btn-sm btn-outline green']);
                $deleteBtn = form()->button(trans('webed-core::datatables.delete'), [
                    'title' => trans('webed-core::datatables.delete_this_item'),
                    'data-ajax' => $deleteLink,
                    'data-method' => 'DELETE',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline red-sunglo btn-sm ajax-link',
                    'type' => 'button',
                ]);

                return $editBtn . $deleteBtn;
            });
    }
}
