<h3>Message Category List</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Message Category No</th>
                    <th>Message category Name</th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody id="tbody_product_list">
                <?php
                foreach ($message_category_list as $key => $message_category_info) {
                ?>
                    <tr>
                        <td><?php echo $message_category_info['id'] ?></td>
                        <td><?php echo $message_category_info['description'] ?></td>
                        <td><a href="<?php echo base_url("./sms/update_message_category/".$message_category_info['id']);?>">Update</a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>