<?php require("../../app/init.php") ?>


<?php 
    
    // INSERT DATA
    $data = array(
        "order_id" => rand(),
        "supplier" => $_POST['supplier'],
        "order_date" => $_POST['order_date'],
        "total_amount" => $_POST['total_amount'],
        "notes" => $_POST['notes'],
        "status" => "Pending"  // Default status when created
    );
    $order = $DB->INSERT("orders", $data);
    if($order != "success") alert("danger", $order['error']);
    
    swalAlert("success", "Order Created");
    refreshUrlTimeout(2000);
    

?>