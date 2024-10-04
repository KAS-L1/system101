<div class="container py-5">
    <div class="row mb-4">
        <!-- Create Purchase Order -->
        <div class="col-md-3">
            <div class="card shadow h-60">
                <div class="card-body text-center">
                    <h5 class="card-title">Create New Order</h5>
                    <p class="card-text">Manually create a new purchase order.</p>
                    <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#createOrdersModal">Create Order</button>
                </div>
            </div>
        </div>

        <!-- View Active Orders -->
        <div class="col-md-3">
            <div class="card shadow h-60">
                <div class="card-body text-center">
                    <h5 class="card-title">View Active Orders</h5>
                    <p class="card-text">Track current purchase orders.</p>
                    <a class="btn btn-primary mt-4 w-100" data-bs-toggle="modal" data-bs-target="#viewOrdersModal">View Orders</a>
                </div>
            </div>
        </div>

        <!-- Order History -->
        <div class="col-md-3">
            <div class="card shadow h-60">
                <div class="card-body text-center">
                    <h5 class="card-title">Order History</h5>
                    <p class="card-text">View past orders including delivered, canceled, or rejected.</p>
                    <a class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#orderHistoryModal2">View History</a>
                </div>
            </div>
        </div>

        <!-- Track Order -->
        <div class="col-md-3">
            
        </div>
    </div>

    <!-- Listing Table: Active Purchase Orders -->
    <div class="card card-body mb-4 py-5 shadow">
        <h4 class="fw-bold">Active Purchase Orders</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Order ID</th>
                        <th scope="col">Product</th>
                        <th scope="col">Supplier</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Order Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $orders = $DB->SELECT("orders", "*"); 
                        $i = 1;
                        foreach ($orders as $order) { ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $order['id']; ?></td>
                                <td><?= $order['product_name']; ?></td>
                                <td><?= $order['supplier']; ?></td>
                                <td><?= $order['quantity']; ?></td>
                                <td><?= $order['order_date']; ?></td>
                                <td><?= $order['status']; ?></td>
                                <td>
                                    <a href="edit_purchase.php?id=<?= $order['id']; ?>" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editPurchaseOrderModal">Edit</a>
                                    <a href="cancel_order.php?id=<?= $order['id']; ?>" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">Cancel</a>
                                    <a href="approve_purchase.php?id=<?= $order['id']; ?>" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#approveOrderModal">Approve</a>
                                </td>
                            </tr>
                        <?php } ?>
                </tbody>
            </table>
        </div> 
    </div>
</div>

<!-- Modal For Create Order -->
<div class="modal fade" id="createOrdersModal" tabindex="-1" aria-labelledby="createOrdersModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class=" modal-title fs-5 " id="createOrdersModalLabel "> Create New Order</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
      </div>
      <div class="modal-body">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="mb-3">
          <label for="product_name" class="form-label">Product Name:</label>
          <input type="text" class="form-control" id="product_name" name="product_name" required>
        </div>
        <div class="mb-3">
          <label for="supplier" class="form-label">Supplier:</label>
          <input type="text" class="form-control" id="supplier" name="supplier" required>
        </div>
        <div class="mb-3">
          <label for="quantity" class="form-label">Quantity:</label>
          <input type="number" class="form-control" id="quantity" name="quantity" required>
        </div>
        <div class="mb-3">
          <label for="order_date" class="form-label">Order Date:</label>
          <input type="date" class="form-control" id="order_date" name="order_date" required>
        </div>
        <button type="submit" class="btn btn-primary" name="create_order">Create Order</button>
      </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal For View Orders -->
