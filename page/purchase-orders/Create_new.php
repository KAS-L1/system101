<?php


$db = new Database();

if (isset($_POST['submit'])) {
    $order_data = array(
        'order_id' => $_POST['order_id'],
        'order_date' => $_POST['order_date'],
        'supplier' => $_POST['supplier'],
        'total_amount' => $_POST['total_amount'],
        'status' => 'Pending',
        'user_id' => $_SESSION['user_id']
    );

    $result = $db->INSERT('orders', $order_data);

    if ($result == 'success') {
        header('Location: view_orders.php');
        exit;
    } else {
        $error = 'Failed to create order';
    }
}

?>

<!-- Create Order Form -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <div class="form-group">
        <label for="order_id">Order ID</label>
        <input type="text" class="form-control" id="order_id" name="order_id" required>
    </div>
    <div class="form-group">
        <label for="order_date">Order Date</label>
        <input type="date" class="form-control" id="order_date" name="order_date" required>
    </div>
    <div class="form-group">
        <label for="supplier">Supplier</label>
        <input type="text" class="form-control" id="supplier" name="supplier" required>
    </div>
    <div class="form-group">
        <label for="total_amount">Total Amount</label>
        <input type="number" class="form-control" id="total_amount" name="total_amount" required>
    </div>
    <button type="submit" class="btn btn-primary">Create Order</button>
</form>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>