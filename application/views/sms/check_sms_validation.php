<h3>SMS code varification</h3>
<br>

<div class ="row form-horizontal form-background top-bottom-padding">
  <?php echo $message; ?> 
    <div class="form-group">
        <h5 class="col-md-6 control-label requiredField">Enter the supplied code here:</h5>

        <div class ="col-md-6">
            <?php echo form_open("user/account_validation_sms") ?>
           
            <input type="text" name="code">
            <input type="submit" name="submit_sms_code" id="submit_sms_code" value="Submit">

            <?php echo form_close(); ?>
        </div> 
    </div>
</div>

