<?php


$db = new Database();

$orders = $db->SELECT('orders', '*', 'WHERE status = "Delivered" OR status = "Cancelled" OR status = "Rejected"');

?>

<!-- Order History Table -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Order Date</th>
            <th>Supplier</th>
            <th>Total Amount</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo $order['order_id']; ?></td>
                <td><?php echo $order['order_date']; ?></td>
                <td><?php echo $order['supplier']; ?></td>
                <td><?php echo $order['total_amount']; ?></td>
                <td><?php echo $order['status']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>