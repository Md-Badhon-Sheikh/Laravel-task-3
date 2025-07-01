<!-- partial:partials/_sidebar.html -->
<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ url('/') }}" class="sidebar-brand">
            DBA<span>Clinic</span>
        </a>
        <div class="sidebar-toggler ">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Admin</li>
            <!--  Dashboard  -->
            <li class="nav-item {{ $data['active_menu'] == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link ">
                    <i class="fa-solid fa-chart-line"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <!-- member zone  -->
            <li
                class="nav-item {{ $data['active_menu'] == 'member_zone' ? 'active' : '' }}">
                <a class="nav-link"  href="{{route('admin.member-zone-type')}}" role="button" aria-expanded="false"
                    aria-controls="member-zone">
                    <i class="fa-regular fa-user"></i>
                    <span class="link-title">Member Zone Type Manage</span>
                </a>
            </li>
            <!-- Important links -->
            <li
                class="nav-item  {{ $data['active_menu'] == 'important_link_add' || $data['active_menu'] == 'link_edit' || $data['active_menu'] == 'link_list' ? 'active' : '' }}">
                <a class="nav-link" data-bs-toggle="collapse" href="#link" role="button" aria-expanded="false"
                    aria-controls="link">
                    <i class="fa-regular fa-user"></i>
                    <span class="link-title">Important Link Manage</span>
                    <i class="fa-solid fa-chevron-down link-arrow"></i>
                </a>
                <div class="collapse" id="link">
                    <ul class="nav sub-menu">
                        <li class="nav-item {{ $data['active_menu'] == 'link_add' ? 'active' : '' }}">
                            <a href="{{route('admin.link.add')}}"
                                class="nav-link  ">Link
                                Add</a>
                        </li>
                        <li class="nav-item {{ $data['active_menu'] == 'link_list' ? 'active' : '' }}">
                            <a href="{{route('admin.link.list')}}"
                                class="nav-link  ">Link List</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>

<!-- partial -->