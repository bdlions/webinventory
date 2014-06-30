<h3>All staffs</h3>

<div class ="form-horizontal form-background top-bottom-padding">
    <div class="" style="color: red; text-align: center;"><?php print_r($this->session->flashdata('message'));?></div>
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
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>