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
            <tbody id="tbody_staff_list">
                <?php
                foreach ($staff_list as $staff_info) {
                ?>
                    <tr>
                        <td><?php echo $staff_info['username'] ?></td>
                        <td><?php echo $staff_info['first_name'] ?></td>
                        <td><?php echo $staff_info['last_name'] ?></td>
                        <td><?php echo $staff_info['phone'] ?></td>
                        <td><?php echo $staff_info['address'] ?></td>
                        <td><a href="<?php echo base_url("./staff/update_staff/" . $staff_info['user_id']); ?>">Update</a></td>                            
                        <?php if($staff_info['account_status_id'] == ACCOUNT_STATUS_ACTIVE){?>
                        <td><a onclick="open_modal_inactive_account_status_confirm(<?php echo $staff_info['user_id'] ?>)"><?php echo $staff_info['account_status'];?></a></td>
                        <?php }else if($staff_info['account_status_id'] == ACCOUNT_STATUS_INACTIVE){?>
                        <td><a onclick="open_modal_active_account_status_confirm(<?php echo $staff_info['user_id'] ?>)"><?php echo $staff_info['account_status'];?></a></td>
                        <?php }?>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
$this->load->view("user/modal/active_account_status_confirm");
$this->load->view("user/modal/inactive_account_status_confirm");