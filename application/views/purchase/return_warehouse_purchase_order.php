<script type="text/javascript">
        $(function() {
        
        var default_purchase_order_no = '<?php echo $shop_info['purchase_default_purchase_order_no'] ?>';
        if( default_purchase_order_no != "")
        {
            $('#purchase_order_no').val(default_purchase_order_no);
            $('#purchase_order_no').attr("disabled", true);
            return_warehouse_info();
        } 
        $("#purchase_order_no").change(function() {
            return_warehouse_info();
        });
        $("#return_warehouse_purchase_order_product_category1").change(function() {
            return_warehouse_info();
        });
        $("#return_warehouse_purchase_order_product_size").change(function() {
            return_warehouse_info();
        });
        
        var product_data = <?php echo json_encode($product_list_array) ?>;        
        set_product_list(product_data);
        $("#total_purchase_price").val('');

        $("#button_return_purchase_order").on("click", function() {
            //validation checking of purchase order
            //checking whether supplier is assigned or not
            if ($("#input_return_purchase_supplier_id").val().length === 0 || $("#input_return_purchase_supplier_id").val() < 0)
            {
                alert('Please assign correct Lot #');
                return;
            }
            //checking whether purchase order no is assigned or not
            if ($("#purchase_order_no").val().length === 0)
            {
                alert('Please assign Lot #');
                return;
            }
            //checking whether at least one product is selected or not
            var selected_product_counter = 0;
            $("input", "#tbody_selected_product_list").each(function() {
                if ($(this).attr("name") === "quantity")
                {
                    selected_product_counter++;
                }                
            });
            if (selected_product_counter <= 0)
            {
                alert('Please select at least one product.');
                return;
            }
            set_modal_confirmation_category_id(get_modal_confirmation_return_purchase_order_category_id());
            $('#myModal').modal('show');
        });
        $("#modal_button_confirm").on("click", function() {
            if( get_modal_confirmation_category_id() === get_modal_confirmation_return_purchase_order_category_id() )
            {
                var total_purchase_price = 0;
                var product_list = new Array();
                var product_list_counter = 0;
                $("tr", "#tbody_selected_product_list").each(function() {
                    var product_info = new Product();
                    $("input", $(this)).each(function() {
                        if ($(this).attr("name") === "name")
                        {
                            product_info.setName($(this).attr("value"));
                        }
                        if ($(this).attr("name") === "quantity")
                        {
                            product_info.setProductId($(this).attr("id"));
                            product_info.setQuantity($(this).attr("value"));
                            product_info.setPurchaseOrderNo($("#purchase_order_no").val());
                            product_info.setProductCategory1($("#return_warehouse_purchase_order_product_category1").val());
                            product_info.setProductSize($("#return_warehouse_purchase_order_product_size").val());
                        }
                        if ($(this).attr("name") === "price")
                        {
                            product_info.setUnitPrice($(this).attr("value"));
                        }
                        if ($(this).attr("name") === "product_price")
                        {
                            product_info.setSubTotal($(this).attr("value"));
                            total_purchase_price = +total_purchase_price + +$(this).attr("value");
                        }
                    });
                    product_list[product_list_counter++] = product_info;
                });
                if (total_purchase_price !== +$("#total_purchase_price").val())
                {
                    alert('Calculation error. Please try again.');
                    return;
                }
                var purchase_info = new Purchase();
                purchase_info.setOrderNo($("#purchase_order_no").val());
                purchase_info.setProductCategory1($("#return_warehouse_purchase_order_product_category1").val());
                purchase_info.setProductSize($("#return_warehouse_purchase_order_product_size").val());
                purchase_info.setSupplierId($("#input_return_purchase_supplier_id").val());
                purchase_info.setRemarks($("#purchase_remarks").val());
                purchase_info.setTotal($("#total_purchase_price").val());
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "purchase/return_warehouse_purchase",
                    data: {
                        product_list: product_list,
                        purchase_info: purchase_info,
                        current_due: $("#current_due").val(),
                        return_balance: $("#return_balance").val()
                    },
                    success: function(data) {
                        if (data['status'] === '0')
                        {
                            alert(data['message']);
                        }
                        else if (data['status'] === '1')
                        {
                            alert('Trascaction is executed successfully.');
                            $("#purchase_order_no").val('');
                            $("#tbody_selected_product_list").html('');
                            $("#input_return_purchase_supplier_id").val('');
                            $("#input_return_purchase_supplier").val('');
                            $("#input_return_purchase_phone").val('');
                            $("#input_return_purchase_company").val('');
                            $('#input_return_purchase_product').attr('type', 'hidden');
                            $("#purchase_order_no").val('');
                            $("#purchase_remarks").val('');
                            $("#total_purchase_price").val('');
                            $("#previous_due").val('');
                            $("#current_due").val('');
                            $("#return_balance").val('');
                        }
                    }
                });
            }
            $('#myModal').modal('hide');
        });
        
        $("#tbody_selected_product_list").on("change", "input", function() {
            var product_id = '';
            var product_quantity = 1;
            var product_price = 100;
            $("input", $(this).parent().parent()).each(function() {
                if ($(this).attr("name") === "quantity")
                {
                    if ($(this).attr("id") > 0)
                    {
                        product_id = $(this).attr("id");
                        $(this).attr('value', $(this).val());
                        product_quantity = $(this).val();
                    }
                }
                if ($(this).attr("name") === "price")
                {
                    if ($(this).attr("id") > 0)
                    {
                        product_id = $(this).attr("id");
                        $(this).attr('value', $(this).val());
                        product_price = $(this).val();
                    }
                }
                if ($(this).attr("name") === "product_price")
                {
                    $(this).attr('value', product_quantity * product_price);
                    $(this).val(product_quantity * product_price);
                }
            });
            var total_purchase_price = 0;
            $("input", "#tbody_selected_product_list").each(function() {
                if ($(this).attr("name") === "product_price")
                {
                    total_purchase_price = +total_purchase_price + +$(this).val();
                }
            });
            $("#total_purchase_price").val(total_purchase_price);
            //$("#return_balance").val(total_purchase_price);
            var current_due = +$("#previous_due").val() - +$("#total_purchase_price").val();
            if(current_due >=0 )
            {
                $("#current_due").val(current_due);
                $("#return_balance").val('0');
            }
            else
            {
                $("#current_due").val('0');
                $("#return_balance").val(-current_due);
            }
        });
        $('.dropdown-toggle').dropdown();
        $(".dropdown-menu").on("click", function(e) {
            e.stopPropagation();
        });
        $(".btn-default").on("click", function(e) {
            $('#myModal').modal('hide');
            e.stopPropagation();
        });
    });
   
    function append_selected_product(prod_info)
    {
        prod_info['unit_price'] = '';
        var is_product_previously_selected = false;
        $("input", "#tbody_selected_product_list").each(function() {
            if ($(this).attr("name") === "quantity")
            {
                if ($(this).attr("id") === prod_info['id'])
                {
                    is_product_previously_selected = true;
                }
            }
        });
        if (is_product_previously_selected === true)
        {
            alert('The product is already selected. Please update product quantity.');
            return;
        }
        var purchased_product_list = get_purchased_product_list();
        for(var counter = 0; counter < purchased_product_list.length ; counter++)
        {
            var purchased_product_info = purchased_product_list[counter];
            if(purchased_product_info['product_id']=== prod_info['id'])
            {
                prod_info['unit_price'] = purchased_product_info['unit_price'];
                prod_info['readonly'] = 'true';
            }
        }
        $("#tbody_selected_product_list").html($("#tbody_selected_product_list").html()+tmpl("tmpl_selected_product_info",  prod_info));
        $('.purchase_order_number_td').hide();
        color_setter();
        var total_purchase_price = 0;
        $("input", "#tbody_selected_product_list").each(function() {
            if ($(this).attr("name") === "product_price")
            {
                total_purchase_price = +total_purchase_price + +$(this).val();
            }
        });
        $("#total_purchase_price").val(total_purchase_price);        
    }

    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }

    function return_warehouse_info(){
        $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "purchase/get_warehouse_purchase_info_from_lot_no",
                data: {
                    lot_no: $("#purchase_order_no").val(),
                    product_category1: $("#return_warehouse_purchase_order_product_category1").val(),
                    product_size: $("#return_warehouse_purchase_order_product_size").val()
                },
                success: function(data) {
                    var supplier_info = data['supplier_info'];
                    var purchased_product_list = data['purchased_product_list'];
                    var supplier_due = data['supplier_due'];
                    set_purchased_product_list(purchased_product_list);
                    if(supplier_info.supplier_id)
                    {
                        $("#tbody_purchased_product_list").html(tmpl("tmpl_purchased_product_list",  data['purchased_product_list']));
                        $("#input_return_purchase_supplier_id").val(supplier_info.supplier_id);
                        $("#input_return_purchase_supplier").val(supplier_info.first_name+supplier_info.last_name);
                        $("#input_return_purchase_phone").val(supplier_info.phone);
                        $("#input_return_purchase_company").val(supplier_info.company);
                        $('#input_return_purchase_product').attr('type', 'text');
                        $("#total_purchase_price").val('');
                        $("#previous_due").val(supplier_due);
                        $("#current_due").val(supplier_due);
                        $("#return_balance").val('');
                    }
                    else
                    {
                        $("#input_return_purchase_supplier_id").val('');
                        $("#input_return_purchase_supplier").val('');
                        $("#input_return_purchase_phone").val('');
                        $("#input_return_purchase_company").val('');
                        $('#input_return_purchase_product').attr('type', 'hidden');
                        $("#total_purchase_price").val('');
                        $("#previous_due").val('');
                        $("#current_due").val('');
                        $("#return_balance").val('');
                    }
                }
            });
    }

