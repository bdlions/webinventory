<h3>Add New Profession</h3>
<div class ="row form-horizontal form-background top-bottom-padding">
    <?php echo form_open("user/create_profession", array('id' => 'form_create_profession', 'class' => 'form-horizontal')); ?>
    <div class ="col-md-5 col-md-offset-2">
        <div class ="row">
            <div class="col-md-4"></div>
            <div class="col-md-8"><?php echo $message; ?></div>
        </div>
        <div class="form-group">
            <label for="first_name" class="col-md-6 control-label requiredField">
                Profession Name
            </label>
            <div class ="col-md-6">
                <?php echo form_input($profession_name+array('class'=>'form-control')); ?>
            </div> 
        </div>
        <div class="form-group">
            <label for="address" class="col-md-6 control-label requiredField">

            </label>
            <div class ="col-md-3 col-md-offset-3">
                <?php echo form_input($submit_create_profession+array('class'=>'form-control btn-success')); ?>
            </div> 
        </div>
    </div>
    <?php echo form_close(); ?>
</div>