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
                </div>
                </div>

                <?php if(isset($_SESSION['SUCCESS_LOGIN'])){ ?>
                <?=swalAlert("success", "Welcome! ".AUTH_USER['firstname'], "Login successfully")?>
                <?php unset($_SESSION['SUCCESS_LOGIN']);} ?>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
                    crossorigin="anonymous"></script>
                <script src="js/scripts.js"></script>


                <script>
let table1 = new DataTable('#dataTable1'); // Initialize first table
let table2 = new DataTable('#dataTable2'); // Initialize second table
                </script>
                <script>
document.addEventListener('DOMContentLoaded', function() {
    // Bar Chart Configuration with success colors
    var barCtx = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [{
                label: 'Sales ($)',
                data: [1200, 1900, 3000, 500, 2000, 3000],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.2)', // Light green (Bootstrap success)
                    'rgba(40, 167, 69, 0.2)',
                    'rgba(40, 167, 69, 0.2)',
                    'rgba(40, 167, 69, 0.2)',
                    'rgba(40, 167, 69, 0.2)',
                    'rgba(40, 167, 69, 0.2)'
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)', // Dark green (Bootstrap success)
                    'rgba(40, 167, 69, 1)',
                    'rgba(40, 167, 69, 1)',
                    'rgba(40, 167, 69, 1)',
                    'rgba(40, 167, 69, 1)',
                    'rgba(40, 167, 69, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Line Chart Configuration with success colors
    var lineCtx = document.getElementById('lineChart').getContext('2d');
    var lineChart = new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [{
                label: 'Visitors',
                data: [300, 500, 400, 700, 600, 800],
                borderColor: 'rgba(40, 167, 69, 1)', // Green (Bootstrap success)
                backgroundColor: 'rgba(40, 167, 69, 0.2)', // Light green (Bootstrap success)
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
                </script>

                </body>

                </html>