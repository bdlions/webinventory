<h3>Create Operator</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <?php echo form_open("operator/create_operator", array('id' => 'form_create_operator', 'class' => 'form-horizontal')); ?>
    <div class="row">
        <div class ="col-md-5 col-md-offset-2 margin-top-bottom">
            <div class ="row">
                <div class="col-md-4"></div>
                <div class="col-md-8"><?php echo $message; ?></div>
            </div>
            <div class="form-group">
                <label for="operator_prefix" class="col-md-6 control-label requiredField">
                    Operator Code *
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($operator_prefix+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="operator_name" class="col-md-6 control-label requiredField">
                    Operator Name *
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($operator_name+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="description" class="col-md-6 control-label requiredField">
                    Description
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($description+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="submit_create_operator" class="col-md-6 control-label requiredField">

                </label>
                <div class ="col-md-3 col-md-offset-3">
                    <?php echo form_input($submit_create_operator+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
