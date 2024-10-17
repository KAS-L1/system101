    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading text-muted">CORE</div>
                        <a class="nav-link text-dark" href="kitchen-portal">
                            <div class="sb-nav-link-icon text-success"><i class="fas fa-store"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading text-muted">Food & Beverage</div>
                        <a class="nav-link text-dark" href="kitchen-portal">w
                            <div class="sb-nav-link-icon text-success"><i class="fas fa-store"></i></div>
                            KOT
                        </a>

                        <a class="nav-link text-dark" href="vendor_portal.php">
                            <div class="sb-nav-link-icon text-success"><i class="fas fa-store"></i></div>
                            Stock
                        </a>

                        <a class="nav-link text-dark" href="vendor_portal.php">
                            <div class="sb-nav-link-icon text-success"><i class="fas fa-store"></i></div>
                            Mangement
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