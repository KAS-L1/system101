<?php  

// reject_order.php



$db = new Database();

if (isset($_POST['submit'])) {
    $result = $db->UPDATE('orders', array('status' => 'Rejected'), array('id' => $_GET['id']));

    if ($result == 'success') {
        header('Location: view_orders.php');
        exit;
    } else {
        $error = 'Failed to reject order';
    }
}

$order = $db->SELECT_ONE_WHERE('orders', '*', array('id' => $_GET['id']));

?>

<!-- Reject Order Confirmation -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <p>Are you sure you want to reject order #<?php echo $order['order_id']; ?>?</p>
    <button type="submit" class="btn btn-danger">Reject Order</button>
    <a href="view_orders.php" class="btn btn-default">Back</a>
</form>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>