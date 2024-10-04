<?php 

// approve_order.php

// approve_order.php


$db = new Database();

if (isset($_POST['submit'])) {
    $result = $db->UPDATE('orders', array('status' => 'Active'), array('id' => $_GET['id']));

    if ($result == 'success') {
        header('Location: view_orders.php');
        exit;
    } else {
        $error = 'Failed to approve order';
    }
}

$order = $db->SELECT_ONE_WHERE(' orders', '*', array('id' => $_GET['id']));

?>

<!-- Approve Order Confirmation -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <p>Are you sure you want to approve order #<?php echo $order['order_id']; ?>?</p>
    <button type="submit" class="btn btn-success">Approve Order</button>
    <a href="view_orders.php" class="btn btn-default">Back</a>
</form>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>