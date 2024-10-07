<?php require("../../app/init.php") ?>



<?php 

    $order_id = $_POST['order_id'];
    $where = array("id" => $order_id);
    $order = $DB->SELECT_ONE_WHERE("orders", "*", $where); 
    $suppliers = $DB->SELECT("suppliers", "*"); 


?>


<div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="createOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createOrderModalLabel">Edit Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- Edit Order Form -->
                <form id="formEditOrder">
                    <input type="hidden" name="order_id" value="<?=$order['id']?>">
                    <div class="mb-3">
                        <label for="orderSupplier" class="form-label">Supplier</label>
                        <select id="orderSupplier" name="supplier" class="form-select" required>
                            <option selected><?=$order['supplier']?></option>
                            <?php foreach($suppliers as $supplier) { ?>
                            <option><?=$supplier['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="orderDate" class="form-label">Order Date</label>
                        <input type="date" id="order_date" name="order_date" class="form-control"
                            value="<?=$order['order_date']?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="orderTotal" class="form-label">Total Amount</label>
                        <input type="number" id="total_amount" name="total_amount" class="form-control"
                            value="<?=$order['total_amount']?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="orderNotes" class="form-label">Additional Notes</label>
                        <textarea name="notes" class="form-control" rows="3"
                            placeholder="Optional notes for the order"><?=$order['notes']?></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update Order</button>
                    </div>
                </form>

                <div id="responseModal"></div>

                <script>
                $('#formEditOrder').submit(function(e) {
                    e.preventDefault();
                    var formData = $(this).serialize();
                    $.post("api/purchase/update.php", formData, function(response) {
                        $('#responseModal').html(response);
                    });
                });
                </script>

            </div>
        </div>
    </div>
</div>