<div class="modal fade" id="viewOrdersModal" tabindex="-1" aria-labelledby="viewOrdersModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 " id="viewOrdersModalLabel">Active Purchase Orders</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Order ID</th>
                <th scope="col">Product</th>
                <th scope="col">Supplier</th>
                <th scope="col">Quantity</th>
                <th scope="col">Order Date</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $orders = $DB->SELECT("orders", "*"); 
                  $i = 1;
                  foreach ($orders as $order) { ?>
                      <tr>
                          <td><?= $i++; ?></td>
                          <td><?= $order['id']; ?></td>
                          <td><?= $order['product_name']; ?></td>
                          <td><?= $order['supplier']; ?></td>
                          <td><?= $order['quantity']; ?></td>
                          <td><?= $order['order_date']; ?></td>
                          <td><?= $order['status']; ?></td>
                          <td>
                              <a href="edit_purchase.php?id=<?= $order['id']; ?>" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editPurchaseOrderModal">Edit</a>
                              <a href="cancel_order.php?id=<?= $order['id']; ?>" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">Cancel</a>
                              <a href="approve_purchase.php?id=<?= $order['id']; ?>" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#approveOrderModal">Approve</a>
                          </td>
                      </tr>
                  <?php } ?>
            </tbody>
          </table>
        </div> 
      </div>
    </div>
  </div>
</div>

<!-- Modal For Order History -->
<div class="modal fade" id="orderHistoryModal2" tabindex="-1" aria-labelledby="orderHistoryModal Label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 " id="orderHistoryModalLabel">Order History</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Order ID</th>
                <th scope="col">Product</th>
                <th scope="col">Supplier</th>
                <th scope="col">Quantity</th>
                <th scope="col">Order Date</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $orders = $DB->SELECT("orders", "*"); 
                  $i = 1;
                  foreach ($orders as $order) { ?>
                      <tr>
                          <td><?= $i++; ?></td>
                          <td><?= $order['id']; ?></td>
                          <td><?= $order['product_name']; ?></td>
                          <td><?= $order['supplier']; ?></td>
                          <td><?= $order['quantity']; ?></td>
                          <td><?= $order['order_date']; ?></td>
                          <td><?= $order['status']; ?></td>
                          <td>
                          <a href="edit_purchase.php?id=<?= $order['id']; ?>" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editPurchaseOrderModal">Edit</a>
                          <a href="cancel_order.php?id=<?= $order['id']; ?>" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">Cancel</a>
                          <a href="approve_purchase.php?id=<?= $order['id']; ?>" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#approveOrderModal">Approve</a>
                          </td>
                      </tr>
                  <?php } ?>
            </tbody>
          </table>
        </div> 
      </div>
    </div>
  </div>
</div>

<!-- Edit Purchase Order -->
<div class="modal fade" id="editPurchaseOrderModal" tabindex="-1" aria-labelledby="editPurchaseOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editPurchaseOrderModalLabel">Edit Purchase Order</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="mb-3">
            <label for="product_name" class="form-label">Product Name:</label>
            <input type="text" class="form-control" id="product_name" name="product_name" required>
          </div>
          <div class="mb-3">
            <label for="supplier" class="form-label">Supplier:</label>
            <input type="text" class="form-control" id="supplier" name="supplier" required>
          </div>
          <div class="mb-3">
            <label for="quantity" class="form-label">Quantity:</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
          </div>
          <div class="mb-3">
            <label for="order_date" class="form-label">Order Date:</label>
            <input type="date" class="form-control" id="order_date" name="order_date" required>
          </div>
          <div class="mb-3">
            <label for="status" class="form-label">Status:</label>
            <select class="form-select" aria-label="Default select example" id="status" name="status" required>
              <option selected disabled value="">Select Status</option>
              <option value="Pending">Pending</option>
              <option value="Delivered">Delivered</option>
              <option value="Rejected">Rejected</option>
              <option value="Cancelled">Cancelled</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary" name="edit_purchase_order">Edit Purchase Order</ button>
        </form>
      </div>
    </div>
  </div>
</div >

<!-- Cancel Order -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="cancelOrderModalLabel">Cancel Order</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to cancel this order?</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
          <button type="submit" class="btn btn-danger" name="cancel_order">Cancel Order</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Approve Order -->
<div class="modal fade" id="approveOrderModal" tabindex="-1" aria-labelledby="approveOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="approveOrderModalLabel">Approve Order</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to approve this order?</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
          <button type="submit" class="btn btn-success" name="approve_order">Approve Order</button>
        </form>
      </div>
    </div>
  </div>
</div>