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

<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();
    (function() {
        var s1 = document.createElement("script"),
            s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/671c62462480f5b4f5940cc8/1ib3dvoq8';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script>
<!--End of Tawk.to Script-->