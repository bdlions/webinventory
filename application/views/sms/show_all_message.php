<h3>Message List</h3>
<div class ="row form-horizontal form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Message No</th>
                    <th>Message Category</th>
                    <th>Message Description</th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody id="tbody_product_list">
                <?php
                foreach ($message_list as $key => $message_info) {
                ?>
                    <tr>
                        <td><?php echo $message_info['id'] ?></td>
                        <td><?php echo $message_info['description'] ?></td>
                        <td><?php echo $message_info['message_description'] ?></td>
                        <td><a href="<?php echo base_url("./sms/update_message/".$message_info['id']);?>">Update</a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>