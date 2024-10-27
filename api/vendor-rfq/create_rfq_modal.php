    <?php

    require("../../app/init.php");

    // Fetch vendors with the role "VENDOR" from the `users` table
    $where = array("role" => "VENDOR");
    $vendors = $DB->SELECT_WHERE("users", "*", $where, "ORDER BY user_id ASC");

    // Fetch products from the `vendor_products` table
    $products = $DB->SELECT("vendor_products", "*", "ORDER BY product_id ASC");


    ?>

    <div class="modal fade" id="createRFQModal" tabindex="-1" aria-labelledby="createRFQModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRFQModalLabel">Create RFQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createRFQForm">
                        <!-- Vendor Selection -->
                        <div class="mb-3">
                            <label for="vendor_name" class="form-label">Vendor Name</label>
                            <select class="form-control" name="vendor_id" id="vendor_id">
                                <?php foreach ($vendors as $vendor): ?>
                                    <option value="<?= $vendor['user_id']; ?>">
                                        <?= htmlspecialchars($vendor['vendor_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Product Selection -->
                        <div class="mb-3">
                            <label for="productId" class="form-label">Product Name</label>
                            <select class="form-select" id="productId" name="product_id" required>
                                <?php foreach ($products as $product): ?>
                                    <option value="<?= $product['product_id']; ?>"><?= htmlspecialchars($product['product_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Requested Quantity -->
                        <div class="mb-3">
                            <label for="requestedQuantity" class="form-label">Requested Quantity</label>
                            <input type="number" class="form-control" id="requestedQuantity" name="requested_quantity" required>
                        </div>

                        <!-- RFQ Status (Dropdown) -->
                        <div class="mb-3">
                            <label for="rfqStatus" class="form-label">RFQ Status</label>
                            <select class="form-select" id="rfqStatus" name="rfq_status">
                                <option value="Pending">Pending</option>
                            </select>
                        </div>

                        <!-- Response Date -->
                        <div class="mb-3">
                            <label for="responseDate" class="form-label">Response Date</label>
                            <input type="date" class="form-control" id="responseDate" name="response_date" required>
                        </div>

                        <!-- Remarks -->
                        <div class="mb-3">
                            <label for="responseRemarks">Remarks:</label>
                            <textarea class="form-control" id="responseRemarks" name="response_remarks"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success">Create RFQ</button>
                    </form>

                    <!-- Placeholder for response messages -->
                    <div id="response"></div>
                </div>
            </div>
        </div>
    </div>



    <script>
        $('#createRFQForm').submit(function(e) {
            e.preventDefault();
            $.post('api/vendor-rfq/create_rfq.php', $(this).serialize(), function(response) {
                $('#response').html(response);
            });
        });
    </script>