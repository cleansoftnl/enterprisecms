<aside class="main-sidebar">
    <section class="sidebar">
        {{--@if(isset($loggedInUser))
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ get_image($loggedInUser->avatar) }}"
                         class="img-circle"
                         alt="{{ $loggedInUser->display_name or '' }}">
                </div>
                <div class="pull-left info">
                    <p>{{ $loggedInUser->display_name or '' }}</p>
                    <a href="{{ route('admin::users.edit.get', ['id' => $loggedInUser->id]) }}">
                        <i class="fa fa-circle text-success"></i>
                        Online
                    </a>
                </div>
            </div>
        @endif--}}
        @php $paneltype = get_panel_type()
        dd($paneltype);
        @endphp
        <ul class="sidebar-menu">
            {!! DashboardMenu::render($paneltype) !!}
        </ul>
    </section>
</aside>
