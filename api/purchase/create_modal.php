<?php require("../../app/init.php") ?>

<?php     $suppliers = $DB->SELECT("suppliers", "*"); 
 ?>

<div class="modal fade" id="createOrderModal" tabindex="-1" aria-labelledby="createOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createOrderModalLabel">Create New Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Create New Order Form -->
                <form id="formCreateOrder">
                    <div class="mb-3">
                        <label for="orderSupplier" class="form-label">Supplier</label>
                        <select id="orderSupplier" name="supplier" class="form-select" required>
                            <option selected>Select supplier...</option>
                            <?php foreach($suppliers as $supplier) { ?>
                            <option><?=$supplier['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="orderDate" class="form-label">Order Date</label>
                        <input type="date" id="order_date" name="order_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="orderTotal" class="form-label">Total amount</label>
                        <input type="number" id="total_amount" name="total_amount" class="form-control"
                            placeholder="Enter total amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="orderNotes" class="form-label">Additional Notes</label>
                        <textarea name="notes" class="form-control" rows="3"
                            placeholder="Optional notes for the order"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save Order</button>
                    </div>
                </form>

                <div id="responseModal"></div>

                <script>
                $('#formCreateOrder').submit(function(e) {
                    e.preventDefault();
                    var formData = $(this).serialize();
                    $.post("api/purchase/create.php", formData, function(response) {
                        $('#responseModal').html(response);
                    });
                });
                </script>

            </div>
        </div>
    </div>
</div>