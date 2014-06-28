
<h3>Update Shop</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <?php echo form_open("shop/subscription_update_shop/".$shop_id, array('class' => 'form-horizontal')); ?>
    <div class="row">
        <div class ="col-md-5 col-md-offset-2 margin-top-bottom">
            <div class ="row">
                <div class="col-md-4"></div>
                <div class="col-md-8" style="color: red;"><?php echo $message; ?></div>
            </div>
            <div class="form-group">
                <label for="start" class="col-md-6 control-label requiredField">
                    Starts Date
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($subscription_start+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="end" class="col-md-6 control-label requiredField">
                    End Date
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($subscription_end+array('class'=>'form-control')); ?>
                </div> 
            </div>

            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">

                </label>
                <div class ="col-md-3 col-md-offset-3">
                    <?php echo form_input($submit_update_shop+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<script type="text/javascript">
    $(function() {

        $('#subscription_start').datepicker({
            format: 'dd-mm-yyyy',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#subscription_start').text($('#subscription_start').data('date'));
            $('#subscription_start').datepicker('hide');
        });
        
        $('#subscription_end').datepicker({
            format: 'dd-mm-yyyy',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#subscription_end').text($('#subscription_end').data('date'));
            $('#subscription_end').datepicker('hide');
        });
    });
</script>