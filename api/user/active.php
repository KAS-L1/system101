<?php require("../../app/init.php") ?>


<?php 
    
    $user_id = $_POST['user_id'];

    // UPDATE DATA
    $data = array(
        "status" => "Active",
        "updated_at" => DATE_TIME,
    );
    $where = array("user_id" => $user_id);
    $user = $DB->UPDATE("users", $data, $where);
    if($user != "success") alert("danger", $user['error']);
    
    swalAlert("success", "Activated");
    refreshUrlTimeout(2000);
    
?>