<div class="container mt-4 py-5">
    <div class="row text-center">
        <!-- Card 1: Create New Order -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-invoice fa-2x text-success mb-3"></i>
                    <h6 class="card-title">Create New Order</h6>
                    <p class="card-text text-muted small">Quick access to create a purchase order.</p>
                    <!-- Button to Open Modal -->
                    <button id="btnCreateOrder" class="btn btn-sm btn-success">Create Order</button>
                </div>
            </div>
        </div>

        <!-- Card 2: View Active Orders -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-eye fa-2x text-success mb-3"></i>
                    <h6 class="card-title">View Active Orders</h6>
                    <p class="card-text text-muted small">Monitor and manage active purchase orders.</p>
                    <!-- Button to Open Modal -->
                    <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal"
                        data-bs-target="#viewOrdersModal">View Orders</a>
                </div>
            </div>
        </div>

        <!-- Card 3: Check Supplier Status -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-user-tie fa-2x text-success mb-3"></i>
                    <h6 class="card-title">Check Supplier Status</h6>
                    <p class="card-text text-muted small">Access supplier directory and view performance.</p>
                    <!-- Button to Open Modal -->
                    <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal"
                        data-bs-target="#supplierStatusModal">Check Status</a>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal 2: View Active Orders -->
    <div class="modal fade" id="viewOrdersModal" tabindex="-1" aria-labelledby="viewOrdersModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewOrdersModalLabel">Active Purchase Orders</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Active Orders List -->
                    <table id="dataTable" class="table table-hover table-sm">
                        <thead class="table text-success">
                            <tr>
                                <th>#</th>
                                <th>Order ID</th>
                                <th>Order Date</th>
                                <th>Supplier</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1; 
                            $orders = $DB->SELECT('orders', '*'); 
                            foreach ($orders as $order) {
                            ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= CHARS($order['id']); ?></td>
                                <td><?= CHARS($order['order_date']); ?></td>
                                <td><?= CHARS($order['supplier']); ?></td>
                                <td><?= CHARS($order['total_amount']); ?></td>
                                <td><?= CHARS($order['status']); ?></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 3: Check Supplier Status -->
    <div class="modal fade" id="supplierStatusModal" tabindex="-1" aria-labelledby="supplierStatusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supplierStatusModalLabel">Supplier Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Supplier Status Content -->
                    <p class="text-muted">Supplier performance data:</p>
                    <ul>
                        <li><strong>Supplier 1:</strong> Excellent (100% on-time deliveries)</li>
                        <li><strong>Supplier 2:</strong> Good (90% on-time deliveries)</li>
                        <li><strong>Supplier 3:</strong> Average (75% on-time deliveries)</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Table for Orders -->
    <div class="table-responsive mt-4">
        <table id="dataTable" class="table table-bordered table-hover table-sm shadow-sm">
            <thead class="thead-light text-success">
                <tr>
                    <th>#</th>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Supplier</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1; 
                $orders = $DB->SELECT("orders", "*", "ORDER BY id DESC"); 
                foreach ($orders as $order) {
                    ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?=$order['id']; ?></td>
                    <td><?=$order['order_date'] ?></td>
                    <td><?=$order['supplier'] ?></td>
                    <td><?= NUMBER_PHP($order['total_amount']) ?></td>
                    <td>
                        <?php if($order['status'] == "Pending"){ ?>
                        <span class="badge bg-secondary">Pending</span>
                        <?php }else if($order['status'] == "Approve"){ ?>
                        <span class="badge bg-success">Approve</span>
                        <?php }else if($order['status'] == "Reject"){ ?>
                        <span class="badge bg-danger">Rejected</span>
                        <?php } ?>
                    </td>
                    <td><?=$order['updated_at']?></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-light shadow-sm shadow-sm selectOrder"
                            data-order_id="<?=$order['id']?>"><i class="bi bi-pencil-square"></i></button>
                        <?php if($order['status'] != "Approve"){ ?>
                        <button class="btn btn-sm btn-success shadow-sm selectApprove"
                            data-order_id="<?=$order['id']?>"><i class="bi bi-check-circle"></i></button>
                        <?php }else{ ?>
                        <button class="btn btn-sm btn-success shadow-sm" disabled><i
                                class="bi bi-check-circle"></i></button>
                        <?php } ?>
                        <?php if($order['status'] != "Reject"){ ?>
                        <button class="btn btn-sm btn-danger shadow-sm selectReject"
                            data-order_id="<?=$order['id']?>"><i class="bi bi-x-circle"></i></button>
                        <?php }else{ ?>
                        <button class="btn btn-sm btn-danger shadow-sm" disabled><i class="bi bi-x-circle"></i></button>
                        <?php } ?>
                        <a href="track_order?id=<?=$order['id']?>" class="btn btn-sm btn-secondary"><i
                                class="bi bi-truck"></i></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div id="response"></div>

<script>
$('#btnCreateOrder').click(function() {
    $.post('api/purchase/create_modal.php', function(res) {
        $('#response').html(res);
        $('#createOrderModal').modal('show');
    });
});

$('.selectOrder').click(function() {
    const order_id = $(this).data('order_id');
    $.post('api/purchase/edit_modal.php', {
        order_id: order_id
    }, function(res) {
        $('#response').html(res);
        $('#editOrderModal').modal('show');
    });
});

$('.selectApprove').click(function() {
    const order_id = $(this).data('order_id');
    $.post('api/purchase/approve.php', {
        order_id: order_id
    }, function(res) {
        $('#response').html(res);
    });
});

$('.selectReject').click(function() {
    const order_id = $(this).data('order_id');
    $.post('api/purchase/reject.php', {
        order_id: order_id
    }, function(res) {
        $('#response').html(res);
    });
});
</script>