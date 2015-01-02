<h3>Admin List</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Manage</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="tbody_product_list">
                <?php
                foreach ($manager_list as $key => $manager_info) {
                ?>
                    <tr>
                        <td><?php echo $manager_info['username'] ?></td>
                        <td><?php echo $manager_info['first_name'] ?></td>
                        <td><?php echo $manager_info['last_name'] ?></td>
                        <td><?php echo $manager_info['phone'] ?></td>
                        <td><?php echo $manager_info['address'] ?></td>
                        <td><a href="<?php echo base_url("./user/update_manager/" . $manager_info['user_id']); ?>">Update</a></td>                        
                        <td><a href="">Inactive</a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>