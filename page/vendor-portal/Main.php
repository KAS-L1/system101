<?php
include_once('api/middleware/role_access_vendor.php');

// Initialize database connection
try {
    $db = new Database(); // Create an instance of the Database class

    // Fetch new Purchase Orders (where status is 'Pending')
    $new_pos = $db->SELECT_WHERE('purchaseorder', '*', ['status' => 'Ordered']); // 'Ordered' indicates pending state

    // Fetch new RFQs (where rfq_status is 'Pending')
    $new_rfqs = $db->SELECT_WHERE('rfqs', '*', ['rfq_status' => 'Pending']);

    // Fetch recent contract updates
    $recent_contracts = $db->SELECT('contracts', '*', 'ORDER BY last_synced DESC LIMIT 5');

    // Fetch orders for the order status summary
    $orders = $db->SELECT('purchaseorder', '*', 'ORDER BY order_date DESC LIMIT 5'); // Adjusted to correct table name

    // Fetch recent activity log
    $recent_pos = $db->SELECT('purchaseorder', '*', 'ORDER BY order_date DESC LIMIT 5');
    $recent_rfqs = $db->SELECT('rfqs', '*', 'ORDER BY response_date DESC LIMIT 5');
    $recent_contracts_log = $db->SELECT('contracts', '*', 'ORDER BY last_synced DESC LIMIT 5');

    // Merge recent activities from different tables
    $recent_activities = [];
    foreach ([$recent_pos, $recent_rfqs, $recent_contracts_log] as $activitySet) {
        $recent_activities = array_merge($recent_activities, $activitySet);
    }
} catch (Exception $e) {
    // Handle database connection errors
    alert('danger', 'An error occurred while fetching data: ' . $e->getMessage());
}

?>

<div class="container mt-4 py-5">
    <!-- Card: Notifications -->
    <div class="row text-center">
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-file-invoice fa-3x text-success"></i>
                    </div>
                    <h6 class="card-title">New Purchase Orders</h6>
                    <p class="card-text text-muted small">Stay updated with alerts for new Purchase Orders (POs).</p>
                    <?php
                    if (!empty($new_pos)) {
                        $po = array_shift($new_pos); // Get the most recent PO
                        echo "<div class='alert alert-success consistent-alert' role='alert'>New Purchase Order (PO) received: <strong>PO #{$po['po_id']}</strong></div>";
                    } else {
                        echo "<div class='alert alert-info consistent-alert' role='alert'>No new Purchase Orders.</div>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Card: RFQs -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-paper-plane fa-3x text-success"></i>
                    </div>
                    <h6 class="card-title">Requests for Quotes (RFQs)</h6>
                    <p class="card-text text-muted small">Get notified for any new Requests for Quotes (RFQs).</p>
                    <?php
                    if (!empty($new_rfqs)) {
                        $rfq = array_shift($new_rfqs); // Get the most recent RFQ
                        echo "<div class='alert alert-success consistent-alert' role='alert'>New Request for Quote (RFQ): <strong>RFQ #{$rfq['rfq_id']}</strong></div>";
                    } else {
                        echo "<div class='alert alert-info consistent-alert' role='alert'>No new RFQs.</div>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Card: Contract Updates -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-file-contract fa-3x text-success"></i>
                    </div>
                    <h6 class="card-title">Contract Updates</h6>
                    <p class="card-text text-muted small">Stay informed about updates in contract terms.</p>
                    <?php
                    if (!empty($recent_contracts)) {
                        $contract = array_shift($recent_contracts); // Get the most recent contract update
                        echo "<div class='alert alert-success consistent-alert' role='alert'>Contract terms updated for <strong>Contract #{$contract['contract_id']}</strong>.</div>";
                    } else {
                        echo "<div class='alert alert-info consistent-alert' role='alert'>No recent contract updates.</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Status Summary Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light text-success">
                    <h5 class="mb-0">Order Status Summary</h5>
                </div>
                <div class="card-body">
                    <p class="card-text text-muted small">A concise view of current POs, including delivery deadlines and payment statuses.</p>
                    <div class="table-responsive">
                        <table id="dataTable1" class="table table-bordered">
                            <thead class="table table-success">
                                <tr>
                                    <th>PO Number</th>
                                    <th>Delivery Deadline</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($orders)) {
                                    foreach ($orders as $order) {
                                        echo "<tr>
                                            <td>PO #{$order['po_id']}</td>
                                            <td>{$order['delivery_date']}</td>
                                            <td>";
                                        
                                        // Using Bootstrap badge for status
                                        if ($order['status'] == 'Delivered') {
                                            echo "<span class='badge bg-success'>Delivered</span>";
                                        } elseif ($order['status'] == 'Cancelled') {
                                            echo "<span class='badge bg-danger'>Cancelled</span>";
                                        } else {
                                            echo "<span class='badge bg-secondary'>Ordered</span>";
                                        }
                                        
                                        echo "</td>
                                            <td>";
                                        
                                        // Using Bootstrap badge for payment status
                                        if ($order['sync_status'] == 'Paid') {
                                            echo "<span class='badge bg-success'>Paid</span>";
                                        } elseif ($order['sync_status'] == 'Pending') {
                                            echo "<span class='badge bg-secondary'>Pending</span>";
                                        } else {
                                            echo "<span class='badge bg-danger'>Unpaid</span>";
                                        }
                                        
                                        echo "</td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>No orders available.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Log Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light text-success">
                    <h5 class="mb-0">Recent Activity Log</h5>
                </div>
                <div class="card-body">
                    <p class="card-text text-muted small">A log of recent activities, showcasing acknowledged POs, RFQ responses, and invoicing updates.</p>
                    <ul class="list-group">
                        <?php
                        if (!empty($recent_activities)) {
                            foreach ($recent_activities as $activity) {
                                if (isset($activity['po_id'])) {
                                    echo "<li class='list-group-item'>Acknowledged PO #{$activity['po_id']} on {$activity['order_date']}</li>";
                                } elseif (isset($activity['rfq_id'])) {
                                    echo "<li class='list-group-item'>Responded to RFQ #{$activity['rfq_id']} on {$activity['response_date']}</li>";
                                } elseif (isset($activity['contract_id'])) {
                                    echo "<li class='list-group-item'>Updated contract terms for Contract #{$activity['contract_id']} on {$activity['last_synced']}</li>";
                                }
                            }
                        } else {
                            echo "<li class='list-group-item'>No recent activities.</li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS for consistent alert size -->
<style>
    .consistent-alert {
        padding: 10px 15px;
        font-size: 1rem;
        margin-top: 10px; /* Add margin for spacing between alerts */
        border-radius: 5px; /* Optional: round the corners of the alerts */
    }
    /* Adjust responsive behavior */
    @media (max-width: 576px) {
        .consistent-alert {
            font-size: 0.875rem; /* Smaller font size for mobile devices */
        }
    }
</style>
