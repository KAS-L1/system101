<?php 
 if (AUTH_USER['role'] != "ADMIN"){
    if (AUTH_USER['role'] == "VENDOR") {
        redirectUrl("/vendor-portal");
    }elseif (AUTH_USER['role'] == "KITCHEN"){
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

        <!-- Row for Charts and Table -->
        <div class="row">
            <!-- Card 1: Bar Chart -->
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light text-dark">
                        <i class="fas fa-chart-bar me-1"></i> Purchase Order
                    </div>
                    <div class="card-body">
                        <canvas id="barChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Card 2: Line Chart -->
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light text-dark">
                        <i class="fas fa-chart-line me-1"></i> Purchase Requisition
                    </div>
                    <div class="card-body">
                        <canvas id="lineChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i> DataTable Example
            </div>
            <div class="card-body">
                <table id="dataTable1" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <!-- Example Table Data (You can replace this with your dynamic data) -->
                        <tr>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>61</td>
                            <td>2011/04/25</td>
                            <td>$320,800</td>
                        </tr>
                        <!-- ... More Table Rows ... -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>