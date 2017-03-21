<h3>Create Product Size</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <?php echo form_open("product/create_product_size", array('id' => 'form_create_product_size', 'class' => 'form-horizontal')); ?>
    <div class="row">
        <div class ="col-md-5 col-md-offset-2 margin-top-bottom">
            <div class ="row form-group">
                <div class="col-md-4"></div>
                <div class="col-md-8"><?php echo $message; ?></div>
            </div>
            <div class="form-group">
                <label for="product_size" class="col-md-6 control-label requiredField">
                    Product Size
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($size_title+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField"></label>
                <div class ="col-md-3 col-md-offset-3">
                    <?php echo form_input($submit_create_product_size+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

