@extends('webed-core::admin._master')

@section('css')

@endsection

@section('js')

@endsection

@section('js-init')

@endsection

@section('content')
    <div class="layout-1columns">
        <div class="column main">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="icon-layers font-dark"></i>
                        {{ trans('webed-contact-form::base.all_messages') }}
                    </h3>
                </div>
                <div class="box-body">
                    {!! $dataTable or '' !!}
                </div>
            </div>
            @php do_action('meta_boxes', 'main', 'webed-contact-form.index') @endphp
        </div>
    </div>
@endsection