</script>

<h3>Return purchase</h3>
<div class ="top-bottom-padding form-background">
    <div class="row">
        <div class="col-md-2">        
        </div>
        <div class ="col-md-8 form-horizontal">
            <div class="row">
                <div class ="col-md-7 form-horizontal margin-top-bottom">
                    <div class="form-group">
                        <label for="input_return_purchase_supplier" class="col-md-3 control-label requiredField">
                            Supplier Name
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'input_return_purchase_supplier_id', 'id' => 'input_return_purchase_supplier_id', 'type'=>'hidden', 'class' => 'form-control')); ?>
                            <?php echo form_input(array('name' => 'input_return_purchase_supplier', 'id' => 'input_return_purchase_supplier', 'readonly'=>'true', 'class' => 'form-control')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="input_return_purchase_phone" class="col-md-3 control-label requiredField">
                            Phone No
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'input_return_purchase_phone', 'id' => 'input_return_purchase_phone', 'readonly'=>'true', 'class' => 'form-control')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="input_return_purchase_company" class="col-md-3 control-label requiredField">
                            Company
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'input_return_purchase_company', 'id' => 'input_return_purchase_company', 'readonly'=>'true', 'class' => 'form-control')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="input_return_purchase_product" class="col-md-3 control-label requiredField">
                            Product
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('type'=>'hidden', 'name' => 'input_return_purchase_product', 'id' => 'input_return_purchase_product', 'class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#common_modal_select_return_product')); ?>
                        </div> 
                    </div>
                </div>
                <div class ="col-md-5 form-horizontal margin-top-bottom">
                    <div class="form-group">
                        <label for="purchase_order_no" class="col-md-4 control-label requiredField">
                            Lot No 
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'purchase_order_no', 'id' => 'purchase_order_no', 'class' => 'form-control')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="return_warehouse_purchase_order_product_category1" class="col-md-4 control-label requiredField">
                            Sub Lot No
                        </label>
                        <div class ="col-md-8">
                            <select name="return_warehouse_purchase_order_product_category1" id="return_warehouse_purchase_order_product_category1" class="form-control">
                                <?php foreach($product_category1_list as $product_category1_info){?>
                                <option value="<?php echo $product_category1_info['title'];?>"><?php echo $product_category1_info['title'];?></option>
                                <?php } ?>
                            </select>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="return_warehouse_purchase_order_product_size" class="col-md-4 control-label requiredField">
                            Size
                        </label>
                        <div class ="col-md-8">
                            <select name="return_warehouse_purchase_order_product_size" id="return_warehouse_purchase_order_product_size" class="form-control">
                                <?php foreach($product_size_list as $product_size_info){?>
                                <option value="<?php echo $product_size_info['title'];?>"><?php echo $product_size_info['title'];?></option>
                                <?php } ?>
                            </select>
                        </div> 
                    </div>
                </div>
            </div>
            <?php $this->load->view("common/order_process_products"); ?>
            <div class="row margin-top-bottom">
                <div class ="col-md-12 form-horizontal">
                    <div class="form-group">
                        <label for="remarks" class="col-md-7 control-label requiredField">
                            Remarks
                        </label>
                        <div class ="col-md-3">
                            <?php echo form_textarea(array('name' => 'remarks', 'id' => 'remarks', 'class' => 'form-control', 'rows' => '2', 'cols' => '4')); ?>

                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="total_purchase_price" class="col-md-7 control-label requiredField">
                            Total
                        </label>
                        <div class ="col-md-3">
                            <?php echo form_input(array('name' => 'total_purchase_price', 'id' => 'total_purchase_price', 'class' => 'form-control', 'readonly' => 'readonly')); ?>
                        </div> 
                    </div>     
                    <div class="form-group">
                        <label for="previous_due" class="col-md-7 control-label requiredField">
                            Previous Due
                        </label>
                        <div class ="col-md-3">
                            <?php echo form_input(array('name' => 'previous_due', 'id' => 'previous_due', 'class' => 'form-control' , 'readonly' => 'readonly')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="current_due" class="col-md-7 control-label requiredField">
                            Current Due
                        </label>
                        <div class ="col-md-3">
                            <?php echo form_input(array('name' => 'current_due', 'id' => 'current_due', 'class' => 'form-control', 'readonly' => 'readonly')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="return_balance" class="col-md-7 control-label requiredField">
                            Return balance
                        </label>
                        <div class ="col-md-3">
                            <?php echo form_input(array('name' => 'return_balance', 'id' => 'return_balance', 'class' => 'form-control', 'readonly' => 'readonly')); ?>
                        </div> 
                    </div>
                    <div class="form-group" id="div_button_purchase_order">
                        <label for="button_return_purchase_order" class="col-md-2 control-label requiredField">

                        </label>
                        <div class ="col-md-3 col-md-offset-5">
                            <?php echo form_button(array('name' => 'button_return_purchase_order', 'id' => 'button_return_purchase_order', 'content' => 'Update', 'class' => 'form-control btn-success')); ?>
                        </div> 
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-2">        
        </div>
    </div>    
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="modal-title" id="myModalLabel">Confirm Message</h2>
      </div>
      <div class="modal-body">
       Do You want to proceed?
      </div>
      <div class="modal-footer">          
        <button type="button" id ="modal_button_confirm" class="btn btn-primary">Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $this->load->view("purchase/common_modal_select_return_product");?>

