<h3>SMS Status</h3>
<div class ="form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Shop Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="tbody_product_list">
                <?php
                foreach ($sms_status_array as $key => $sms_status) {
                ?>
                    <tr>
                        <td><?php echo $sms_status['name'] ?></td>
                        <td><?php echo $sms_status['status'] ?></td>                        
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>