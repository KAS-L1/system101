<?php require("../../app/init.php"); ?>

<?php
$document_id = $_POST['document_id'];
$remarks = isset($_POST['remarks']) ? $DB->ESCAPE($_POST['remarks']) : '';

// UPDATE DATA
$data = array(
    "status" => "Rejected",
    "remarks" => $remarks
);
$where = array("document_id" => $document_id);
$updateStatus = $DB->UPDATE("document_tracking", $data, $where);

if ($updateStatus != "success") {
    alert("danger", $updateStatus['error']);
} else {
    swalAlert("success", "Document Rejected");
}

refreshUrlTimeout(second: 2000);
?>
