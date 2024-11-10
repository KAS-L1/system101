<?php
require("../../app/init.php");

$id = $_POST['id'];
$where = array("id" => $id);
$delete = $DB->DELETE("food_costing", $where);

if ($delete == "success") {
    swalAlert('success', 'Food costing item deleted successfully.');
    refreshUrlTimeout(2000);
} else {
    swalAlert('error', 'Failed to delete food costing item.');
}
