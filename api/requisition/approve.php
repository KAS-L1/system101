<?php require("../../app/init.php") ?>


<?php 
    
    $requisition_id = $_POST['requisition_id'];

    // UPDATE DATA
    $data = array(
        "status" => "Approve",
    );
    $where = array("requisition_id" => $requisition_id);
    $requisition = $DB->UPDATE("purchaserequisition", $data, $where);
    if($requisition != "success") alert("danger", $requisition['error']);
    
    swalAlert("success", "Purchase Requisition Approved");
    refreshUrlTimeout(2000);
    

?>