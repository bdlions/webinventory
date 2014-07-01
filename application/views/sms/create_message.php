<h3><?php echo $this->lang->line("sms_create_message_heading");?></h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="row">
        <?php echo form_open("sms/create_message", array('id' => 'form_create_message', 'class' => 'form-horizontal')); ?>
        <div class ="col-md-5 col-md-offset-2">
            <div class ="row">
                <div class="col-md-4"></div>
                <div class="col-md-8"><?php echo $message; ?></div>
            </div>

            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("sms_create_message_category");?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_dropdown('message_category_list', $message_category_list+array('' => 'Select'), '', 'class=form-control'); ?>
                </div> 
            </div>

            <div class="form-group">
                <label for="message_categoty_name" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("sms_create_message_name");?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_textarea($message_description+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">

                </label>
                <div class ="col-md-3 col-md-offset-3">
                    <?php echo form_input($submit_create_message+array('class'=>'form-control btn-success')); ?>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>    
</div>