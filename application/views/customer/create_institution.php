<h3>Add New Institution</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="row">
        <?php echo form_open("customer/create_institution", array('id' => 'form_create_institution', 'class' => 'form-horizontal')); ?>
        <div class ="col-md-5 col-md-offset-2">
            <div class ="row">
                <div class="col-md-4"></div>
                <div class="col-md-8"><?php echo $message; ?></div>
            </div>
            <div class="form-group">
                <label for="first_name" class="col-md-6 control-label requiredField">
                    Institution Name
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($institution_name+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">

                </label>
                <div class ="col-md-3 col-md-offset-3">
                    <?php echo form_input($submit_create_institution+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>    
</div>