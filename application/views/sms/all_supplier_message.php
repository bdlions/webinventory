<h3>Supplier Message List</h3>
<div class ="row form-horizontal form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Message No</th>
                    <th>Supplier Name</th>
                    <th>Message Description</th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody id="tbody_product_list">
                <?php
                $i = 1;
                foreach ($message_list as $key => $message_info) {
                ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $message_info['first_name']." " . $message_info['last_name']; ?></td>
                        <td><?php echo html_entity_decode(html_entity_decode($message_info['message'])) ?></td>
                        <td><a href="<?php echo base_url("./sms/update_supplier_message/".$message_info['id']);?>">Update</a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>