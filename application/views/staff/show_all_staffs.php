<h3>All Staffs</h3>
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
                foreach ($salesman_list as $salesman_info) {
                ?>
                    <tr>
                        <td><?php echo $salesman_info['username'] ?></td>
                        <td><?php echo $salesman_info['first_name'] ?></td>
                        <td><?php echo $salesman_info['last_name'] ?></td>
                        <td><?php echo $salesman_info['phone'] ?></td>
                        <td><?php echo $salesman_info['address'] ?></td>
                        <td><a href="<?php echo base_url("./user/update_salesman/" . $salesman_info['user_id']); ?>">Update</a></td>                            
                        <td><a role="menuitem" tabindex="-1" href="javascript:void(o)" onclick="open_modal_delete_confirm(<?php echo $salesman_info['user_id'] ?>)">Inactive</a></td>                            
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php $this->load->view("staff/modal_inactive_staff_confirmation");