    <?php
    include('../../app/init.php');


    // $token = "d368051b3cd2819131fff6811cf4e59cd."; //  Kupal ka ba boss?

    if (!isset($_GET['token']) or $_GET['token'] != $token) {
        die("Invalid token failed to request to server.");
    }



    $status = $_GET['status'];
    $remarks = $_GET['remarks'];

    // Escape and sanitize the input data
    $data = array(
        "status" => $DB->ESCAPE($status),
        "remarks" => $DB->ESCAPE($remarks) // Optional remarks
    );


    // Update the Purchase Order in the database
    $updatePO = $DB->INSERT("purchaseorder", $data);

    // Check if the update is successful
    if ($updatePO == "success") {
        echo "ORDER_INSERTED";
    } else {
        echo "FAILED_TO_INSERT" . $updatePO['error'];
    }
