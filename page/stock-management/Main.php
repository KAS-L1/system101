<?php
include_once('api/middleware/role_access_kitchen.php');

// Retrieve all stock items from the `stock_items` table
$stockItems = $DB->SELECT("stock_items", "*", "ORDER BY stock_id DESC");
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light text-success d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="mb-0">Stock Management</h5>
                    <div class="d-flex gap-2 mt-2 mt-md-0">
                        <button class="btn btn-sm btn-success" id="btnGenerateStockReport">
                            <i class="fas fa-download"></i> Generate Report
                        </button>
                        <button class="btn btn-sm btn-primary" id="btnAddNewStockItem">
                            <i class="fas fa-plus"></i> Add Stock Item
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12 col-md-6 mb-2">
                            <input type="text" id="stockSearchBar" class="form-control" placeholder="Search by item name or category...">
                        </div>
                        <div class="col-12 col-md-6">
                            <select id="stockFilterCategory" class="form-select">
                                <option value="">All Categories</option>
                                <option value="Perishable">Perishable</option>
                                <option value="Non-perishable">Non-perishable</option>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="stockTable" class="table table-bordered table-hover table-sm mb-0 shadow-sm">
                            <thead class="table-success">
                                <tr>
                                    <th>#</th>
                                    <th>Stock ID</th>
                                    <th>Item Name</th>
                                    <th>Category</th>
                                    <th>Current Stock</th>
                                    <th>Reorder Level</th>
                                    <th>Supplier</th>
                                    <th>Unit Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="stockItems">
                                <?php
                                if ($stockItems) {
                                    $i = 1;
                                    foreach ($stockItems as $item) {
                                        $status = ($item['current_stock_level'] < $item['reorder_level']) ? 'Low Stock' : 'In Stock';
                                        $badgeClass = ($status === 'Low Stock') ? 'bg-danger' : 'bg-success';
                                ?>
                                        <tr id="stockItem-<?= $item['stock_id']; ?>">
                                            <td><?= $i++; ?></td>
                                            <td><?= htmlspecialchars($item['stock_id']); ?></td>
                                            <td><?= htmlspecialchars($item['item_name']); ?></td>
                                            <td><?= htmlspecialchars($item['category']); ?></td>
                                            <td><?= htmlspecialchars($item['current_stock_level']); ?></td>
                                            <td><?= htmlspecialchars($item['reorder_level']); ?></td>
                                            <td><?= htmlspecialchars($item['supplier']); ?></td>
                                            <td><?= number_format($item['unit_price'], 2); ?></td>
                                            <td><span class="badge <?= $badgeClass; ?>"><?= $status; ?></span></td>
                                            <td>
                                                <div class="d-flex gap-1 justify-content-center flex-nowrap">
                                                    <button class="btn btn-sm btn-light shadow-sm editStockItem" data-stock_id="<?= $item['stock_id']; ?>" style="width: 35px; height: 35px;">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger shadow-sm deleteStockItem" data-stock_id="<?= $item['stock_id']; ?>" style="width: 35px; height: 35px;">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-warning shadow-sm restockStockItem" data-stock_id="<?= $item['stock_id']; ?>" style="width: 35px; height: 35px;">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                    <?php if ($status === 'Low Stock') : ?>
                                                        <a href="/purchase-requisition" class="btn btn-sm btn-info shadow-sm" style="width: 35px; height: 35px;">
                                                            <i class="fas fa-file-alt"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='10' class='text-center'>No stock items found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="responseModal"></div>

<script>
    $(document).ready(function() {
        // Add New Stock Item
        $('#btnAddNewStockItem').click(function() {
            $.post('api/stock/add_stock_item_form.php', function(response) {
                $('#responseModal').html(response);
                $('#addStockItemModal').modal('show');
            });
        });

        // Edit Stock Item
        $('.editStockItem').click(function() {
            const stock_id = $(this).data('stock_id');
            $.post('api/stock/edit_stock_item_form.php', {
                stock_id
            }, function(response) {
                $('#responseModal').html(response);
                $('#editStockItemModal').modal('show');
            });
        });

        // Delete Stock Item
        $('.deleteStockItem').click(function() {
            const stock_id = $(this).data('stock_id');
            Swal.fire({
                title: "Are you sure you want to delete this stock item?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, Delete",
                confirmButtonColor: '#198754',
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('api/stock/delete_stock_item.php', {
                        stock_id
                    }, function(response) {
                        $('#responseModal').html(response);
                        $(`#stockItem-${stock_id}`).remove();
                        swalAlert('success', 'Stock item has been deleted!');
                    }).fail(function() {
                        swalAlert('error', 'Failed to delete stock item. Please try again.');
                    });
                }
            });
        });

        // Restock Item
        $('.restockStockItem').click(function() {
            const stock_id = $(this).data('stock_id');
            $.post('api/stock/restock_item_form.php', {
                stock_id
            }, function(response) {
                $('#responseModal').html(response);
                $('#restockItemModal').modal('show');
            });
        });

        // Search and Filter Functions
        $('#stockSearchBar').on('keyup', function() {
            const searchValue = $(this).val().toLowerCase();
            $('#stockItems tr').each(function() {
                $(this).toggle($(this).text().toLowerCase().includes(searchValue));
            });
        });

        $('#stockFilterCategory').on('change', function() {
            const filterValue = $(this).val();
            $('#stockItems tr').each(function() {
                const category = $(this).find('td:eq(3)').text();
                $(this).toggle(filterValue === "" || category.includes(filterValue));
            });
        });

        // Generate Report
        $('#btnGenerateStockReport').click(function() {
            window.open('api/stock/generate_stock_report.php', '_blank');
        });
    });
</script>