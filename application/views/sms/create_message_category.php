<h3>Add New Message Category</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="row">
        <?php echo form_open("sms/create_message_category", array('id' => 'form_create_message_category', 'class' => 'form-horizontal')); ?>
        <div class ="col-md-5 col-md-offset-2">
            <div class ="row">
                <div class="col-md-4"></div>
                <div class="col-md-8"><?php echo $message; ?></div>
            </div>
            <div class="form-group">
                <label for="message_categoty_name" class="col-md-6 control-label requiredField">
                    Message Category Name
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($message_category_name+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">

                </label>
                <div class ="col-md-3 col-md-offset-3">
                    <?php echo form_input($submit_create_categoty_message+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>    
</div>