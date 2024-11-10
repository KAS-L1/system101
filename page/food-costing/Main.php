<?php
include_once('api/middleware/role_access_kitchen.php');

// Retrieve all food costing items from the `food_costing` table
$foodCostingItems = $DB->SELECT("food_costing", "*", "ORDER BY id DESC");
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light text-success d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Food Costing Management</h5>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-success" id="btnGenerateFoodCostReport">
                            <i class="fas fa-download"></i> Generate Report
                        </button>
                        <button class="btn btn-sm btn-primary" id="btnAddNewFoodCostItem">
                            <i class="fas fa-plus"></i> Add New Item
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <input type="text" id="searchBar" placeholder="Search by Menu Item" class="form-control">
                    </div>
                    <div class="table-responsive overflow-auto">
                        <table id="foodCostTable" class="table table-bordered table-hover table-sm mb-0 shadow-sm">
                            <thead class="table-success">
                                <tr>
                                    <th>#</th>
                                    <th>Menu Item</th>
                                    <th>Ingredients</th>
                                    <th>Cost per Ingredient</th>
                                    <th>Total Ingredient Cost</th>
                                    <th>Selling Price</th>
                                    <th>Profit Margin</th>
                                    <th>Food Cost %</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="foodCostItems">
                                <?php
                                $i = 1;
                                foreach ($foodCostingItems as $item) {
                                    $ingredientsArray = json_decode($item['ingredients'], true);
                                    $costPerIngredientArray = json_decode($item['cost_per_ingredient'], true);

                                    $ingredientsArray = is_array($ingredientsArray) ? $ingredientsArray : [];
                                    $costPerIngredientArray = is_array($costPerIngredientArray) ? $costPerIngredientArray : [];

                                    $ingredients = implode(", ", $ingredientsArray);
                                    $costPerIngredient = implode(", ", array_map(fn($cost) => '₱' . number_format($cost, 2), $costPerIngredientArray));
                                ?>
                                    <tr id="foodCostItem-<?= $item['id']; ?>">
                                        <td><?= $i++; ?></td>
                                        <td><?= htmlspecialchars($item['menu_item']); ?></td>
                                        <td><?= htmlspecialchars($ingredients); ?></td>
                                        <td><?= htmlspecialchars($costPerIngredient); ?></td>
                                        <td>₱<?= number_format($item['total_ingredient_cost'], 2); ?></td>
                                        <td>₱<?= number_format($item['selling_price'], 2); ?></td>
                                        <td>₱<?= number_format($item['profit_margin'], 2); ?></td>
                                        <td><?= number_format($item['food_cost_percentage'], 2); ?>%</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-1">
                                                <button class="btn btn-sm btn-light editFoodCostItem" data-id="<?= $item['id']; ?>" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-light viewFoodCostItem" data-id="<?= $item['id'] ?>">
                                                    <i class="fas fa-eye"></i> View Details
                                                </button>
                                                <button class="btn btn-sm btn-danger deleteFoodCostItem" data-id="<?= $item['id']; ?>" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
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
</div>

<div id="responseModal"></div>

<script>
    $(document).ready(function() {
        // Add New Food Cost Item
        $('#btnAddNewFoodCostItem').click(function() {
            $.post('api/food-costing/add_food_cost_item_form.php', function(response) {
                $('#responseModal').html(response);
                $('#addFoodCostItemModal').modal('show');
            });
        });

        // Edit Food Cost Item
        $('.editFoodCostItem').click(function() {
            const id = $(this).data('id');
            $.post('api/food-costing/edit_food_cost_item_form.php', {
                id: id
            }, function(response) {
                $('#responseModal').html(response);
                $('#editFoodCostItemModal').modal('show');
            });
        });

        // View Food Cost Item
        $('.viewFoodCostItem').click(function() {
            const id = $(this).data('id');
            $.post('api/food-costing/view_food_cost_item_form.php', {
                id: id
            }, function(response) {
                $('#responseModal').html(response);
                $('#viewFoodCostItemModal').modal('show');
            });
        });

        // Delete Food Cost Item
        $('.deleteFoodCostItem').click(function() {
            const id = $(this).data('id');
            Swal.fire({
                title: "Are you sure you want to delete this item?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, Delete",
                confirmButtonColor: '#198754',
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('api/food-costing/delete_food_cost_item.php', {
                        id: id
                    }, function(response) {
                        $('#responseModal').html(response);
                        $(`#foodCostItem-${id}`).remove();
                        swalAlert('success', 'Item has been deleted!');
                    }).fail(function() {
                        swalAlert('error', 'Failed to delete item. Please try again.');
                    });
                }
            });
        });

        // Generate Report
        $('#btnGenerateFoodCostReport').click(function() {
            window.open('api/food-costing/generate_food_cost_report.php', '_blank');
        });

        // Search Functionality
        $('#searchBar').on('keyup', function() {
            const searchValue = $(this).val().toLowerCase();
            $('#foodCostItems tr').each(function() {
                $(this).toggle($(this).text().toLowerCase().includes(searchValue));
            });
        });
    });
</script>