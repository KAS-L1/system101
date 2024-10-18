

<?php require("../../app/init.php") ?>


<?php 
    
    $po_id = $_POST['po_id'];

    // UPDATE DATA
    $data = array(
        "status" => "Delivered",
    );
    $where = array("po_id" => $po_id);
    $purchaseorders = $DB->UPDATE("purchaseorder", $data, $where);
    if($purchaseorders != "success") alert("danger", $purchaseorders['error']);
    
    swalAlert("success", "Order Delivered");
    refreshUrlTimeout(2000);
    

?>