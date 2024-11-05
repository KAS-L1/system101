<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading text-muted">Core</div>
                    <a class="nav-link text-dark" href="index.php">
                        <div class="sb-nav-link-icon text-success"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
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
                            <a class="nav-link text-dark" href="/audit-schedule">Audit Schedule/a>
                                <a class="nav-link text-dark" href="/audit-findings">Audit Findings</a>
                                <a class="nav-link text-dark" href="/audit-logs">Audit Logs</a>
                                <a class="nav-link text-dark" href="/audit-history">Audit History</a>
                                <a class="nav-link text-dark" href="/audit-report">Report</a>
                        </nav>
                    </div>
                    <div>
                        <a class="nav-link text-dark" href="/document-tracking">
                            <div class="sb-nav-link-icon text-success"><i class="fas fa-file"></i></div>
                            Document Tracking
                        </a>
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