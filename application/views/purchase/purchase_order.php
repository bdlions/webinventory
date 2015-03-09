<script type="text/javascript">
  
//    var stock_purc_prod_list;
    var ware_purc_prod_list;
    
    $(function() {
        var default_purchase_order_no = '<?php echo $shop_info['purchase_default_purchase_order_no'] ?>';
        if( default_purchase_order_no != "")
        {
            purchase_default_info(default_purchase_order_no);
            purchase_raise_info();
        }
        else
        {
            purchase_info();
        }  
        $("#purchase_order_no").change(function() {
            purchase_raise_info();
        });
        
        var product_data = <?php echo json_encode($product_list_array) ?>;        
        set_product_list(product_data);
        $("#total_purchase_price").val('');
        
        $("#button_purchase_order").on("click", function() {
            //validation checking of purchase order
            //checking whether supplier is assigned or not
            if ($("#input_purchase_supplier_id").val().length === 0 || $("#input_purchase_supplier_id").val() < 0)
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
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "purchase/add_purchase",
                    data: {
                        product_list: product_list,
                    },
                    success: function(data) {
                        if (data['status'] == '0')
                        {
                            alert(data['message']);
                        }
                        else if (data['status'] == '1')
                        {
                            alert('Trascaction is executed successfully.');
                            $("#purchase_order_no").val('');
                            $("#tbody_selected_product_list").html('');
                            $("#input_purchase_supplier_id").val('');
                            $("#input_purchase_supplier").val('');
                            $("#input_purchase_phone").val('');
                            $("#input_purchase_company").val('');
                            $('#input_purchase_product').attr('type', 'hidden');
                            $("#purchase_order_no").val('');
                            $("#purchase_remarks").val('');
                            $("#total_purchase_price").val('');
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
        $.each(stock_purc_prod_list, function( index, stocked_product ) {
            if( stocked_product['product_id'] == prod_info['id'] )
            {
                prod_info['unit_price'] = stocked_product['unit_price']; 
                prod_info['readonly'] = 'true';
            }
        });
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
     function purchase_raise_info(){
    $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "purchase/get_warehouse_purchase_info_from_lot_no",
                data: {
                    lot_no: $("#purchase_order_no").val()
                },
                success: function(data) {
                    var supplier_info = data['supplier_info'];
                    var purchased_product_list = data['purchased_product_list'];
                    var supplier_due = data['supplier_due'];
                    set_purchased_product_list(purchased_product_list);
                    stock_purc_prod_list = data['stock_purchased_product_list'];
                    if(supplier_info.supplier_id)
                    {
//                        $("#tbody_purchased_product_list").html(tmpl("tmpl_purchased_product_list",  data['purchased_product_list']));
                        $("#input_purchase_supplier_id").val(supplier_info.supplier_id);
                        $("#input_purchase_supplier").val(supplier_info.first_name+supplier_info.last_name);
                        $("#input_purchase_phone").val(supplier_info.phone);
                        $("#input_purchase_company").val(supplier_info.company);
                        $('#input_purchase_product').attr('type', 'text');
                        $("#total_purchase_price").val('');
                    }
                    else
                    {
                        $("#input_purchase_supplier_id").val('');
                        $("#input_purchase_supplier").val('');
                        $("#input_purchase_phone").val('');
                        $("#input_purchase_company").val('');
                        $('#input_purchase_product').attr('type', 'hidden');
                        $("#total_purchase_price").val('');
                    }
                }
            });   
   }
</script>

<h3> Raise Purchase Order</h3>
<div class ="top-bottom-padding form-background">
    <div class="row">
        <div class="col-md-2">        
        </div>
        <div class ="col-md-8 form-horizontal">
            <div class="row">
                <div class ="col-md-7 form-horizontal margin-top-bottom">
                    <div class="form-group">
                        <label for="input_purchase_supplier" class="col-md-3 control-label requiredField">
                            Supplier Name
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'input_purchase_supplier_id', 'id' => 'input_purchase_supplier_id', 'type'=>'hidden', 'class' => 'form-control')); ?>
                            <?php echo form_input(array('name' => 'input_purchase_supplier', 'id' => 'input_purchase_supplier', 'readonly'=>'true', 'class' => 'form-control')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="input_purchase_phone" class="col-md-3 control-label requiredField">
                            Phone No
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'input_purchase_phone', 'id' => 'input_purchase_phone', 'readonly'=>'true', 'class' => 'form-control')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="input_purchase_company" class="col-md-3 control-label requiredField">
                            Company
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'input_purchase_company', 'id' => 'input_purchase_company', 'readonly'=>'true', 'class' => 'form-control')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="input_purchase_product" class="col-md-3 control-label requiredField">
                            Product
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('type'=>'hidden', 'name' => 'input_purchase_product', 'id' => 'input_purchase_product', 'class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#common_modal_select_product')); ?>
                        </div> 
                    </div>
                </div>
            <?php $this->load->view("purchase/common_purchase_lock"); ?>
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
                        <label for="button_purchase_order" class="col-md-2 control-label requiredField">

                        </label>
                        <div class ="col-md-3 col-md-offset-5">
                            <?php echo form_button(array('name' => 'button_purchase_order', 'id' => 'button_purchase_order', 'content' => 'Update', 'class' => 'form-control btn-success')); ?>
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
<?php $this->load->view("common/modal_select_product_order");?>

