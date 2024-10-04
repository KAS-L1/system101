<?php



$db = new Database();

$order = $db->SELECT_ONE_WHERE('orders', '*', array('id' => $_GET['id']));

?>

<!-- Track Order -->
<p>Order #<?php echo $order['order_id']; ?> is currently <?php echo $order['status']; ?>.</p>