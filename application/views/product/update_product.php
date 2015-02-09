<h3>Update Product</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <?php echo form_open("product/update_product/".$product_info['id'], array('id' => 'form_update_product', 'class' => 'form-horizontal')); ?>
    <div class="row">
        <div class ="col-md-5 col-md-offset-2 margin-top-bottom">
            <div class ="row">
                <div class="col-md-4"></div>
                <div class="col-md-8"><?php echo $message; ?></div>
            </div>
            <div class="form-group">
                <label for="product_name" class="col-md-6 control-label requiredField">
                    Product Name
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($name+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="serial_no" class="col-md-6 control-label requiredField">
                    Serial No
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($serial_no+array('class'=>'form-control')); ?>
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
                     <?php if($selected_unit_category != NULL) : ?>
                     <?php echo form_dropdown('product_unit_category_list', $product_unit_category_list, $selected_unit_category,'class=form-control id=dropdown'); ?>
                     <?php else : ?>
                     <?php echo form_dropdown('product_unit_category_list', array('' => 'Select')+$product_unit_category_list, '', 'class=form-control id=dropdown'); ?>
                     <?php endif; ?>
                 </div> 
             </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">
                    New Unit
                </label>
                <div class ="col-md-3">
                    <input type="text" class="form-control" id="unit_name"/>
                </div>
                <div class ="col-md-3">
                    <button type="button" name="create" class="form-control btn-success" id="unit_create">Create</button>
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
                    <?php echo form_input($submit_update_product+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript">
    $(function() {
        $("#unit_create").on("click", function() {
            if ($("#unit_name").val().length == 0)
            {
                alert("Unit name is required.");
                return;
            }
            
            var unit_name = $("#unit_name").val();
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "product/create_product_unit",
                data: { unit_name: unit_name },
                success: function(data) {
                    alert(data.message);
                    if (data['status'] === 1)
                    {
                        $("#dropdown").append("<option value='"+data['product_category_info'].id+"'>"+data['product_category_info'].description+"</option>");
                    }
                    
                }
            });
            //alert('Hello');
        });
    });
    
</script>