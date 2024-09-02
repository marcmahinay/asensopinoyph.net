<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="assets/images/logo-sm.png" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="assets/images/logo-dark.png" alt="" height="70">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="assets/images/logo-light.png" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/dashboard">
                        <i data-feather="home" class="icon-dual"></i> <span data-key="t-dashboards">Dashboards</span>
                    </a>
                </li> <!-- end Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps">
                        <i data-feather="grid" class="icon-dual"></i> <span data-key="t-apps">Beneficiaries</span>
                    </a>

                </li>


                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i data-feather="map-pin" class="icon-dual"></i> <span data-key="t-apps">Localities</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/provinces" class="nav-link" data-key="t-calendar"> Province </a>
                            </li>
                            <li class="nav-item">
                                <a href="/municities" class="nav-link" data-key="t-chat"> Municipality / City </a>
                            </li>

                            <li class="nav-item">
                                <a href="/barangays" class="nav-link" data-key="t-api-key">Barangay</a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i data-feather="grid" class="icon-dual"></i> <span data-key="t-apps">Assistance</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="apps-calendar.html" class="nav-link" data-key="t-calendar"> Assistance Type </a>
                            </li>
                            <li class="nav-item">
                                <a href="apps-chat.html" class="nav-link" data-key="t-chat"> Assis </a>
                            </li>

                            <li class="nav-item">
                                <a href="apps-api-key.html" class="nav-link" data-key="t-api-key">Barangay</a>
                            </li>
                        </ul>
                    </div>
                </li> --}}

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                        <i data-feather="heart" class="icon-dual"></i> <span data-key="t-layouts">Assistance</span> <span class="badge badge-pill bg-danger" data-key="t-hot">Hot</span>
                    </a>
                </li> <!-- end Dashboard Menu -->


                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                        <i data-feather="tag" class="icon-dual"></i> <span data-key="t-layouts">Voucher</span> <span class="badge badge-pill bg-danger" data-key="t-hot">Hot</span>
                    </a>
                </li> <!-- end Dashboard Menu -->



                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-components">Administration</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarUI">
                        <i data-feather="users" class="icon-dual"></i> <span data-key="t-base-ui">Users</span>
                    </a>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
