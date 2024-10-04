
<div class="container">
<div class="row mt-4">
    <div class="col-md-4">
        <a href="?page=purchase_new_order" class="card card-body text-center">
        <div><i class="bi bi-plus fs-2"></i></div>    
        <h4>Create New Order</h4>
        </a>
    </div>
    <div class="col-md-4">
        <a href="?page=purchase_new_order" class="card card-body text-center">
        <div><i class="bi bi-list fs-2"></i></div>    
        <h4>Create New Order</h4>
        </a>
    </div>
    <div class="col-md-4">
        <a href="?page=purchase_new_order" class="card card-body text-center">
        <div><i class="bi bi-truck fs-2"></i></div>    
        <h4>Create New Order</h4>
        </a>
    </div>
</div>

<?php
    $data = $DB->SELECT("users", "username, email, role, created_at");
?>

<div class="mt-2">
    <div class="card card-body py-5 shadow">
        <h4 class="fw-bold">Data Listing</h4>

        <!-- Make the table responsive -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Created</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($data as $data){ ?>
                        <tr>
                            <td><?=$i++;?></td>
                            <td><?=$data['username']?></td>
                            <td><?=$data['email']?></td>
                            <td><?=$data['role']?></td>
                            <td><?=DATE_SHORT_TIME($data['created_at'])?></td>
                            <td>
                                <a href="?page=user-edit" class="btn btn-sm btn-success">Edit</a>
                                <a href="?page=user-delete" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div> <!-- End of table-responsive -->
    </div>
</div>

</div>
