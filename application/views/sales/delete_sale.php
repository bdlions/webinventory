<h3>Delete Sale</h3>
<div class="row col-md-4 top-bottom-padding form-background">
    <?php echo form_open("sale/delete_sale", array('id' => 'form_delete_sale', 'class' => 'form-horizontal')); ?>
    <div class="form-group">
        <label for="message" class="col-md-3 control-label requiredField">
            
        </label>
        <div class ="col-md-8">
            <?php echo $message; ?>
        </div> 
    </div>
    <div class="form-group">
        <label for="input_add_sale_phone" class="col-md-3 control-label requiredField">
            Sale Id
        </label>
        <div class ="col-md-8">
            <?php echo form_input($sale_order_no+array('class' => 'form-control')); ?>
        </div> 
    </div>
    <div class="form-group">
        <label for="submit_delete_sale" class="col-md-3 control-label requiredField">
            
        </label>
        <div class ="col-md-8">
             <?php echo form_input($submit_delete_sale+array('class'=>'form-control btn-success')); ?>
        </div> 
    </div>
    <?php echo form_close(); ?>
</div>

