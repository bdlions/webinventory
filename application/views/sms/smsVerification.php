<h3>SMS code varification</h3>
<br>

<div class ="row form-horizontal form-background top-bottom-padding">
    <?php echo $message; ?> 
    <div class="form-group">

        <h5 class="col-md-6 control-label requiredField">Enter the supplied code here:</h5>
        <?php
        if ($this->input->post("verification_code") && $message == "notok") {

            echo '<script language="javascript">';
            echo 'alert("Verification code mismatch")';
            echo '</script>';
        };
        ?>

        <div class ="col-md-6">
            <?php echo form_open("") ?>

            <input type="text" name="verification_code">
            <input type="submit" name="Verify" value="Verify">

            <?php echo form_close(); ?>
        </div> 
    </div>
</div>