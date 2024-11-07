<?php
include_once('api/middleware/role_access.php');
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Predictive Analytics Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>

        <div class="row">
            <!-- Demand Forecasting Line Chart -->
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light text-primary">
                        <i class="fas fa-chart-line me-1"></i> Demand Forecasting
                    </div>
                    <div class="card-body">
                        <canvas id="demandChart" style="width: 100%; height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Non-Compliance Risk Bar Chart -->
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light text-danger">
                        <i class="fas fa-exclamation-circle me-1"></i> Non-Compliance Risk
                    </div>
                    <div class="card-body">
                        <canvas id="riskChart" style="width: 100%; height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Document Processing Time Pie Chart -->
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light text-info">
                        <i class="fas fa-clock me-1"></i> Document Processing Time
                    </div>
                    <div class="card-body">
                        <canvas id="docTimeChart" style="width: 100%; height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function loadChartData(url, chartId, chartType, label, backgroundColor, borderColor, labelExtractor, dataExtractor, options = {}) {
            $.getJSON(url, function(data) {
                console.log(label + " Data:", data); // Debugging line
                const labels = data.map(labelExtractor);
                const chartData = data.map(dataExtractor);

                new Chart(document.getElementById(chartId).getContext('2d'), {
                    type: chartType,
                    data: {
                        labels: labels,
                        datasets: [{
                            label: label,
                            data: chartData,
                            backgroundColor: backgroundColor,
                            borderColor: borderColor,
                            fill: chartType === 'line',
                            tension: chartType === 'line' ? 0.3 : 0
                        }]
                    },
                    options: Object.assign({
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top'
                            }
                        }
                    }, options)
                });
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error("Error loading " + label + " data:", textStatus, errorThrown);
            });
        }

        loadChartData(
            '/api/predictive-analytics/get_demand_data.php',
            'demandChart',
            'line',
            'Average Demand',
            'rgba(0, 123, 255, 0.2)',
            'rgba(0, 123, 255, 1)',
            item => item.month,
            item => item.avg_demand
        );

        loadChartData(
            '/api/predictive-analytics/get_risk_data.php',
            'riskChart',
            'bar',
            'Risk Count',
            'rgba(220, 53, 69, 0.2)',
            'rgba(220, 53, 69, 1)',
            item => item.severity,
            item => item.count
        );

        loadChartData(
            '/api/predictive-analytics/get_processing_time_data.php',
            'docTimeChart',
            'pie',
            'Processing Time',
            ['rgba(23, 162, 184, 0.8)', 'rgba(255, 193, 7, 0.8)', 'rgba(40, 167, 69, 0.8)'],
            null,
            item => item.document_type,
            item => item.avg_time, {
                scales: {}
            } // Disable scales for pie chart
        );
    });
</script>