<h3>Shop List</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Shop No</th>
                    <th>Shop Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Shop Type</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody id="tbody_product_list">
                <?php
                foreach ($shop_list as $key => $shop_info) {
                ?>
                    <tr>
                        <td><?php echo $shop_info['shop_no'] ?></td>
                        <td><?php echo $shop_info['name'] ?></td>
                        <td><?php echo $shop_info['subscription_start'] ?></td>
                        <td><?php echo $shop_info['subscription_end'] ?></td>
                        <td><?php echo $shop_info['shop_type'] ?></td>
                        <td><a href="<?php echo base_url("./shop/subscription_update_shop/".$shop_info['id']);?>">Update</a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>