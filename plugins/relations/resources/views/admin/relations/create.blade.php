@extends('webed-core::admin._master')

@section('css')

@endsection

@section('js')

@endsection

@section('js-init')
    <script type="text/javascript">
        $(document).ready(function () {
            WebEd.wysiwyg($('.js-wysiwyg'));
            $('.js-select2').select2();
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
                        <input required type="text" name="post[title]"
                               class="form-control"
                               value="{{ old('post.title') }}"
                               autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('webed-core::base.form.slug') }}</b>
                            <span class="required">*</span>
                        </label>
                        <input type="text" name="post[slug]"
                               class="form-control"
                               value="{{ old('post.slug') }}" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('webed-core::base.form.content') }}</b>
                        </label>
                        <textarea name="post[content]"
                                  class="form-control js-wysiwyg">{!! old('post.content') !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('webed-core::base.form.keywords') }}</b>
                        </label>
                        <input type="text" name="post[keywords]"
                               class="form-control js-tags-input"
                               value="{{ old('post.keywords') }}" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('webed-core::base.form.description') }}</b>
                        </label>
                        <textarea name="post[description]"
                                  class="form-control js-wysiwyg"
                                  data-toolbar="basic"
                                  data-height="200px"
                                  rows="5">{!! old('post.description') !!}</textarea>
                    </div>
                </div>
            </div>
            @php do_action(BASE_ACTION_META_BOXES, 'main', WEBED_RELATIONS_POSTS, null) @endphp
        </div>
        <div class="column right">
            @include('webed-core::admin._components.form-actions')
            @php do_action(BASE_ACTION_META_BOXES, 'top-sidebar', WEBED_RELATIONS_POSTS, null) @endphp
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
                    {!! form()->select('post[status]', [
                       'activated' => trans('webed-core::base.status.activated'),
                        'disabled' => trans('webed-core::base.status.disabled'),
                    ], old('post.status'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('webed-core::base.form.order') }}</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <input type="text" name="post[order]"
                           class="form-control"
                           value="{{ old('post.order', 0) }}" autocomplete="off">
                </div>
            </div>
            @include('webed-core::admin._widgets.page-templates', [
                'name' => 'post[page_template]',
                'templates' => get_templates('blog_post'),
                'selected' => old('post.page_template'),
            ])
            @include('webed-relations::admin._widgets.categories-multi', [
                'name' => 'categories[]',
                'title' => trans('relations::base.posts.form.categories'),
                'value' => old('categories', []),
                'categories' => $categories,
                'object' => null
            ])
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('relations') }}</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    {!! Form::select(
                            'post[category_id]',
                            $baseCategories,
                            old('post.category_id'),
                            ['class' => 'form-control']
                        )
                    !!}
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('relations') }}</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    {!! form()->select('tags[]', $tags, old('tags'), [
                        'multiple' => 'multiple',
                        'class' => 'form-control js-select2'
                    ]) !!}
                </div>
            </div>
            @include('webed-core::admin._widgets.thumbnail', [
                'name' => 'post[thumbnail]',
                'value' => old('post.thumbnail')
            ])
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('webed-core::base.form.is_featured') }}</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    {!! form()->customRadio('post[is_featured]', [
                        [0, trans('relations::base.posts.form.featured_no')],
                        [1, trans('relations::base.posts.form.featured_yes')]
                    ], old('post.is_featured', 0)) !!}
                </div>
            </div>
            @php do_action(BASE_ACTION_META_BOXES, 'bottom-sidebar', WEBED_RELATIONS_POSTS, null) @endphp
        </div>
    </div>
    {!! Form::close() !!}
@endsection
