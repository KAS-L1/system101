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
    // Initialize DataTables
    let table1 = new DataTable('#dataTable1'); // Initialize first table
    let table2 = new DataTable('#dataTable2'); // Initialize second table
    let table3 = new DataTable('#dataTable3'); // Initialize third table
</script>