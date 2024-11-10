<?php
require("../../app/init.php");

$item_id = $_POST['item_id'];
$where = array("item_id" => $item_id);
$delete = $DB->DELETE("menu_items", $where);

if ($delete == "success") {
    swalAlert('success', 'Item deleted successfully.');
    refreshUrlTimeout(2000);
} else {
    swalAlert('error', 'Failed to delete item.');
}
