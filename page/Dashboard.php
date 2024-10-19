<?php 
if (AUTH_USER['role'] != "ADMIN") {
    if (AUTH_USER['role'] == "VENDOR") {
        redirectUrl("/vendor-portal");
    } elseif (AUTH_USER['role'] == "KITCHEN") {
        redirectUrl("/kitchen-portal");
    }
}

// Retrieve all products from the `vendor_products` table
    $products = $DB->SELECT("vendor_products", "*");
 // Retrieve all RFQs from the `rfqs` table
    $rfqs = $DB->SELECT("rfqs", "*");

// Count purchase per month
$query_purchase_months = "MONTH(order_date) AS month, SUM(unit_price) AS total";
$months_purchase_data = $DB->SELECT('purchaseorder', $query_purchase_months, 'WHERE order_date IS NOT NULL GROUP BY MONTH(order_date)  ORDER BY order_date ASC');

// Prepare the months and totals arrays
$purchase_months = [];
$purchase_totals = [];

foreach ($months_purchase_data as $row) {
    $purchase_months[] = date('F', mktime(0, 0, 0, $row['month'], 10)); // Convert month number to month name
    $purchase_totals[] = $row['total'];
}

$purchase_totals = implode(",", $purchase_totals);
$purchase_months = implode(",", array_map(function($month) {
    return "'" . $month . "'";
}, $purchase_months));

// Count requisitions per month
$query_requisitions_months = "MONTH(requested_date) AS month, SUM(quantity) AS total";
$months_requisitions = $DB->SELECT('purchaserequisition', $query_requisitions_months, 'WHERE requested_date IS NOT NULL GROUP BY MONTH(requested_date) ORDER BY requested_date ASC');

// Prepare the months and totals arrays
$requisitions_months = [];
$requisitions_totals = [];

foreach ($months_requisitions as $row) {
    $requisitions_months[] = date('F', mktime(0, 0, 0, $row['month'], 10)); // Convert month number to month name
    $requisitions_totals[] = $row['total'];
}

$requisitions_totals = implode(",", $requisitions_totals);
$requisitions_months = implode(",", array_map(function($month) {
    return "'" . $month . "'";
}, $requisitions_months));

// Fetch product data for the pie chart
$query_product_data = "SELECT product_name, availability FROM vendor_products";
$products_data = $DB->SELECT('vendor_products', '*', ''); // Adjust based on your DB SELECT method

$product_names = [];
$product_availabilities = [];

foreach ($products_data as $row) {
    $product_names[] = "'" . $row['product_name'] . "'"; // Prepare names for JavaScript
    $product_availabilities[] = $row['availability']; // Prepare availabilities for JavaScript
}

$product_names = implode(",", $product_names);
$product_availabilities = implode(",", $product_availabilities);
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Hi, <?= AUTH_USER['firstname'] ?></h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>

        <!-- Row for Charts -->
        <div class="row">
            <!-- Card 1: Bar Chart -->
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light text-success">
                        <i class="fas fa-chart-bar me-1"></i> Purchase Order
                    </div>
                    <div class="card-body">
                        <canvas id="purchaseChart" style="width: 100%; height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Card 2: Line Chart -->
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light text-success">
                        <i class="fas fa-chart-line me-1"></i> Purchase Requisition
                    </div>
                    <div class="card-body">
                        <canvas id="requisitionsChart" style="width: 100%; height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Card 3: Pie Chart -->
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light text-success">
                        <i class="fas fa-chart-pie me-1"></i> Vendor Porducts
                    </div>
                    <div class="card-body">
                        <canvas id="productChart" style="width: 100%; height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

          <!-- RFQ Management Table Card -->
            <div class="container mt-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light text-success">
                        <h5 class="mb-0">RFQ Management and Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable3" class="table table-bordered table-hover table-sm mb-0 shadow-sm">
                                <thead class="table-success">
                                    <tr>
                                        <th>#</th>
                                        <th>RFQ ID</th>
                                        <th>Vendor Name</th>
                                        <th>Product Name</th>
                                        <th>Requested Quantity</th>
                                        <th>Quoted Price</th>
                                        <th>RFQ Status</th>
                                        <th>Response Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($rfqs as $rfq): ?>
                                        <?php
                                        // Selecting vendor name based on vendor_id
                                        $vendor_name = $DB->SELECT_ONE_WHERE("vendors", "vendor_name", array("vendor_id" => $rfq['vendor_id']));
                                        $vendorName = $vendor_name ? CHARS($vendor_name['vendor_name']) : 'Unknown Vendor';

                                        // Selecting product name based on product_id
                                        $product_name = $DB->SELECT_ONE_WHERE("vendor_products", "product_name", array("product_id" => $rfq['product_id']));
                                        $productName = $product_name ? CHARS($product_name['product_name']) : 'Unknown Product';
                                        ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $rfq['rfq_id']; ?></td>
                                            <td><?= $vendorName ?></td>
                                            <td><?= $productName ?></td>
                                            <td><?= $rfq['requested_quantity']; ?></td>
                                            <td><?= NUMBER_PHP_2($rfq['quoted_price']); ?></td>
                                            <td>
                                                <?php if ($rfq['rfq_status'] == 'Approved'): ?>
                                                    <span class="badge bg-success"><?= $rfq['rfq_status']; ?></span>
                                                <?php elseif ($rfq['rfq_status'] == 'Rejected'): ?>
                                                    <span class="badge bg-danger"><?= $rfq['rfq_status']; ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary"><?= $rfq['rfq_status']; ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $rfq['response_date']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Bar Chart Configuration
        var purchase_chart = document.getElementById('purchaseChart').getContext('2d');
        var barChart = new Chart(purchase_chart, {
            type: 'bar',
            data: {
                labels: [<?= $purchase_months ?>],
                datasets: [{
                    label: 'Purchase (₱)',
                    data: [<?= $purchase_totals ?>],
                    backgroundColor: 'rgba(40, 167, 69, 0.2)', // Bootstrap success color
                    borderColor: 'rgba(40, 167, 69, 1)', // Bootstrap success color
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Make chart fill container properly
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Line Chart Configuration
        var requisitions_chart = document.getElementById('requisitionsChart').getContext('2d');
        var lineChart = new Chart(requisitions_chart, {
            type: 'line',
            data: {
                labels: [<?= $requisitions_months ?>],
                datasets: [{
                    label: 'Quantity',
                    data: [<?= $requisitions_totals ?>],
                    borderColor: 'rgba(40, 167, 69, 1)', // Bootstrap success color
                    backgroundColor: 'rgba(40, 167, 69, 0.2)', // Bootstrap success color
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Ensure chart fits container properly
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Pie Chart Configuration
        var product_chart = document.getElementById('productChart').getContext('2d');
        var pieChart = new Chart(product_chart, {
            type: 'pie',
            data: {
                labels: [<?= $product_names ?>], // Product names from database
                datasets: [{
                    data: [<?= $product_availabilities ?>], // Availability values from database
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.8)', // Bootstrap success color
                        'rgba(23, 162, 184, 0.8)', // Bootstrap info color
                        'rgba(255, 193, 7, 0.8)', // Bootstrap warning color
                        'rgba(220, 53, 69, 0.8)' // Bootstrap danger color
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Ensure chart fills container properly
                plugins: {
                    legend: {
                        position: 'top', // Show legend at the top
                    }
                }
            }
        });
    });
</script>
