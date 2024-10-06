<?php require("../../app/init.php") ?>


<?php 
    
    $order_id = $_POST['order_id'];

    // UPDATE DATA
    $data = array(
        "supplier" => $_POST['supplier'],
        "order_date" => $_POST['order_date'],
        "total_amount" => $_POST['total_amount'],
        "notes" => $_POST['notes']
    );
    $where = array("id" => $order_id);
    $order = $DB->UPDATE("orders", $data, $where);
    if($order != "success") alert("danger", $order['error']);
    
    swalAlert("success", "Order Updated");
    refreshUrlTimeout(2000);
    

?>