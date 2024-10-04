<?php
// edit_order.php

$db = new Database();

if (isset($_POST['submit'])) {
    $order_data = array(
        'order_id' => $_POST['order_id'],
        'order_date' => $_POST['order_date'],
        'supplier' => $_POST['supplier'],
        'total_amount' => $_POST['total_amount'],
        'status' => $_POST['status']
    );

    $result = $db->UPDATE('orders', $order_data, array('id' => $_GET['id']));

    if ($result == 'success') {
        header('Location: view_orders.php');
        exit;
    } else {
        $error = 'Failed to update order';
    }
}

$order = $db->SELECT_ONE_WHERE('orders', '*', where: array('id' => $_GET['id']));

?>

<!-- Edit Order Form -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <div class="form-group">
        <label for="order_id">Order ID</label>
        <input type="text" class="form-control" id="order_id" name="order_id" value="<?php echo $order['order_id']; ?>" required>
    </div>
    <div class="form-group">
        <label for="order_date">Order Date</label>
        <input type="date" class="form-control" id="order_date" name="order_date" value="<?php echo $order['order_date']; ?>" required>
    </div>
    <div class="form-group">
        <label for="supplier">Supplier</label>
        <input type="text" class="form-control" id="supplier" name="supplier" value="<?php echo $order['supplier']; ?>" required>
    </div>
    <div class="form-group">
        <label for="total_amount">Total Amount</label>
        <input type="number" class="form-control" id="total_amount" name="total_amount" value="<?php echo $order['total_amount']; ?>" required>
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <select class="form-control" id="status" name="status" required>
            <option value="Pending" <?php echo ($order['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
            <option value="Active" <?php echo ($order['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
            <option value="Delivered" <?php echo ($order['status'] == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
            <option value="Cancelled" <?php echo ($order['status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
            <option value="Rejected" <?php echo ($order['status'] == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update Order</button>
</form>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>