<?php
include_once('api/middleware/role_access.php');

// Fetch data
$products = $DB->SELECT("vendor_products", "*");
$rfqs = $DB->SELECT("rfqs", "*");

// Monthly purchase data
$query_purchase_months = "MONTH(order_date) AS month, SUM(unit_price) AS total";
$months_purchase_data = $DB->SELECT('purchaseorder', $query_purchase_months, 'WHERE order_date IS NOT NULL GROUP BY MONTH(order_date) ORDER BY order_date ASC');

$purchase_months = [];
$purchase_totals = [];
foreach ($months_purchase_data as $row) {
    $purchase_months[] = date('F', mktime(0, 0, 0, $row['month'], 10));
    $purchase_totals[] = $row['total'];
}

$purchase_totals = implode(",", $purchase_totals);
$purchase_months = implode(",", array_map(function ($month) {
    return "'" . $month . "'";
}, $purchase_months));

// Monthly requisition data
$query_requisitions_months = "MONTH(requested_date) AS month, SUM(quantity) AS total";
$months_requisitions = $DB->SELECT('purchaserequisition', $query_requisitions_months, 'WHERE requested_date IS NOT NULL GROUP BY MONTH(requested_date) ORDER BY requested_date ASC');

$requisitions_months = [];
$requisitions_totals = [];
foreach ($months_requisitions as $row) {
    $requisitions_months[] = date('F', mktime(0, 0, 0, $row['month'], 10));
    $requisitions_totals[] = $row['total'];
}

$requisitions_totals = implode(",", $requisitions_totals);
$requisitions_months = implode(",", array_map(function ($month) {
    return "'" . $month . "'";
}, $requisitions_months));

// Product data for pie chart
$products_data = $DB->SELECT('vendor_products', '*', '');
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Hi, <?= AUTH_USER['firstname'] ?></h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>

        <!-- Skeleton Loaders -->
        <div class="row" id="skeletonLoaders">
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="skeleton skeleton-card"></div>
            </div>
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="skeleton skeleton-card"></div>
            </div>
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="skeleton skeleton-card"></div>
            </div>
        </div>

        <!-- Row for Charts -->
        <div class="row" id="chartsRow" style="display: none;">
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light text-success">
                        <i class="fas fa-chart-bar me-1"></i> Purchase Order
                    </div>
                    <div class="card-body">
                        <div id="purchaseChart" style="width: 100%; height: 300px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light text-success">
                        <i class="fas fa-chart-line me-1"></i> Purchase Requisition
                    </div>
                    <div class="card-body">
                        <div id="requisitionsChart" style="width: 100%; height: 300px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light text-success">
                        <i class="fas fa-chart-pie me-1"></i> Vendor Products
                    </div>
                    <div class="card-body">
                        <div id="productChart" style="width: 100%; height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RFQ Management Table Skeleton Loader -->
        <div id="rfqSkeleton" class="skeleton skeleton-table mb-4"></div>

        <!-- RFQ Management Table Card -->
        <div class="card shadow-sm mb-4" id="rfqTable" style="display: none;">
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
                                $vendor_name = $DB->SELECT_ONE_WHERE("vendors", "vendor_name", array("vendor_id" => $rfq['vendor_id']));
                                $vendorName = $vendor_name ? CHARS($vendor_name['vendor_name']) : 'Unknown Vendor';

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
</main>

<script>
    // Function to initialize each chart
    function initChart(chartId, type, title, categories, yAxisText, seriesData) {
        Highcharts.chart(chartId, {
            credits: {
                enabled: false // Disable credits globally for each chart
            },
            chart: {
                type: type,
                backgroundColor: 'transparent'
            },
            title: {
                text: title
            },
            xAxis: {
                categories: categories
            },
            yAxis: {
                title: {
                    text: yAxisText
                }
            },
            series: seriesData,
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            enabled: false
                        }
                    }
                }]
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Delay to simulate loading time for skeleton loaders
        setTimeout(function() {
            // Hide skeleton loaders and display the actual content
            document.getElementById('skeletonLoaders').style.display = 'none';
            document.getElementById('rfqSkeleton').style.display = 'none';
            document.getElementById('chartsRow').style.display = 'flex';
            document.getElementById('rfqTable').style.display = 'block';

            // Data for charts
            initChart('purchaseChart', 'column', 'Purchase Orders', [<?= $purchase_months ?>], 'Purchase (₱)', [{
                name: 'Total Purchase',
                data: [<?= $purchase_totals ?>],
                color: 'rgba(40, 167, 69, 1)'
            }]);
            initChart('requisitionsChart', 'line', 'Purchase Requisitions', [<?= $requisitions_months ?>], 'Quantity', [{
                name: 'Quantity',
                data: [<?= $requisitions_totals ?>],
                color: 'rgba(40, 167, 69, 1)',
                lineWidth: 2
            }]);
            initChart('productChart', 'pie', 'Vendor Products', [], '', [{
                name: 'Availability',
                colorByPoint: true,
                data: [
                    <?php foreach ($products_data as $row): ?> {
                            name: <?= json_encode($row['product_name']) ?>,
                            y: <?= $row['availability'] ?>,
                            color: 'rgba(40, 167, 69, 1)'
                        },
                    <?php endforeach; ?>
                ]
            }]);
        }, 1500); // 1.5-second delay
    });
</script>

<style>
    /* Skeleton loader base styles */
    .skeleton {
        background-color: #e0e0e0;
        animation: pulse 1.5s infinite;
        border-radius: 5px;
    }

    /* Specific skeleton styles */
    .skeleton-card {
        height: 300px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .skeleton-table {
        height: 400px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    /* Pulse animation for skeleton loaders */
    @keyframes pulse {
        0% {
            background-color: #f0f0f0;
        }

        50% {
            background-color: #e0e0e0;
        }

        100% {
            background-color: #f0f0f0;
        }
    }

    /* Make charts responsive within their containers */
    .card .card-body {
        overflow: hidden;
        padding: 10px;
    }

    .highcharts-root {
        width: 100% !important;
        height: auto !important;
    }

    /* Set max height and enable scrolling for Highcharts export menu */
    .highcharts-contextmenu {
        max-height: 300px;
        overflow-y: auto;
    }

    /*@media (max-width: 500px) {*/
    /*    .highcharts-contextmenu {*/
    /*        max-height: 150px;*/
    /* Further limit height on smaller screens */
    /*    }*/
    /*}*/
</style>