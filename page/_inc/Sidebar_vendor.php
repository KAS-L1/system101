<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading text-muted">Vendor Portal</div>
                    <a class="nav-link text-dark" href="vendor_portal.php">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-store"></i></div>
                        Payment Method
                    </a>
        
                    <a class="nav-link text-dark" href="vendor_portal.php">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-store"></i></div>
                    Invoice
                    </a>
        
                    <a class="nav-link text-dark" href="vendor_portal.php">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-store"></i></div>
                    Tracking
                    </a>
    
                </div>
            </div>
            <div class="sb-sidenav-footer bg-light text-dark">
                <div class="small">Logged in as:</div>
                <div><?=AUTH_USER['role']?></div>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <!-- Your content here -->