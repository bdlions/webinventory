<h3><?php echo $this->lang->line("shop_create_shop_update_header"); ?></h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <?php echo form_open("shop/update_shop/".$shop_info['id'], array('id' => 'form_update_shop', 'class' => 'form-horizontal')); ?>
    <div class="row">
        <div class ="col-md-5 col-md-offset-2 margin-top-bottom">
            <div class ="row">
                <div class="col-md-4"></div>
                <div class="col-md-8"><?php echo $message; ?></div>
            </div>
            <div class="form-group">
                <label for="phone" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("shop_create_shop_update_shop_no"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($shop_no+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="first_name" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("shop_create_shop_update_shop_name"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($shop_name+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="last_name" class="col-md-6 control-label requiredField">
                     <?php echo $this->lang->line("shop_create_shop_update_shop_phone"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($shop_phone+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">
                     <?php echo $this->lang->line("shop_create_shop_update_shop_address"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($shop_address+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">
                    Subscription Start
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($subscription_start+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">
                    Subscription End
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
