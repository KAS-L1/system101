<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading text-muted">Vendor Portal</div>
                    <a class="nav-link collapsed text-dark" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseVendor" aria-expanded="false" aria-controls="collapseAdmin">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-store"></i></div>
                        Vendor Portal
                        <div class="sb-sidenav-collapse-arrow text-success"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseVendor" aria-labelledby="headingTwo"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="/vendor-portal">Dashboard</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="#">Purchase Orders</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="#">Request for Quote</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="#">Product Catalog</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="#">Invoice</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="#">Delivery and Shipment Updates</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="#">Vendor Performance Rating</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="#">Help and Support</a>
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