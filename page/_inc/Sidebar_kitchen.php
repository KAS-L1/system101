<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading text-muted">F&V</div>
                    <a class="nav-link collapsed text-dark" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseF&V" aria-expanded="false" aria-controls="collapseAdmin">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-carrot"></i></div>
                        Food & Beverage
                        <div class="sb-sidenav-collapse-arrow text-success"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseF&V" aria-labelledby="headingTwo"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="/kitchen-portal">Dashboard</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="#">Kitchen Order Management</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="#">Stock Management</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="#">Recipe Management</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="#">Food Costing</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="#">Waste Management</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="#">Reports & Analytics</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="#">Settings</a>
                        </nav>
                    </div>

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