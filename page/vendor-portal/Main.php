<?php

$data = file_get_contents('http://127.0.0.15/api/sync/procurement.php?token=d368051b3cd2819131fff6811cf4e59c');
$data = json_decode($data, true);

?>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id='dataTable1' class="table">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>Requisition ID</th>
                        <th>Department</th>
                        <th>Item Description</th>
                        <th>Quantity</th>
                        <th>Unit of Measure</th>
                        <th>Priority Level</th>
                        <th>Requested Date</th>
                        <th>Required Date</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th>Actions</th> <!-- Added column header for actions -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1; // Initialize counter
                    foreach ($data as $datas) {
                    ?>
                        <tr>
                            <th><?= $i++; ?></th>
                            <td><?= $datas['requisition_id']; ?></td>
                            <td><?= $datas['department']; ?></td>
                            <td><?= $datas['item_description']; ?></td>
                            <td><?= $datas['quantity']; ?></td>
                            <td><?= $datas['unit_of_measure']; ?></td>
                            <td><?= $datas['priority_level']; ?></td>
                            <td><?= $datas['requested_date']; ?></td>
                            <td><?= $datas['required_date']; ?></td>
                            <td>
                                <?php if ($datas['status'] == "Approve") { ?>
                                    <span class="badge bg-success">Approve</span>
                                <?php } elseif ($datas['status'] == "Decline") { ?>
                                    <span class="badge bg-danger">Decline</span>
                                <?php } else { ?>
                                    <span class="badge bg-secondary">Pending</span>
                                <?php } ?>
                            </td>
                            <td><?= $datas['remarks']; ?></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <!-- Edit Button -->
                                    <button class="btn btn-sm btn-light shadow-sm editRequisition"
                                        data-requisition_id="<?= $datas['requisition_id']; ?>">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <!-- Approve Button -->
                                    <?php if ($datas['status'] != "Approve") { ?>
                                        <button class="btn btn-sm btn-success shadow-sm approveRequisition"
                                            data-requisition_id="<?= $datas['requisition_id']; ?>">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    <?php } else { ?>
                                        <button class="btn btn-sm btn-success shadow-sm" disabled>
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    <?php } ?>
                                    <!-- Reject Button -->
                                    <?php if ($datas['status'] != "Decline") { ?>
                                        <button class="btn btn-sm btn-danger shadow-sm declineRequisition"
                                            data-requisition_id="<?= $datas['requisition_id']; ?>">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    <?php } else { ?>
                                        <button class="btn btn-sm btn-danger shadow-sm" disabled>
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    <?php } ?>
                                    <!-- Remove Button -->
                                    <button class="btn btn-sm btn-warning shadow-sm removeRequisition"
                                        data-requisition_id="<?= $datas['requisition_id']; ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php } // End of foreach loop 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>