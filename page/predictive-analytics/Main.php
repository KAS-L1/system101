<div class="container-fluid px-4">
    <h1 class="mt-4">Predictive Analytics Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        <!-- Chart Cards with Skeleton Loaders -->
        <?php
        $charts = [
            ['id' => 'procurement-chart', 'title' => 'Procurement Demand Forecasting', 'icon' => 'bi-graph-up-arrow'],
            ['id' => 'vendor-performance-chart', 'title' => 'Vendor Performance Prediction', 'icon' => 'bi-shield-exclamation'],
            ['id' => 'audit-chart', 'title' => 'Audit Compliance Prediction', 'icon' => 'bi-shield-check'],
            ['id' => 'document-chart', 'title' => 'Document Processing Time Prediction', 'icon' => 'bi-clock-history']
        ];
        foreach ($charts as $chart) : ?>
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card border-0 shadow-sm h-100 position-relative">
                    <div class="card-header bg-light text-success">
                        <i class="bi <?= $chart['icon'] ?> me-1"></i> <?= $chart['title'] ?>
                    </div>
                    <div class="card-body">
                        <!-- Skeleton loader -->
                        <div class="skeleton-loader" id="<?= $chart['id'] ?>-skeleton"></div>
                        <div id="<?= $chart['id'] ?>" style="width: 100%; height: 300px;"></div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    // Toggle visibility of skeleton loader
    function toggleSkeleton(chartId, isLoading) {
        document.getElementById(`${chartId}-skeleton`).style.display = isLoading ? 'block' : 'none';
    }

    // Fetch data and render chart with skeleton toggle
    function fetchDataAndRenderChart(endpoint, renderFunction, chartId) {
        toggleSkeleton(chartId, true); // Show skeleton loader
        $.getJSON(endpoint, function(data) {
            // Delay rendering of the chart to simulate loading time
            setTimeout(() => {
                renderFunction(data);
                toggleSkeleton(chartId, false); // Hide skeleton loader
            }, 500); // 1.5 seconds delay
        }).fail(function(jqXHR) {
            console.error(`Error fetching data from ${endpoint}: ${jqXHR.responseText}`);
        });
    }

    // Chart rendering functions
    function renderProcurementChart(data) {
        Highcharts.chart('procurement-chart', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Procurement Demand Forecasting'
            },
            xAxis: {
                categories: data.periods,
                title: {
                    text: 'Time Period'
                }
            },
            yAxis: {
                title: {
                    text: 'Demand'
                }
            },
            series: [{
                name: 'Demand',
                data: data.predictions,
                color: '#28a745'
            }]
        });
    }

    function renderVendorPerformanceChart(data) {
        Highcharts.chart('vendor-performance-chart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Vendor Performance Prediction'
            },
            xAxis: {
                categories: data.vendors,
                title: {
                    text: 'Vendor'
                }
            },
            yAxis: {
                title: {
                    text: 'Performance Score'
                }
            },
            series: [{
                name: 'Performance',
                data: data.scores,
                color: '#28a745'
            }]
        });
    }

    function renderAuditChart(data) {
        Highcharts.chart('audit-chart', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Audit Compliance Prediction'
            },
            series: [{
                name: 'Compliance',
                colorByPoint: true,
                data: data.compliance.map(item => ({
                    name: item.name,
                    y: item.y,
                    color: '#28a745'
                }))
            }]
        });
    }

    function renderDocumentChart(data) {
        Highcharts.chart('document-chart', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Document Processing Time Prediction'
            },
            xAxis: {
                categories: data.documentTypes,
                title: {
                    text: 'Document Type'
                }
            },
            yAxis: {
                title: {
                    text: 'Processing Time (hours)'
                }
            },
            series: [{
                name: 'Processing Time',
                data: data.times,
                color: '#28a745'
            }]
        });
    }

    // Initial data load with skeleton handling
    $(document).ready(function() {
        fetchDataAndRenderChart('api/predictive-analytics/predict_procurement.php', renderProcurementChart, 'procurement-chart');
        fetchDataAndRenderChart('api/predictive-analytics/predict_vendor_performance.php', renderVendorPerformanceChart, 'vendor-performance-chart');
        fetchDataAndRenderChart('api/predictive-analytics/predict_audit.php', renderAuditChart, 'audit-chart');
        fetchDataAndRenderChart('api/predictive-analytics/predict_document.php', renderDocumentChart, 'document-chart');
    });
</script>

<style>
    /* Skeleton loader styling */
    .skeleton-loader {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, #f0f0f0, #e0e0e0, #f0f0f0);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
        border-radius: 4px;
    }

    @keyframes loading {
        0% {
            background-position: 200% 0;
        }

        100% {
            background-position: -200% 0;
        }
    }
</style>