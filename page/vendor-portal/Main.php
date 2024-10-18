<?php
include_once('api/middleware/role_access.php');
// Retrieve all Purchase Orders from the `purchaseorder` table
$purchaseOrders = $DB->SELECT("purchaseorder", "*", "ORDER BY po_id DESC");
?>

<div class="container mt-4 py-5">
    <!-- Purchase Orders Table -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable2" class="table table-hover table-sm shadow-sm">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th>PO ID</th>
                            <th>Vendor Name</th>
                            <th>Items</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Cost</th>
                            <th>Order Date</th>
                            <th>Delivery Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($purchaseOrders as $order) {
                        ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= CHARS($order['po_id']); ?></td>
                                <td><?= CHARS($order['vendor_name']); ?></td>
                                <td><?= CHARS($order['items']); ?></td>
                                <td><?= CHARS($order['quantity']); ?></td>
                                <td><?= NUMBER_PHP_2($order['unit_price']); ?></td>
                                <td><?= NUMBER_PHP_2($order['total_cost']); ?></td>
                                <td><?= CHARS($order['order_date']); ?></td>
                                <td><?= !empty($order['delivery_date']) ? htmlspecialchars($order['delivery_date']) : 'No date available'; ?></td>
                                <td>
                                    <span class="badge <?= $order['status'] == 'Delivered' ? 'bg-success' : ($order['status'] == 'Cancelled' ? 'bg-danger' : 'bg-secondary') ?>">
                                        <?= CHARS($order['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#updateStatusModal" 
                                            data-po_id="<?= $order['po_id']; ?>" 
                                            data-status="<?= $order['status']; ?>">
                                        Update Status
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Update Purchase Order Status -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">Update Purchase Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateStatusForm">
                <div class="modal-body">
                    <input type="hidden" name="po_id" id="modal_po_id" value="">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="modal_status" name="status" required>
                            <option value="Ordered">Ordered</option>
                            <option value="Delivered">Delivered</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks (Optional)</label>
                        <textarea class="form-control" id="modal_remarks" name="remarks" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Handle passing PO data to the modal
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function(button) {
        button.addEventListener('click', function() {
            const poId = button.getAttribute('data-po_id');
            const status = button.getAttribute('data-status');
            document.getElementById('modal_po_id').value = poId;
            document.getElementById('modal_status').value = status;
        });
    });

    // Handle form submission to update status
    document.getElementById('updateStatusForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const poId = document.getElementById('modal_po_id').value;
        const status = document.getElementById('modal_status').value;
        const remarks = document.getElementById('modal_remarks').value;

        fetch(`api/sync/purcchase_order_update.php?token=d368051b3cd2819131fff6811cf4e59cd&po_id=${poId}&status=${status}&remarks=${encodeURIComponent(remarks)}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Purchase Order status updated successfully!');
                    location.reload(); // Reload the page to reflect the updated status
                } else {
                    alert('Failed to update Purchase Order status.');
                }
            })
            .catch(error => console.error('Error updating status:', error));
    });
</script>
