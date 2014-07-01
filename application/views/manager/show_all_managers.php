<h3><?php echo $this->lang->line("user_show_all_manager_all_admin");?></h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><?php echo $this->lang->line("user_create_manager_user_name");?></th>
                    <th><?php echo $this->lang->line("user_create_manager_first_name");?></th>
                    <th><?php echo $this->lang->line("user_create_manager_last_name");?></th>
                    <th><?php echo $this->lang->line("user_create_manager_phone_no");?></th>
                    <th><?php echo $this->lang->line("user_create_manager_address");?></th>
                    <th><?php echo $this->lang->line("user_show_all_manager_all_manage");?></th>
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
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>