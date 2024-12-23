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
                            <a class="nav-link text-dark" href="/vendor-request-for-qoute">Request
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
                            <a class="nav-link text-dark" href="/audit-schedule">Audit Schedule</a>
                            <a class="nav-link text-dark" href="/audit-findings">Audit Findings</a>
                            <a class="nav-link text-dark" href="/audit-logs">Audit Logs</a>
                            <a class="nav-link text-dark" href="/audit-history">Audit History</a>
                            <a class="nav-link text-dark" href="/audit-report">Reports</a>
                        </nav>
                    </div>
                    <div>
                        <a class="nav-link text-dark" href="/document-tracking">
                            <div class="sb-nav-link-icon text-success"><i class="fas fa-file"></i></div>
                            Document Tracking
                        </a>
                    </div>
                    <div>
                        <!-- <a class="nav-link text-dark disabled" href="javascript:void(0);" style="pointer-events: none; color: grey; text-decoration: line-through;">
                            <div class="sb-nav-link-icon text-secondary"><i class="fas fa-analytics"></i></div>
                            Predictive Analytics
                        </a> -->
                        <a class="nav-link text-dark" href="/predictive-analytics">
                            <div class="sb-nav-link-icon text-success"><i class="fas fa-analytics"></i></div>
                            Predictive Analytics
                        </a>
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
                            <a class="nav-link text-dark" href="/delivery-updates">Delivery and Shipment Updates</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="#">Vendor Performance Rating</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="/help-support">Help and Support</a>
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
                            <a class="nav-link text-dark" href="/kitchen-order">Kitchen Order Management</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="/menu-management">Menu Management</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="/stock-management">Stock Management</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-dark" href="/food-costing">Food Costing</a>
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