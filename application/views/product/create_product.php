<h3>Create Product</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <?php echo form_open("product/create_product", array('id' => 'form_create_product', 'class' => 'form-horizontal')); ?>
    <div class="row">
        <div class ="col-md-5 col-md-offset-2 margin-top-bottom">
            <div class ="row">
                <div class="col-md-4"></div>
                <div class="col-md-8"><?php echo $message; ?></div>
            </div>
            <div class="form-group">
                <label for="phone" class="col-md-6 control-label requiredField">
                     <?php echo $this->lang->line("manage_stock_create_product_unit_category_product_name"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($name+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="first_name" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("manage_stock_create_product_unit_category_product_size"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($size+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="last_name" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("manage_stock_create_product_unit_category_product_weight"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($weight+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("manage_stock_create_product_unit_category_product_Warranty"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($warranty+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("manage_stock_create_product_unit_category_product_quality"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($quality+array('class'=>'form-control')); ?>
                </div> 
            </div>
            
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("manage_stock_create_product_unit_category_product_unit_category"); ?>
                </label>
                <div class ="col-md-6" id="unit_dropdown">
                    <?php echo form_dropdown('product_unit_category_list', array('' => 'Select')+$product_unit_category_list, '', 'class=form-control id=dropdown'); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("manage_stock_create_product_unit_category_product_new_unit"); ?>
                </label>
                <div class ="col-md-3">
                    <input type="text" class="form-control" id="unit_name"/>
                </div>
                <div class ="col-md-3">
                    <button type="button" name="create" class="form-control btn-success" id="unit_create">
                        <?php echo $this->lang->line("manage_stock_create_product_unit_category_create"); ?>
                    </button>
                </div>
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("manage_stock_create_product_unit_category_product_brand_name"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($brand_name+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("manage_stock_create_product_unit_category_product_unit_price"); ?>
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