<h3><?php echo $this->lang->line("add_new_supplier_header"); ?></h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <?php echo form_open("user/create_supplier", array('id' => 'form_create_supplier', 'class' => 'form-horizontal')); ?>
    <div class="row">
        <div class ="col-md-5 col-md-offset-2 margin-top-bottom">
            <div class ="row">
                <div class="col-md-4"></div>
                <div class="col-md-8"><?php echo $message; ?></div>
            </div>
            <div class="form-group">
                <label for="first_name" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("add_new_supplier_first_name"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($first_name+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="last_name" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("add_new_supplier_last_name"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($last_name+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="phone" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("add_new_supplier_phone_no"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($phone+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("add_new_supplier_address"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($address+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="card_no" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("add_new_supplier_company"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($company+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <!--<div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">
                    Message Category
                </label>
                <div class ="col-md-6">
                    <?php //echo form_dropdown('message_category_list', $message_category_list+array('' => 'Select'), '', 'class=form-control'); ?>
                </div> 
            </div>-->
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">

                </label>
                <div class ="col-md-3 col-md-offset-3">
                    <?php echo form_input($submit_create_supplier+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>