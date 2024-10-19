<?php
require("../../app/init.php");

// Check if the request method is POST and all required fields are set

    // Escape and sanitize the input data
    $data = array(
        "approval_id" => rand(), // Generate a random ID for new approval entries (you can customize this)
        "requisition_id" => $DB->ESCAPE($_POST['requisition_id']),
        "approved_amount" => floatval($DB->ESCAPE($_POST['approved_amount'])), // Ensure the amount is a float
        "approved_by" => $DB->ESCAPE($_POST['approved_by']),
        "approval_date" => $DB->ESCAPE($_POST['approval_date']),
        "approval_status" => $DB->ESCAPE($_POST['approval_status']), // Either Approved or Rejected
        "remarks" => $DB->ESCAPE($_POST['remarks']),
    );
    // Insert the budget approval into the `budget_approval` table
    $approval = $DB->INSERT("budget_approval", $data);

    if ($approval == "success") {
        // Update the related requisition's status based on approval
        $requisition_status = $data['approval_status'] == 'Approved' ? 'Approved' : 'Rejected';
        $requisition_update = $DB->UPDATE(
            "purchaserequisition",
            array("status" => $requisition_status),
            array("requisition_id" => $data['requisition_id'])
        );

        // Display success alert and refresh page
        if ($requisition_update == "success") {
            swalAlert('success', 'Budget Approval Created Successfully and Requisition Updated');
            refreshUrlTimeout(2000);
        } else {
            swalAlert('warning', 'Approval Created but Failed to Update Requisition Status');
        }
    } else {
        // Display error alert if something goes wrong
        swalAlert('error', 'Failed to Create Budget Approval');
    }

?>