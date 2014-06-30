<h3><?php echo $this->lang->line("sales_add_new_customer_header"); ?></h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="row">
        <?php echo form_open("user/create_customer", array('id' => 'form_create_customer', 'class' => 'form-horizontal')); ?>
        <div class ="col-md-5 col-md-offset-2">
            <div class ="row">
                <div class="col-md-4"></div>
                <div class="col-md-8"><?php echo $message; ?></div>
            </div>
            <div class="form-group">
                <label for="first_name" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("sales_add_new_customer_first_name"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($first_name+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="last_name" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("sales_add_new_customer_last_name"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($last_name+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="phone" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("sales_add_new_customer_phone_no"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($phone+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">
                   <?php echo $this->lang->line("sales_add_new_customer_address"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($address+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="card_no" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("sales_add_new_customer_card_no"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($card_no+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("sales_add_new_customer_institution"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_dropdown('institution_list', $institution_list+array('' => 'Select'), '','class=form-control'); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("sales_add_new_customer_profession"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_dropdown('profession_list', $profession_list+array('' => 'Select'), '', 'class=form-control'); ?>
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
                    <?php echo form_input($submit_create_customer+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>    
</div>