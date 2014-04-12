<h3>Create Product</h3>
<div class ="row form-horizontal form-background top-bottom-padding">
    <?php echo form_open("product/create_product", array('id' => 'form_create_product', 'class' => 'form-horizontal')); ?>
    <div class="row">
        <div class ="col-md-5 col-md-offset-2 margin-top-bottom">
            <div class ="row">
                <div class="col-md-4"></div>
                <div class="col-md-8"><?php echo $message; ?></div>
            </div>
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
                    Product Unit Category
                </label>
                <div class ="col-md-6">
                    <?php echo form_dropdown('product_unit_category_list', $product_unit_category_list+array('' => 'Select'), '', 'class=form-control'); ?>
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
                <div class ="col-md-3 col-md-offset-3">
                    <?php echo form_input($submit_create_product+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
