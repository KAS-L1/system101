<?php require("../../app/init.php"); ?>

<!-- Container for Report Section -->
<div class="container mt-5">
    <!-- Report Header Section -->
    <div class="row justify-content-center mb-4">
        <div class="col-12 text-center">
            <h2 class="text-success">Budget Approval Report</h2>
            <p class="text-muted">Generate and review budget approval reports based on various filters.</p>
        </div>
    </div>

    <!-- Report Filter Section -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="row">
                <!-- Approval Status Filter -->
                <div class="col-md-3 mb-3">
                    <label for="approvalStatusFilter" class="form-label fw-bold">Approval Status</label>
                    <select class="form-select" id="approvalStatusFilter">
                        <option value="All">All</option>
                        <option value="Approved">Approved</option>
                        <option value="Pending">Pending</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>
                <!-- Approved By Filter -->
                <div class="col-md-3 mb-3">
                    <label for="approvedByFilter" class="form-label fw-bold">Approved By</label>
                    <input type="text" class="form-control" id="approvedByFilter" placeholder="Enter approver name">
                </div>
                <!-- Start Date Filter -->
                <div class="col-md-3 mb-3">
                    <label for="startDateFilter" class="form-label fw-bold">Start Date</label>
                    <input type="date" class="form-control" id="startDateFilter">
                </div>
                <!-- End Date Filter -->
                <div class="col-md-3 mb-3">
                    <label for="endDateFilter" class="form-label fw-bold">End Date</label>
                    <input type="date" class="form-control" id="endDateFilter">
                </div>
            </div>
            <!-- Export Button Section -->
            <div class="row">
                <div class="col-12 text-end">
                    <button class="btn btn-success" id="exportBtn"><i class="bi bi-download"></i> Export as CSV</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Approval Report Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Approval Report</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="reportTable" class="table table-striped table-hover table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Approval ID</th>
                            <th>Requisition ID</th>
                            <th>Approved Amount</th>
                            <th>Approval Status</th>
                            <th>Approved By</th>
                            <th>Approval Date</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Retrieve all Budget Approvals from the `budget_approval` table
                        $approvals = $DB->SELECT("budget_approval", "*", "ORDER BY approval_id DESC");
                        $i = 1;
                        foreach ($approvals as $approval) {
                        ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= CHARS($approval['approval_id']); ?></td>
                            <td><?= CHARS($approval['requisition_id']); ?></td>
                            <td><?= number_format($approval['approved_amount'], 2); ?></td>
                            <td>
                                <?php if ($approval['approval_status'] == 'Approved') { ?>
                                <span class="badge bg-success">Approved</span>
                                <?php } elseif ($approval['approval_status'] == 'Rejected') { ?>
                                <span class="badge bg-danger">Rejected</span>
                                <?php } else { ?>
                                <span class="badge bg-secondary">Pending</span>
                                <?php } ?>
                            </td>
                            <td><?= CHARS($approval['approved_by']); ?></td>
                            <td><?= CHARS($approval['approval_date']); ?></td>
                            <td><?= CHARS($approval['approval_comments']); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to Handle Filters and Table Update -->
<script>
// Filter variables
const statusFilter = document.getElementById('approvalStatusFilter');
const approvedByFilter = document.getElementById('approvedByFilter');
const startDateFilter = document.getElementById('startDateFilter');
const endDateFilter = document.getElementById('endDateFilter');

// Event listeners for filtering
statusFilter.addEventListener('change', filterTable);
approvedByFilter.addEventListener('input', filterTable);
startDateFilter.addEventListener('change', filterTable);
endDateFilter.addEventListener('change', filterTable);

function filterTable() {
    const rows = document.querySelectorAll('#reportTable tbody tr');
    rows.forEach(row => {
        const status = row.children[4].textContent.trim();
        const approvedBy = row.children[5].textContent.trim();
        const approvalDate = row.children[6].textContent.trim();

        let showRow = true;

        // Filter by status
        if (statusFilter.value !== 'All' && statusFilter.value !== status) {
            showRow = false;
        }

        // Filter by approver name
        if (approvedByFilter.value && !approvedBy.toLowerCase().includes(approvedByFilter.value
                .toLowerCase())) {
            showRow = false;
        }

        // Filter by date range
        const date = new Date(approvalDate);
        const startDate = startDateFilter.value ? new Date(startDateFilter.value) : null;
        const endDate = endDateFilter.value ? new Date(endDateFilter.value) : null;

        if (startDate && date < startDate) {
            showRow = false;
        }
        if (endDate && date > endDate) {
            showRow = false;
        }

        // Toggle row visibility
        row.style.display = showRow ? '' : 'none';
    });
}

// Export table data as CSV
document.getElementById('exportBtn').addEventListener('click', function() {
    let csv = [];
    const rows = document.querySelectorAll("#reportTable tr");

    for (let i = 0; i < rows.length; i++) {
        const row = [],
            cols = rows[i].querySelectorAll("td, th");

        for (let j = 0; j < cols.length; j++) {
            // Remove commas and newlines from column data to ensure CSV formatting integrity
            row.push(cols[j].innerText.replace(/,/g, '').replace(/\n/g, ' '));
        }

        csv.push(row.join(","));
    }

    // Create CSV file and download
    const csvFile = new Blob([csv.join("\n")], {
        type: "text/csv"
    });
    const downloadLink = document.createElement("a");
    downloadLink.download = "budget_approval_report.csv";
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
});
</script>