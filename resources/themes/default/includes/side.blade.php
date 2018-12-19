<div class="nav-tabs-wrapper">
    <ul class="nav nav-tabs">
        <li class="active_tab" route="{{route('frontend.admin.dashboard')}}">
            <a class="{{Request::is('admin/control/dashboard') ? 'active' : ''}}"  href="{{route('frontend.admin.dashboard')}}" data-toggle="tab">Dashboard</a>
        </li>
        <li class="active_tab" route="{{route('frontend.admin.control')}}">
            <a class="{{Request::is('admin/control/page*') ? 'active' : ''}}" href="{{route('frontend.admin.control')}}" data-toggle="tab">Pages</a>
        </li>
        <li class="active_tab" route="{{route('frontend.admin.menu')}}">
            <a class="{{Request::is('admin/control/menu*') ? 'active' : ''}}" href="{{route('frontend.admin.menu')}}" data-toggle="tab">Menus</a>
        </li>
    </ul>
</div>
