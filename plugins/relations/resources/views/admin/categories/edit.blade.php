@extends('webed-core::admin._master')

@section('css')

@endsection

@section('js')

@endsection

@section('js-init')
    <script type="text/javascript">
        $(document).ready(function () {
            WebEd.wysiwyg($('.js-wysiwyg'));
        });
    </script>
@endsection

@section('content')
    {!! Form::open(['class' => 'js-validate-form']) !!}
    <div class="layout-2columns sidebar-right">
        <div class="column main">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('webed-core::base.form.basic_info') }}</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('webed-core::base.form.title') }}</b>
                            <span class="required">*</span>
                        </label>
                        <input required type="text" name="category[title]"
                               class="form-control"
                               value="{{ $object->title or '' }}"
                               autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('webed-core::base.form.slug') }}</b>
                            <span class="required">*</span>
                        </label>
                        <input type="text" name="category[slug]"
                               class="form-control"
                               value="{{ $object->slug or '' }}" autocomplete="off">
                    </div>
                    @if($object->slug)
                        <div class="form-group">
                            <label class="control-label">
                                <b>{{ trans('webed-core::base.visit_page') }}&nbsp;</b>
                            </label>
                            <a href="{{ get_category_link($object) }}" target="_blank">
                                {{ get_category_link($object) }}
                            </a>
                        </div>
                    @endif
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('webed-core::base.form.content') }}</b>
                        </label>
                        <textarea name="category[content]"
                                  class="form-control js-wysiwyg">{!! $object->content or '' !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('webed-core::base.form.keywords') }}</b>
                        </label>
                        <input type="text" name="category[keywords]"
                               class="form-control js-tags-input"
                               value="{{ $object->keywords or '' }}" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('webed-core::base.form.description') }}</b>
                        </label>
                        <textarea name="category[description]"
                                  class="form-control js-wysiwyg"
                                  data-toolbar="basic"
                                  data-height="200px"
                                  rows="5">{!! $object->description or '' !!}</textarea>
                    </div>
                </div>
            </div>
            @php do_action(BASE_ACTION_META_BOXES, 'main', WEBED_RELATIONS_CATEGORIES, $object) @endphp
        </div>
        <div class="column right">
            @include('webed-core::admin._components.form-actions')
            @php do_action(BASE_ACTION_META_BOXES, 'top-sidebar', WEBED_RELATIONS_CATEGORIES, $object) @endphp
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('webed-core::base.form.status') }}</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    {!! form()->select('category[status]', [
                        'activated' => trans('webed-core::base.status.activated'),
                        'disabled' => trans('webed-core::base.status.disabled'),
                    ], $object->status, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('webed-core::base.form.order') }}</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <input type="text" name="category[order]"
                           class="form-control"
                           value="{{ $object->order or 0 }}" autocomplete="off">
                </div>
            </div>
            @include('webed-core::admin._widgets.page-templates', [
                'name' => 'category[page_template]',
                'templates' => get_templates('blog_category'),
                'selected' => isset($object) ? $object->page_template : '',
            ])
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('relations::base.categories.form.parent_category') }}</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    {!! Form::select(
                            'category[parent_id]',
                            $categories,
                            (isset($object->parent_id) ? $object->parent_id : null),
                            ['class' => 'form-control']
                        )
                    !!}
                </div>
            </div>
            @include('webed-core::admin._widgets.thumbnail', [
                'name' => 'category[thumbnail]',
                'value' => (isset($object->thumbnail) ? $object->thumbnail : null)
            ])
            @php do_action(BASE_ACTION_META_BOXES, 'bottom-sidebar', WEBED_RELATIONS_CATEGORIES, $object) @endphp
        </div>
    </div>
    {!! Form::close() !!}
@endsection
