<h3><?php echo $this->lang->line("sms_all_message_category_list");?></h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><?php echo $this->lang->line("sms_all_message_category_no");?></th>
                    <th><?php echo $this->lang->line("sms_all_message_category_name");?></th>
                    <th> <?php echo $this->lang->line("sms_all_message_category_action");?> </th>
                </tr>
            </thead>
            <tbody id="tbody_product_list">
                <?php foreach ($message_category_list as $key => $message_category_info): ?>
                    <tr>
                        <td><?php echo $message_category_info['id'] ?></td>
                        <td><?php echo $message_category_info['description'] ?></td>
                        <td><a href="<?php echo base_url("./sms/update_message_category/".$message_category_info['id']);?>">Update</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>