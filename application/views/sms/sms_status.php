<h3><?php echo $this->lang->line("sms_sms_status_SMS_status");?></h3>
<div class ="form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><?php echo $this->lang->line("sms_sms_status_shop_name");?></th>
                    <th><?php echo $this->lang->line("sms_sms_status_status");?></th>
                </tr>
            </thead>
            <tbody id="tbody_product_list">
                <?php
                foreach ($sms_status_array as $key => $sms_status) : ?>
                    <tr>
                        <td><?php echo $sms_status['name'] ?></td>
                        <td><?php echo $sms_status['status'] ?></td>                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>