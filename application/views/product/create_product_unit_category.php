<h3>Product Unit Category</h3>
<div class ="row form-horizontal form-background top-bottom-padding">
    <?php echo form_open("product/create_product_unit_category", array('id' => 'form_create_product_unit_categoryt', 'class' => 'form-horizontal')); ?>
    <div class ="col-md-5 col-md-offset-2">
        <div class ="row">
            <div class="col-md-4"></div>
            <div class="col-md-8" style="color:blue"><?php echo $message; ?></div>
        </div>
        <div class="form-group">
            <label for="first_name" class="col-md-6 control-label requiredField">
                Product Unit Category Name
            </label>
            <div class ="col-md-6">
                <?php echo form_input($unit_name+array('class'=>'form-control')); ?>
            </div> 
        </div>
        <div class="form-group">
            <label for="address" class="col-md-6 control-label requiredField">

            </label>
            <div class ="col-md-3 col-md-offset-3">
                <?php echo form_input($submit_create_unit+array('class'=>'form-control btn-success')); ?>
            </div> 
        </div>
    </div>
    <?php echo form_close(); ?>
</div>