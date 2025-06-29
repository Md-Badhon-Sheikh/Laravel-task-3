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
            <li
                class="nav-item {{ $data['active_menu'] == 'member-zone' || $data['active_menu'] == 'advocate_edit' || $data['active_menu'] == 'member-zone' ? 'active' : '' }}">
                <a class="nav-link"  href="{{route('admin.member-zone')}}" role="button" aria-expanded="false"
                    aria-controls="advocate">
                    <i class="fa-regular fa-user"></i>
                    <span class="link-title">Member Zone Manage</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- partial -->