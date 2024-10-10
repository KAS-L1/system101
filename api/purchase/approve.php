<?php require("../../app/init.php") ?>


<?php 
    
    $order_id = $_POST['order_id'];

    // UPDATE DATA
    $data = array(
        "status" => "Approve",
    );
    $where = array("id" => $order_id);
    $order = $DB->UPDATE("orders", $data, $where);
    if($order != "success") alert("danger", $order['error']);
    
    swalAlert("success", "Order Approved");
    refreshUrlTimeout(2000);
    

?>