<?php
include_once('../../app/init.php');

$stock_id = $_POST['stock_id'];

$where = ["stock_id" => $stock_id];
$delete = $DB->DELETE("stock_items", $where);
if ($delete === "success") {
    swalAlert('success', 'Stock item deleted successfully');
    refreshUrlTimeout(2000);
} else {
    swalAlert('success', 'Failed to delete stock item');
}
