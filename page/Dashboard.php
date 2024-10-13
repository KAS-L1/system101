<?php 
 if (AUTH_USER['role'] != "ADMIN") {
    if (AUTH_USER['role'] == "VENDOR") {
        redirectUrl("/vendor-portal");
    } elseif (AUTH_USER['role'] == "KITCHEN") {
        redirectUrl("/kitchen-portal");
    }
 }
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
                        <canvas id="barChart" style="width: 100%; height: 300px;"></canvas> <!-- Fixed height -->
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
                        <canvas id="lineChart" style="width: 100%; height: 300px;"></canvas> <!-- Fixed height -->
                    </div>
                </div>
            </div>

            <!-- Card 3: Pie Chart -->
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light text-success">
                        <i class="fas fa-chart-pie me-1"></i> Predictive Analytics
                    </div>
                    <div class="card-body">
                        <canvas id="pieChart" style="width: 100%; height: 300px;"></canvas> <!-- Fixed height -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light text-success">
                        <i class="fas fa-table me-1"></i> Analytic Table
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable1" class="display">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Product A</td>
                                        <td>$100</td>
                                        <td>50</td>
                                    </tr>
                                    <tr>
                                        <td>Product B</td>
                                        <td>$200</td>
                                        <td>30</td>
                                    </tr>
                                    <tr>
                                        <td>Product C</td>
                                        <td>$150</td>
                                        <td>20</td>
                                    </tr>
                                    <tr>
                                        <td>Product D</td>
                                        <td>$250</td>
                                        <td>10</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
