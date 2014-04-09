<h3>SMS code varification</h3>
<br>

<div class ="row form-horizontal form-background top-bottom-padding">
    <?php echo $message; ?> 
    <div class="form-group">
        <div class ="col-md-4 col-md-offset-4">
           <?php echo form_open("user/account_validation_sms") ?>
           <div class="form-group">
                <label for="password" class="col-md-6 control-label requiredField">
                    Enter the supplied code here
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($code + array('class' => 'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="password" class="col-md-6 control-label requiredField">                    
                </label>
                <div class ="col-md-4 pull-right">
                    <?php echo form_input($submit_sms_code + array('class' => 'form-control btn-success')); ?>
                </div> 
            </div>
            <?php echo form_close(); ?>
        </div> 
    </div>
</div>