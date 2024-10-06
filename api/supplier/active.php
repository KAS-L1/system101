<?php require("../../app/init.php") ?>


<?php 
    
    $id = $_POST['id'];

    // UPDATE DATA
    $data = array(
        "status" => "Active",
        "updated_at" => DATE_TIME,
    );
    $where = array("id" => $id);
    $supplier = $DB->UPDATE("suppliers", $data, $where);
    if($supplier != "success") alert("danger", $supplier['error']);
    
    swalAlert("success", "Activated");
    refreshUrlTimeout(2000);
    
?>