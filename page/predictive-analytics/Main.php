  <div class="container-fluid px-4">
      <h1 class="mt-4">Predictive Analytics Dashboard</h1>
      <ol class="breadcrumb mb-4">
          <li class="breadcrumb-item active">Dashboard</li>
      </ol>
      <div class="row">
          <!-- Procurement Demand Forecasting Chart -->
          <div class="col-lg-6 col-md-12 mb-4">
              <div class="card border-0 shadow-sm h-100">
                  <div class="card-header bg-light text-success">
                      <i class="bi bi-graph-up-arrow me-1"></i> Procurement Demand Forecasting
                  </div>
                  <div class="card-body">
                      <div id="procurement-chart" style="width: 100%; height: 300px;"></div>
                  </div>
              </div>
          </div>
          <!-- Vendor Performance Prediction Chart -->
          <div class="col-lg-6 col-md-12 mb-4">
              <div class="card border-0 shadow-sm h-100">
                  <div class="card-header bg-light text-success">
                      <i class="bi bi-shield-exclamation me-1"></i> Vendor Performance Prediction
                  </div>
                  <div class="card-body">
                      <div id="vendor-performance-chart" style="width: 100%; height: 300px;"></div>
                  </div>
              </div>
          </div>
          <!-- Audit Compliance Prediction Chart -->
          <div class="col-lg-6 col-md-12 mb-4">
              <div class="card border-0 shadow-sm h-100">
                  <div class="card-header bg-light text-success">
                      <i class="bi bi-shield-check me-1"></i> Audit Compliance Prediction
                  </div>
                  <div class="card-body">
                      <div id="audit-chart" style="width: 100%; height: 300px;"></div>
                  </div>
              </div>
          </div>
          <!-- Document Processing Time Prediction Chart -->
          <div class="col-lg-6 col-md-12 mb-4">
              <div class="card border-0 shadow-sm h-100">
                  <div class="card-header bg-light text-success">
                      <i class="bi bi-clock-history me-1"></i> Document Processing Time Prediction
                  </div>
                  <div class="card-body">
                      <div id="document-chart" style="width: 100%; height: 300px;"></div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <script>
      // Function to fetch data and render chart
      function fetchDataAndRenderChart(endpoint, renderFunction) {
          $.getJSON(endpoint, function(data) {
              renderFunction(data);
          }).fail(function(jqXHR) {
              console.error(`Error fetching data from ${endpoint}: ${jqXHR.responseText}`);
          });
      }

      // Render Procurement Demand Forecasting Chart
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
                  color: '#28a745' // Green color for the series
              }]
          });
      }

      // Render Vendor Performance Prediction Chart
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
                  color: '#28a745' // Green color for the series
              }]
          });
      }

      // Render Audit Compliance Prediction Chart
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
                      color: '#28a745' // Green color for each slice
                  }))
              }]
          });
      }

      // Render Document Processing Time Prediction Chart
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
                  color: '#28a745' // Green color for the series
              }]
          });
      }

      // Document ready function
      $(document).ready(function() {
          fetchDataAndRenderChart('api/predictive-analytics/predict_procurement.php', renderProcurementChart);
          fetchDataAndRenderChart('api/predictive-analytics/predict_vendor_performance.php', renderVendorPerformanceChart);
          fetchDataAndRenderChart('api/predictive-analytics/predict_audit.php', renderAuditChart);
          fetchDataAndRenderChart('api/predictive-analytics/predict_document.php', renderDocumentChart);
      });
  </script>