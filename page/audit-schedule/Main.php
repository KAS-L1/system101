    <?php
    include_once('api/middleware/role_access.php');
    // Retrieve all Audit Schedules from the `audit_schedule` table
    $auditSchedules = $DB->SELECT("audit_schedule", "*", "ORDER BY audit_id DESC");
    ?>

    <!-- Audit Schedule Table Section -->
    <div class="container mt-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center bg-light text-success">
                <h5 class="card-title mb-0">Audit Schedule Management</h5>
                <!-- Button to Generate Report and Add Audit Schedule -->
                <div>
                    <a href="/api/audit/generate_report.php" class="btn btn-success">
                        <i class="bi bi-download"></i>
                    </a>
                    <button class="btn btn-primary" id="btnAddAuditSchedule">
                        <i class="bi bi-plus"></i> Add
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTableAudit" class="table table-bordered table-hover table-sm shadow-sm">
                        <thead class="table-success">
                            <tr>
                                <th>#</th>
                                <th>Audit ID</th>
                                <th>Type</th>
                                <th>Scheduled Date</th>
                                <th>Status</th>
                                <th>Department</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($auditSchedules as $audit) {
                                $audit_id = htmlspecialchars($audit['audit_id']);
                                $audit_type = htmlspecialchars($audit['audit_type']);
                                $scheduled_date = htmlspecialchars($audit['scheduled_date']);
                                $status = htmlspecialchars($audit['status']);
                                $department = htmlspecialchars($audit['department']);
                                $remarks = htmlspecialchars($audit['remarks']);

                                // Badge class for different statuses
                                $badgeClass = $status === 'Completed' ? 'bg-success' : ($status === 'Cancelled' ? 'bg-danger' : 'bg-secondary');
                            ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $audit_id; ?></td>
                                    <td><?= $audit_type; ?></td>
                                    <td><?= $scheduled_date; ?></td>
                                    <td><span class="badge <?= $badgeClass; ?>"><?= $status; ?></span></td>
                                    <td><?= $department; ?></td>
                                    <td><?= $remarks; ?></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <!-- Reschedule Button -->
                                            <button class="btn btn-sm btn-light shadow-sm rescheduleAudit" data-audit_id="<?= $audit_id; ?>">
                                                <i class="bi bi-calendar-event"></i>
                                            </button>

                                            <!-- Mark as In Progress -->
                                            <?php if ($status == "Scheduled") { ?>
                                                <button class="btn btn-sm btn-success shadow-sm markInProgress" data-audit_id="<?= $audit_id; ?>">
                                                    <i class="bi bi-play-circle"></i>
                                                </button>
                                            <?php } else { ?>
                                                <button class="btn btn-sm btn-success shadow-sm" disabled>
                                                    <i class="bi bi-play-circle"></i>
                                                </button>
                                            <?php } ?>

                                            <!-- Mark as Completed -->
                                            <?php if ($status == "In Progress") { ?>
                                                <button class="btn btn-sm btn-success shadow-sm markComplete" data-audit_id="<?= $audit_id; ?>">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            <?php } else { ?>
                                                <button class="btn btn-sm btn-success shadow-sm" disabled>
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            <?php } ?>

                                            <!-- Cancel Audit -->
                                            <?php if ($status != "Cancelled" && $status != "Completed") { ?>
                                                <button class="btn btn-sm btn-danger shadow-sm cancelAudit" data-audit_id="<?= $audit_id; ?>">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            <?php } else { ?>
                                                <button class="btn btn-sm btn-danger shadow-sm" disabled>
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add Audit Schedule Button Click Event to load the create modal
        $('#btnAddAuditSchedule').click(function() {
            $.post('api/audit-schedule/create_modal.php', function(res) {
                $('#responseModal').html(res);
                $('#addAuditScheduleModal').modal('show');
            });
        });

        // Reschedule Audit Event
        $('.rescheduleAudit').click(function() {
            const audit_id = $(this).data('audit_id');
            $.post('api/audit-schedule/reschedule_modal.php', {
                audit_id
            }, function(res) {
                $('#responseModal').html(res);
                $('#rescheduleAuditModal').modal('show');
            });
        });

        // Mark as In Progress Event
        $('.markInProgress').click(function() {
            const audit_id = $(this).data('audit_id');
            $.post('api/audit-schedule/mark_in_progress.php', {
                audit_id
            }, function(response) {
                $('#response').html(response);
            });
        });

        // Mark as Completed Event
        $('.markComplete').click(function() {
            const audit_id = $(this).data('audit_id');
            $.post('api/audit-schedule/mark_complete.php', {
                audit_id
            }, function(response) {
                $('#response').html(response);
            });
        });

        // Cancel Audit Event
        $('.cancelAudit').click(function() {
            const audit_id = $(this).data('audit_id');
            $.post('api/audit-schedule/cancel.php', {
                audit_id
            }, function(response) {
                $('#response').html(response);
            });
        });
    </script>

    <!-- Placeholder for dynamically loaded modals -->
    <div id="responseModal"></div>
    <div id="response"></div>