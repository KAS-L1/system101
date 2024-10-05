// Add Supplier
function add_supplier($data) {
    $db = new Database();
    $fields = array(
        'name' => $data['name'],
        'contact_person' => $data['contact_person'],
        'contact_number' => $data['contact_number'],
        'email' => $data['email'],
        'address' => $data['address']
    );
    $result = $db->INSERT('suppliers', $fields);
    if ($result == 'success') {
        return true;
    } else {
        return false;
    }
}

// Edit Supplier
function edit_supplier($data) {
    $db = new Database();
    $fields = array(
        'name' => $data['name'],
        'contact_person' => $data['contact_person'],
        'contact_number' => $data['contact_number'],
        'email' => $data['email'],
        'address' => $data['address']
    );
    $where = array(
        'id' => $data['id']
    );
    $result = $db->UPDATE('suppliers', $fields, $where);
    if ($result == 'success') {
        return true;
    } else {
        return false;
    }
}

// Remove Supplier
function remove_supplier($id) {
    $db = new Database();
    $where = array(
        'id' => $id
    );
    $result = $db->DELETE('suppliers', $where);
    if ($result == 'success') {
        return true;
    } else {
        return false;
    }
}

// View Supplier Profile
function view_supplier_profile($id) {
    $db = new Database();
    $where = array(
        'id' => $id
    );
    $result = $db->SELECT('suppliers', '*', $where);
    return $result;
}

// Supplier Performance Report
function supplier_performance_report($id) {
    $db = new Database();
    $where = array(
        'id' => $id
    );
    $result = $db->SELECT('suppliers', '*', $where);
    return $result;
}
