<?php
include_once('api/middleware/role_access_kitchen.php');

// Retrieve all menu items from the `menu_items` table
$menuItems = $DB->SELECT("menu_items", "*", "ORDER BY item_id DESC");
?>

<div class="container mt-5">
    <div class="row g-4">
        <div class="container mt-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light text-success d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Menu Management</h5>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-success" id="btnGenerateReport">
                            <i class="fas fa-download"></i> Generate Report
                        </button>
                        <button class="btn btn-sm btn-primary" id="btnAddNewItem">
                            <i class="fas fa-plus"></i> Add New Item
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <input type="text" id="searchBar" class="form-control" placeholder="Search by item name or category...">
                        <select id="filterCategory" class="form-select mt-2">
                            <option value="">All Categories</option>
                            <option value="Seasonal">Seasonal</option>
                            <option value="Event Specific">Event Specific</option>
                        </select>
                        <div class="form-check form-check-inline mt-2">
                            <input type="checkbox" class="form-check-input" id="filterSeasonal">
                            <label class="form-check-label" for="filterSeasonal">Seasonal</label>
                        </div>
                        <div class="form-check form-check-inline mt-2">
                            <input type="checkbox" class="form-check-input" id="filterEventSpecific">
                            <label class="form-check-label" for="filterEventSpecific">Event Specific</label>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="menuTable" class="table table-bordered table-hover table-sm mb-0 shadow-sm">
                            <thead class="table-success">
                                <tr>
                                    <th>#</th>
                                    <th>Item ID</th>
                                    <th>Item Name</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Availability</th>
                                    <th>Seasonal</th>
                                    <th>Event Specific</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="menuItems">
                                <?php
                                $i = 1;
                                foreach ($menuItems as $item) {
                                    // Convert 1/0 to "Yes"/"No" for better readability on the frontend
                                    $availability = $item['availability'] == 1 ? 'Yes' : 'No';
                                    $seasonal = $item['seasonal'] == 1 ? 'Yes' : 'No';
                                    $eventSpecific = $item['event_specific'] == 1 ? 'Yes' : 'No';
                                ?>
                                    <tr id="menuItem-<?= $item['item_id']; ?>">
                                        <td><?= $i++; ?></td>
                                        <td><?= htmlspecialchars($item['item_id']); ?></td>
                                        <td><?= htmlspecialchars($item['item_name']); ?></td>
                                        <td><?= htmlspecialchars($item['category']); ?></td>
                                        <td><?= htmlspecialchars($item['description']); ?></td>
                                        <td><?= NUMBER_PHP($item['price'], 2); ?></td>
                                        <td><span class="badge badge-availability <?= $availability === 'Yes' ? 'bg-success' : 'bg-danger'; ?>"><?= htmlspecialchars($availability); ?></span></td>
                                        <td><span class="badge <?= $seasonal === 'Yes' ? 'bg-success' : 'bg-danger'; ?>"><?= htmlspecialchars($seasonal); ?></span></td>
                                        <td><span class="badge <?= $eventSpecific === 'Yes' ? 'bg-success' : 'bg-danger'; ?>"><?= htmlspecialchars($eventSpecific); ?></span></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-sm btn-light shadow-sm editItem" data-item_id="<?= $item['item_id']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger shadow-sm deleteItem" data-item_id="<?= $item['item_id']; ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <!-- Toggle Availability Button (Icon Only) -->
                                                <button class="btn btn-sm <?= $availability === 'Yes' ? 'btn-success' : 'btn-secondary'; ?> shadow-sm toggleAvailability" data-item_id="<?= $item['item_id']; ?>" data-availability="<?= $availability; ?>">
                                                    <i class="fas <?= $availability === 'Yes' ? 'fa-toggle-on' : 'fa-toggle-off'; ?>"></i>
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
        // Add New Item
        $('#btnAddNewItem').click(function() {
            $.post('api/menu/add_item_form.php', function(response) {
                $('#responseModal').html(response);
                $('#addItemModal').modal('show');
            });
        });

        // Edit Menu Item
        $('.editItem').click(function() {
            const item_id = $(this).data('item_id');
            $.post('api/menu/edit_item_form.php', {
                item_id
            }, function(response) {
                $('#responseModal').html(response);
                $('#editItemModal').modal('show');
            });
        });

        // Delete Menu Item
        $('.deleteItem').click(function() {
            const item_id = $(this).data('item_id');
            Swal.fire({
                title: "Are you sure you want to delete this item?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, Delete",
                confirmButtonColor: '#198754',
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('api/menu/delete_menu_item.php', {
                        item_id
                    }, function(response) {
                        $('#responseModal').html(response);
                        $(`#menuItem-${item_id}`).remove();
                        swalAlert('success', 'Item has been deleted!');
                    }).fail(function() {
                        swalAlert('error', 'Failed to delete item. Please try again.');
                    });
                }
            });
        });

        // Toggle Availability
        $('.toggleAvailability').click(function() {
            const toggleButton = $(this);
            const item_id = toggleButton.data('item_id');
            const currentAvailability = toggleButton.data('availability');
            const newAvailability = currentAvailability === 'Yes' ? 'No' : 'Yes';

            $.post('api/menu/toggle_availability.php', {
                item_id: item_id,
                availability: newAvailability === 'Yes' ? 1 : 0 // Send 1 for Yes and 0 for No to backend
            }, function(response) {
                // Update button and icon based on the new availability
                toggleButton.data('availability', newAvailability)
                    .toggleClass('btn-success btn-secondary') // Change color based on availability
                    .find('i').toggleClass('fa-toggle-on fa-toggle-off');

                // Update the availability badge in the row
                const availabilityBadge = $(`#menuItem-${item_id} .badge-availability`);
                availabilityBadge.removeClass('bg-success bg-danger')
                    .addClass(newAvailability === 'Yes' ? 'bg-success' : 'bg-secondary')
                    .text(newAvailability);
            }).fail(function() {
                swalAlert('error', 'Failed to update availability. Please try again.');
            });
        });

        // Filter by Seasonal and Event-Specific checkboxes
        $('#filterSeasonal, #filterEventSpecific').change(function() {
            const isSeasonalChecked = $('#filterSeasonal').is(':checked');
            const isEventSpecificChecked = $('#filterEventSpecific').is(':checked');

            $('#menuItems tr').each(function() {
                const isSeasonal = $(this).find('td:eq(7)').text().toLowerCase() === 'yes';
                const isEventSpecific = $(this).find('td:eq(8)').text().toLowerCase() === 'yes';

                const shouldShow = (!isSeasonalChecked || isSeasonal) && (!isEventSpecificChecked || isEventSpecific);
                $(this).toggle(shouldShow);
            });
        });

        // Search Functionality
        $('#searchBar').on('keyup', function() {
            const searchValue = $(this).val().toLowerCase();
            $('#menuItems tr').each(function() {
                $(this).toggle($(this).text().toLowerCase().includes(searchValue));
            });
        });

        // Filter by Category
        $('#filterCategory').on('change', function() {
            const filterValue = $(this).val();
            $('#menuItems tr').each(function() {
                const category = $(this).find('td:eq(3)').text();
                $(this).toggle(filterValue === "" || category.includes(filterValue));
            });
        });

        // Generate Report
        $('#btnGenerateReport').click(function() {
            window.open('api/menu/generate_report.php', '_blank');
        });
    });
</script>