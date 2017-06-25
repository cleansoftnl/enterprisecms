@extends('webed-core::admin._master')

@section('css')

@endsection

@section('js')

@endsection

@section('js-init')

@endsection

@section('content')
    {!! Form::open(['class' => 'js-validate-form']) !!}
    <div class="layout-2columns sidebar-right">
        <div class="column main">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('webed-core::base.form.basic_info') }}</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('webed-contact-form::base.form.title') }}</b>
                        </label>
                        <p>{{ $object->title or '...' }}</p>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('webed-contact-form::base.form.name') }}</b>
                        </label>
                        <p>{{ $object->name or '...' }}</p>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('webed-contact-form::base.form.email') }}</b>
                        </label>
                        <p>{{ $object->email or '...' }}</p>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('webed-contact-form::base.form.phone') }}</b>
                        </label>
                        <p>{{ $object->phone or '...' }}</p>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('webed-contact-form::base.form.address') }}</b>
                        </label>
                        <p>{{ $object->address or '...' }}</p>
                    </div>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('webed-contact-form::base.form.content') }}</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        {!! custom_strip_tags(nl2br($object->content)) !!}
                    </div>
                </div>
            </div>
            @if($object->options)
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('webed-contact-form::base.other_information') }}</h3>
                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            @foreach($object->options as $key => $option)
                                <div class="form-group">
                                    <label class="control-label">
                                        <b>{{ trans('webed-contact-form::options.' . $key) }}</b>
                                    </label>
                                    <p>{{ $option ?: '...' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="column right">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('webed-contact-form::base.form.status') }}</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        {!! form()->customRadio('contact_form[status]', [
                            ['unread', trans('webed-contact-form::base.statuses.unread')],
                            ['read', trans('webed-contact-form::base.statuses.read')],
                        ], $object->status) !!}
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('webed-contact-form::base.form.created_at') }}</b>
                        </label>
                        <p>{{ $object->created_at or '...' }}</p>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            <b>{{ trans('webed-contact-form::base.form.updated_at') }}</b>
                        </label>
                        <p>{{ $object->updated_at or '...' }}</p>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="text-right">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-check"></i> {{ trans('webed-core::base.form.save') }}
                        </button>
                        <button class="btn btn-success"
                                type="submit"
                                name="_continue_edit"
                                value="1">
                            <i class="fa fa-check"></i> {{ trans('webed-core::base.form.save_and_continue') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
