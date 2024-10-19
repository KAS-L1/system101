<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted"><?= APP_COPYRIGHT ?></div>
            <div>
                <a href="#">Privacy Policy</a>
                &middot;
                <a href="#">Terms &amp; Conditions</a>
            </div>
        </div>
    </div>
</footer>

<?php if (isset($_SESSION['SUCCESS_LOGIN'])) { ?>
    <?= swalAlert("success", "Welcome! " . AUTH_USER['firstname'], "Login successfully") ?>
<?php unset($_SESSION['SUCCESS_LOGIN']);
} ?>

<script src="js/scripts.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Bar Chart Configuration
        var barCtx = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                datasets: [{
                    label: 'Sales ($)',
                    data: [1200, 1900, 3000, 500, 2000, 3000],
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
        var lineCtx = document.getElementById('lineChart').getContext('2d');
        var lineChart = new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                datasets: [{
                    label: 'Visitors',
                    data: [300, 500, 400, 700, 600, 800],
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
        var pieCtx = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Product A', 'Product B', 'Product C', 'Product D'],
                datasets: [{
                    data: [25, 30, 20, 25],
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

<script>
    // Initialize DataTables
    let table1 = new DataTable('#dataTable1'); // Initialize first table
    let table2 = new DataTable('#dataTable2'); // Initialize second table
    let table3 = new DataTable('#dataTable3'); // Initialize third table
</script>