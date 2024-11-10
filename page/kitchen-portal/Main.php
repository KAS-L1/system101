<?php
include_once('api/middleware/role_access.php');

// Fetch data for food costing, kitchen orders, menu items, and stock levels

$foodCostData = $DB->SELECT('food_costing', '*');
$foodCostItems = [];
$foodCostPercentages = [];
$profitMargins = [];
foreach ($foodCostData as $row) {
    $foodCostItems[] = $row['menu_item'];
    $foodCostPercentages[] = (float) $row['food_cost_percentage']; // Cast to float
    $profitMargins[] = (float) $row['profit_margin']; // Cast to float
}

// Debugging: Check if data arrays are populated
// echo '<pre>';
// print_r($foodCostItems);
// print_r($foodCostPercentages);
// print_r($profitMargins);
// echo '</pre>';

$orderData = $DB->SELECT('kitchen_orders', 'order_status, COUNT(*) as count', 'GROUP BY order_status');
$orderStatusData = [];
foreach ($orderData as $row) {
    $orderStatusData[] = [
        'name' => $row['order_status'],
        'y' => (int)$row['count'],
    ];
}

$menuItems = $DB->SELECT('menu_items', '*');
$menuAvailabilityData = [];
foreach ($menuItems as $item) {
    $menuAvailabilityData[] = [
        'name' => $item['item_name'],
        'y' => (int)$item['availability'],
    ];
}

$stockData = $DB->SELECT('stock_items', '*');
$stockItems = [];
$currentStockLevels = [];
$reorderLevels = [];
foreach ($stockData as $item) {
    $stockItems[] = $item['item_name'];
    $currentStockLevels[] = $item['current_stock_level'];
    $reorderLevels[] = $item['reorder_level'];
}
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Food & Beverage Analytics Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>

        <!-- Skeleton Loaders -->
        <div class="row" id="skeletonLoaders">
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="skeleton skeleton-card"></div>
            </div>
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="skeleton skeleton-card"></div>
            </div>
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="skeleton skeleton-card"></div>
            </div>
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="skeleton skeleton-card"></div>
            </div>
        </div>

        <!-- Row for Charts -->
        <div class="row" id="chartsRow" style="display: none;">
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light text-success">
                        Food Cost Percentage & Profit Margin
                    </div>
                    <div class="card-body">
                        <div id="foodCostChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light text-success">
                        Order Status Distribution
                    </div>
                    <div class="card-body">
                        <div id="orderStatusChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light text-success">
                        Menu Item Availability
                    </div>
                    <div class="card-body">
                        <div id="menuAvailabilityChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light text-success">
                        Stock Levels
                    </div>
                    <div class="card-body">
                        <div id="stockChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Apply a default green theme to Highcharts
    Highcharts.setOptions({
        colors: ['#28a745', '#82e082', '#a8dda8', '#4caf50', '#66bb6a'],
        chart: {
            backgroundColor: 'transparent',
            style: {
                fontFamily: 'Arial, sans-serif'
            }
        },
        credits: {
            enabled: false
        } // Disable credits globally
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Simulate loading time for skeleton loaders
        setTimeout(function() {
            // Hide skeleton loaders and display actual charts
            document.getElementById('skeletonLoaders').style.display = 'none';
            document.getElementById('chartsRow').style.display = 'flex';

            // Data for charts
            initChart('foodCostChart', 'column', 'Food Cost & Profit Margin', <?= json_encode($foodCostItems) ?>, 'Percentage', [{
                    name: 'Food Cost %',
                    data: <?= json_encode($foodCostPercentages) ?>
                },
                {
                    name: 'Profit Margin',
                    data: <?= json_encode($profitMargins) ?>
                }
            ]);

            Highcharts.chart('orderStatusChart', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Order Status Distribution'
                },
                series: [{
                    name: 'Orders',
                    colorByPoint: true,
                    data: <?= json_encode($orderStatusData) ?>
                }]
            });

            Highcharts.chart('menuAvailabilityChart', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Menu Item Availability'
                },
                series: [{
                    name: 'Availability',
                    colorByPoint: true,
                    data: <?= json_encode($menuAvailabilityData) ?>
                }]
            });

            initChart('stockChart', 'column', 'Stock Levels', <?= json_encode($stockItems) ?>, 'Stock Level', [{
                    name: 'Current Stock',
                    data: <?= json_encode($currentStockLevels) ?>
                },
                {
                    name: 'Reorder Level',
                    data: <?= json_encode($reorderLevels) ?>,
                    color: '#ffc107'
                } // Warning color for reorder level
            ]);
        }, 1500); // 1.5-second delay for skeleton loaders
    });

    function initChart(chartId, type, title, categories, yAxisText, seriesData) {
        Highcharts.chart(chartId, {
            chart: {
                type: type
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
            series: seriesData
        });
    }
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

    /* Success-theme styling for card headers */
    .card-header {
        background-color: rgba(40, 167, 69, 0.2);
        border-bottom: 2px solid rgba(40, 167, 69, 0.8);
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