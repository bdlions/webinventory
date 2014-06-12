<h3>Product Information</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="row">
        <div class ="col-md-5 col-md-offset-2">
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
        </div>
    </div>
</div>