<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading text-muted">Core</div>
                    <a class="nav-link text-dark" href="/kitchen-portal">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <div class="sb-sidenav-menu-heading text-muted">Food & Beverage</div>
                    <a class="nav-link text-dark" href="/kitchen-order">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-utensils"></i></div>
                        Kitchen Order Management
                    </a>
                    <a class="nav-link text-dark" href="/menu-management">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-book-open"></i></div>
                        Menu Management
                    </a>
                    <a class="nav-link text-dark" href="/stock-management">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-warehouse"></i></div>
                        Stock Management
                    </a>
                    <a class="nav-link text-dark" href="/food-costing">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-money-bill-wave"></i></div>
                        Food Costing
                    </a>

                </div>
            </div>
            <div class="sb-sidenav-footer bg-light text-dark">
                <div class="small">Logged in as:</div>
                <div><?= AUTH_USER['role'] ?></div>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <!-- Your content here -->