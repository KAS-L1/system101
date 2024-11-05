<?php require("../../app/init.php"); ?>

<?php
$document_id = $_POST['document_id'];

// UPDATE DATA
$data = array("status" => "Approved");
$where = array("document_id" => $document_id);
$updateStatus = $DB->UPDATE("document_tracking", $data, $where);

if ($updateStatus != "success") {
    alert("danger", $updateStatus['error']);
} else {
    swalAlert("success", "Document Approved");
    refreshUrlTimeout(second: 2000);
}

?>
