<!-- Reports -->
<div class="container mt-4 py-5">
    <div class="row text-center">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x text-primary mb-3"></i>
                    <h6 class="card-title">Generate Supplier Performance Report</h6>
                    <p class="card-text text-muted small">Create a report detailing the performance of suppliers based on delivery accuracy, product quality, and pricing.</p>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#supplierPerformanceReportModal">Generate Report</button>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x text-primary mb-3"></i>
                    <h6 class="card-title">Generate Order Summary Report</h6>
                    <p class="card-text text-muted small">Produce a summary of all purchase orders over a selected time range.</p>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#orderSummaryReportModal">Generate Report</button>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x text-primary mb-3"></i>
                    <h6 class="card-title">Generate Cost Analysis Report</h6>
                    <p class="card-text text-muted small">Compare procurement costs with allocated budgets and forecast future spending.</p>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#costAnalysisReportModal">Generate Report</button>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x text-primary mb-3"></i>
                    <h6 class="card-title">Export Report</h6>
                    <p class="card-text text-muted small">Export reports in PDF, CSV, or Excel formats for further analysis.</p>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exportReportModal">Export Report</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal 1: Generate Supplier Performance Report -->
<div class="modal fade" id="supplierPerformanceReportModal" tabindex="-1" aria-labelledby="supplierPerformanceReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="supplierPerformanceReportModalLabel">Generate Supplier Performance Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Generate Supplier Performance Report Form -->
                <form action="generate-supplier-performance-report.php" method="post">
                    <div class="mb-3">
                        <label for="supplierID" class="form-label">Supplier ID:</label>
                        <input type="text" id="supplierID" name="id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="reportDate" class="form-label">Report Date:</label>
                        <input type="date" id="reportDate" name="report_date" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Generate Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal 2: Generate Order Summary Report -->
<div class="modal fade" id="orderSummaryReportModal" tabindex="-1" aria-labelledby="orderSummaryReportModalLabel" aria -hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderSummaryReportModalLabel">Generate Order Summary Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Generate Order Summary Report Form -->
                <form action="generate-order-summary-report.php" method="post">
                    <div class="mb-3">
                        <label for="startDate" class="form-label">Start Date:</label>
                        <input type="date" id="startDate" name="start_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="endDate" class="form-label">End Date:</label>
                        <input type="date" id="endDate" name="end_date" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Generate Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal 3: Generate Cost Analysis Report -->
<div class="modal fade" id="costAnalysisReportModal" tabindex="-1" aria-labelledby="costAnalysisReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="costAnalysisReportModalLabel">Generate Cost Analysis Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Generate Cost Analysis Report Form -->
                <form action="generate-cost-analysis-report.php" method="post">
                    <div class="mb-3">
                        <label for="startDate" class="form-label">Start Date:</label>
                        <input type="date" id="startDate" name="start_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="endDate" class="form-label">End Date:</label>
                        <input type="date" id="endDate" name="end_date" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Generate Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal 4: Export Report -->
<div class="modal fade" id="exportReportModal" tabindex="-1" aria-labelledby="exportReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportReportModalLabel">Export Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Export Report Form -->
                <form action="export-report.php" method="post">
                    <div class="mb-3">
                        <label for="reportType" class="form-label">Report Type:</label>
                        <select id="reportType" name="report_type" class="form-select" required>
                            <option value="">Select Report Type</option>
                            <option value="pdf">PDF</option>
                            <option value="csv">CSV</option>
                            <option value="excel">Excel</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Export Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>