<h3><?php echo $this->lang->line("sms_all_message_list");?></h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><?php echo $this->lang->line("sms_all_message_no");?></th>
                    <th><?php echo $this->lang->line("sms_all_message_category");?></th>
                    <th><?php echo $this->lang->line("sms_all_message_description");?></th>
                    <th> <?php echo $this->lang->line("sms_all_message_action");?> </th>
                </tr>
            </thead>
            <tbody id="tbody_product_list">
                <?php foreach ($message_list as $key => $message_info): ?>
                    <tr>
                        <td><?php echo $message_info['id'] ?></td>
                        <td><?php echo $message_info['description'] ?></td>
                        <td><?php echo $message_info['message_description'] ?></td>
                        <td><a href="<?php echo base_url("./sms/update_message/".$message_info['id']);?>"><?php echo $this->lang->line("sms_update_message_update");?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>