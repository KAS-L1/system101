<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading text-muted">Core</div>
                    <a class="nav-link text-dark" href="/vendor-portal">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <div class="sb-sidenav-menu-heading text-muted">Vendor Portal</div>
                    <a class="nav-link text-dark" href="#purchase-orders">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-shopping-cart"></i></div>
                        Purchase Orders
                    </a>
                    <a class="nav-link text-dark" href="#request-for-quote">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-file-invoice-dollar"></i></div>
                        Request for Quote
                    </a>
                    <a class="nav-link text-dark" href="#product-catalog">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-list"></i></div>
                        Product Catalog
                    </a>
                    <a class="nav-link text-dark" href="#invoice">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-receipt"></i></div>
                        Invoice
                    </a>
                    <a class="nav-link text-dark" href="#delivery-shipment">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-truck"></i></div>
                        Delivery Updates
                    </a>
                    <a class="nav-link text-dark" href="#vendor-performance-rating">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-star"></i></div>
                        Vendor Performance Rating
                    </a>
                    <a class="nav-link text-dark" href="#help-support">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-question-circle"></i></div>
                        Help and Support
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
