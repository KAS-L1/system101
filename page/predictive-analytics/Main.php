<?php include_once('api/middleware/role_access.php'); ?>

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
                        <div id="demandChart" style="width: 100%; height: 300px;"></div>
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
                        <div id="riskChart" style="width: 100%; height: 300px;"></div>
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
                        <div id="docTimeChart" style="width: 100%; height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Include Highcharts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function loadHighchartsData(url, containerId, chartType, title, seriesName, labelExtractor, dataExtractor, chartOptions = {}) {
            $.getJSON(url, function(data) {
                console.log(`${title} Data:`, data); // Debugging line to check data format

                // Extract categories and values
                const categories = data.map(labelExtractor);
                const values = data.map(dataExtractor);

                if (!categories.length || !values.length) {
                    console.error(`No data available for ${title}`);
                    return;
                }

                let seriesData;
                if (chartType === 'pie') {
                    // For pie charts, data needs to be in a specific format
                    seriesData = categories.map((category, i) => ({
                        name: category,
                        y: values[i]
                    }));
                } else {
                    seriesData = [{
                        name: seriesName,
                        data: values
                    }];
                }

                // Configure Highcharts
                Highcharts.chart(containerId, {
                    chart: {
                        type: chartType,
                        backgroundColor: 'transparent'
                    },
                    title: {
                        text: title
                    },
                    xAxis: chartType !== 'pie' ? {
                        categories: categories
                    } : undefined,
                    yAxis: chartType !== 'pie' ? {
                        title: {
                            text: seriesName
                        }
                    } : undefined,
                    series: chartType === 'pie' ? [{
                        name: seriesName,
                        colorByPoint: true,
                        data: seriesData
                    }] : seriesData,
                    plotOptions: {
                        line: {
                            marker: {
                                enabled: true
                            }
                        },
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '{point.name}: {point.percentage:.1f}%'
                            }
                        },
                        column: {
                            borderColor: 'rgba(220, 53, 69, 1)'
                        }
                    },
                    colors: chartType === 'pie' ? ['rgba(23, 162, 184, 0.8)', 'rgba(255, 193, 7, 0.8)', 'rgba(40, 167, 69, 0.8)'] : undefined,
                    credits: {
                        enabled: false
                    },
                    ...chartOptions
                });
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error(`Error loading ${title} data:`, textStatus, errorThrown);
            });
        }

        // Load Demand Forecasting Data (Line Chart)
        loadHighchartsData(
            '/api/predictive-analytics/get_demand_data.php',
            'demandChart',
            'line',
            'Demand Forecasting',
            'Average Demand',
            item => item.month,
            item => item.avg_demand
        );

        // Load Non-Compliance Risk Data (Column Chart)
        loadHighchartsData(
            '/api/predictive-analytics/get_risk_data.php',
            'riskChart',
            'column',
            'Non-Compliance Risk',
            'Risk Count',
            item => item.severity,
            item => item.count
        );

        // Load Document Processing Time Data (Pie Chart)
        loadHighchartsData(
            '/api/predictive-analytics/get_processing_time_data.php',
            'docTimeChart',
            'pie',
            'Document Processing Time',
            'Processing Time',
            item => item.document_type,
            item => item.avg_time
        );
    });
</script>