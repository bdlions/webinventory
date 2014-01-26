<div class ="row">
    <div class ="col-md-12">
        <div class ="row">
            <div class ="col-md-12 form-horizontal form-background">
                <?php echo form_open("product/create_product", array('id' => 'form_create_product', 'class' => 'form-horizontal')); ?>
                <div class="row">
                    <div class ="col-md-5 col-md-offset-2 margin-top-bottom">
                        <div class ="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-8"><?php echo $message; ?></div>
                        </div>
                        <?php echo form_fieldset('General Information'); ?>
                        <div class="form-group">
                            <label for="phone" class="col-md-6 control-label requiredField">
                                Product Name
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($name+array('class'=>'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="first_name" class="col-md-6 control-label requiredField">
                                Product Size
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($size+array('class'=>'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="col-md-6 control-label requiredField">
                                Product Weight
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($weight+array('class'=>'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-6 control-label requiredField">
                                Product Warranty
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($warranty+array('class'=>'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-6 control-label requiredField">
                                Product Quality
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($quality+array('class'=>'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-6 control-label requiredField">
                                Brand Name
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($brand_name+array('class'=>'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-6 control-label requiredField">
                                Unit Price
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($unit_price+array('class'=>'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-6 control-label requiredField">

                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($submit_create_product+array('class'=>'form-control btn-success')); ?>
                            </div> 
                        </div>
                        <?php echo form_fieldset_close(); ?>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>    
</div>
