<li class="dropdown messages-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="icon-envelope-open"></i>
        <span class="label label-success">{{ $count or 0 }}</span>
    </a>
    <ul class="dropdown-menu">
        <li class="header">You have {{ $count or 0 }} unread message(s)</li>
        <li class="footer"><a href="{{ route('admin::contact-forms.index.get') }}">See all messages</a></li>
    </ul>
</li>