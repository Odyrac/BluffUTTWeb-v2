<!-- Sidebar Start -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-center">
            <a href="./index.php" class="text-nowrap logo-img">
                <img src="./assets/images/logos/bluffutt.png" width="100" class="mt-4" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer mt-4 ms-4" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Accueil</span>
                </li>
                <li class="sidebar-item <?php if ($page == 'index') echo 'selected'; ?>">
                    <a class="sidebar-link <?php if ($page == 'index') echo 'active'; ?>" href="./index.php" aria-expanded="false">
                        <span>
                            <i class="ti ti-list-numbers"></i>
                        </span>
                        <span class="hide-menu">Classement</span>
                    </a>
                </li>
                <li class="sidebar-item <?php if ($page == 'champions') echo 'selected'; ?>">
                    <a class="sidebar-link <?php if ($page == 'champions') echo 'active'; ?>" href="./champions.php" aria-expanded="false">
                        <span>
                            <i class="ti ti-trophy"></i>
                        </span>
                        <span class="hide-menu">Champions</span>
                    </a>
                </li>
                <li class="sidebar-item <?php if ($page == 'statistics') echo 'selected'; ?>">
                    <a class="sidebar-link <?php if ($page == 'statistics') echo 'active'; ?>" href="./statistics.php" aria-expanded="false">
                        <span>
                            <i class="ti ti-chart-dots"></i>
                        </span>
                        <span class="hide-menu">Statistiques</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Divers</span>
                </li>
                <li class="sidebar-item <?php if ($page == 'help') echo 'selected'; ?>">
                    <a class="sidebar-link <?php if ($page == 'help') echo 'active'; ?>" href="./help.php" aria-expanded="false">
                        <span>
                            <i class="ti ti-help"></i>
                        </span>
                        <span class="hide-menu">Aide</span>
                    </a>
                </li>
                <li class="sidebar-item <?php if ($page == 'timer') echo 'selected'; ?>">
                    <a class="sidebar-link <?php if ($page == 'timer') echo 'active'; ?>" href="./timer.php" aria-expanded="false">
                        <span>
                            <i class="ti ti-clock"></i>
                        </span>
                        <span class="hide-menu">Timer</span>
                    </a>
                </li>
                <li class="sidebar-item <?php if ($page == 'panel') echo 'selected'; ?>">
                    <a class="sidebar-link <?php if ($page == 'panel') echo 'active'; ?>" href="./panel.php" aria-expanded="false">
                        <span>
                            <i class="ti ti-settings"></i>
                        </span>
                        <span class="hide-menu">Panel</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!--  Sidebar End -->