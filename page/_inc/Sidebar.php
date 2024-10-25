<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading text-muted">Core</div>
                    <a class="nav-link text-dark" href="index.php">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-tachometer-alt"></i></div>
                        Logistic Dashboard
                    </a>
                    <div class="sb-sidenav-menu-heading text-muted">Modules</div>
                    <a class="nav-link collapsed text-dark" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseProcurement" aria-expanded="false" aria-controls="collapseProcurement">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-shopping-cart"></i></div>
                        Procurement
                        <div class="sb-sidenav-collapse-arrow text-success"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseProcurement" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="/purchase-requistion">Purchase Requisition</a>
                            <a class="nav-link text-dark" href="/budget-approval">Budget Approval</a>
                            <a class="nav-link text-dark" href="/purchase-orders">Purchase Order</a>
                            <!-- <a class="nav-link text-dark" href="/suppliers">Suppliers</a> -->
                            <a class="nav-link text-dark" href="/vendor-request-for-qoute">Vendor Management & Request
                                for
                                Quote</a>
                            <a class="nav-link text-dark" href="/contract-management">Contract Management</a>
                            <a class="nav-link text-dark" href="/invoice-payment-management">Invoice</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed text-dark" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseAudit" aria-expanded="false" aria-controls="collapseAudit">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-file-alt"></i></div>
                        Audit Management
                        <div class="sb-sidenav-collapse-arrow text-success"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseAudit" aria-labelledby="headingTwo"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="layout-static.html">Audit Reports</a>
                            <a class="nav-link text-dark" href="layout-sidenav-light.html">Audit Schedules</a>
                            <a class="nav-link text-dark" href="layout-sidenav-light.html">Audit Logs</a>
                            <a class="nav-link text-dark" href="layout-sidenav-light.html">Audits (Filtered by Tags)</a>
                            <a class="nav-link text-dark" href="layout-sidenav-light.html">Audit Implementation</a>
                            <a class="nav-link text-dark" href="layout-sidenav-light.html">Audit Findings</a>
                            <a class="nav-link text-dark" href="layout-sidenav-light.html">Audit History</a>
                            <a class="nav-link text-dark" href="layout-sidenav-light.html">Reports</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed text-dark" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseDocument" aria-expanded="false" aria-controls="collapseDocument">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-file"></i></div>
                        Document Tracking
                        <div class="sb-sidenav-collapse-arrow text-success"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseDocument" aria-labelledby="headingThree"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="layout-static.html">Document List</a>
                            <a class="nav-link text-dark" href="layout-sidenav-light.html">Document Content</a>
                            <a class="nav-link text-dark" href="layout-sidenav-light.html">Document History</a>
                            <a class="nav-link text-dark" href="layout-sidenav-light.html">Search and Filtering</a>
                        </nav>
                    </div>

                    <div class="sb-sidenav-menu-heading text-muted">ADMIN ACCESS</div>
                    <a class="nav-link collapsed text-dark" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseAdmin" aria-expanded="false" aria-controls="collapseAdmin">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-file-alt"></i></div>
                        User Management
                        <div class="sb-sidenav-collapse-arrow text-success"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseAdmin" aria-labelledby="headingTwo"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="/user-management">User Accounts</a>
                        </nav>
                    </div>

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
                            <a class="nav-link text-dark" href="/vendor-purchase-orders">Purchase Orders</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="/vendor-request-for-qouted">Request for Quote</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="/vendor-product-catalog">Product Catalog</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="/vendor-invoice-payment-management">Invoice</a>
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
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="/chat">Chat</a>
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