<h3>Delete Sale</h3>
<div class="form-horizontal top-bottom-padding form-background">
    <div class="row">
        <?php echo form_open("sale/delete_sale", array('id' => 'form_delete_sale', 'class' => 'form-horizontal')); ?>
        <div class ="col-md-5 col-md-offset-2 margin-top-bottom">
            <div class="form-group">
                <label for="message" class="col-md-3 control-label requiredField">

                </label>
                <div class ="col-md-8">
                    <?php echo $message; ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="input_add_sale_phone" class="col-md-4 control-label requiredField">
                    Sale Order No
                </label>
                <div class ="col-md-7">
                    <?php echo form_input($sale_order_no+array('class' => 'form-control')); ?>
                </div> 
            </div>
              <div class="form-group">
                        <label for="sale_sub_order_no" class="col-md-4 control-label requiredField">
                            Sub Lot No
                        </label>
                        <div class ="col-md-7">
                            <select name="sale_sub_order_no" id="sale_sub_order_no" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="sale_order_product_size" class="col-md-4 control-label requiredField">
                            Size
                        </label>
                        <div class ="col-md-7">
                            <select name="sale_order_product_size" id="sale_order_product_size" class="form-control">
                                <option value="lg">lg</option>
                                <option value="xl">xl</option>
                                <option value="sm">sm</option>
                            </select>
                        </div> 
                    </div>
            <div class="form-group">
                <label for="submit_delete_sale" class="col-md-7 control-label requiredField">

                </label>
                <div class ="col-md-4">
                     <?php echo form_input($submit_delete_sale+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
        </div>        
        <?php echo form_close(); ?>
    </div>    
</div>

