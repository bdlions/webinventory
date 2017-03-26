<script type="text/javascript">
    $(document).ready(function() {
        $("#total_return_sale_price").val('');
        $("#previous_due").val('');
        $("#current_due").val('');
        $("#return_balance").val('');
    });
</script>
<script>
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
        var product_list = get_purchased_product_list();
        for(var counter = 0; counter < product_list.length ; counter++)
        {
            var product_info = product_list[counter];
            if(product_info['product_id']=== prod_info['product_id'])
            {
                prod_info['unit_price'] = product_info['unit_price'];
                prod_info['readonly'] = 'true';
            }
        }
        $("#tbody_selected_product_list").html($("#tbody_selected_product_list").html()+tmpl("tmpl_selected_product_info",  prod_info));
        var total_return_sale_price = 0;
        $("input", "#tbody_selected_product_list").each(function() {
            if ($(this).attr("name") === "product_sale_price")
            {
                total_return_sale_price = +total_return_sale_price + +$(this).val();
            }
        });
        $("#total_return_sale_price").val(total_return_sale_price);
    }

    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }
    
    function process_sale_order_info()
    {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "sale/get_sale_info_from_sale_order_no",
            data: {
                sale_order_no: $("#sale_order_no").val()
            },
            success: function(data) {
                var customer_info = data['customer_info'];
                var customer_due = data['customer_due'];
                if(customer_info.customer_id)
                {
                    set_purchased_product_list(data['sale_product_list']);
                    $("#tbody_sold_product_list").html(tmpl("tmpl_sold_product_list",  data['sale_product_list']));
                    $("#input_return_sale_customer_id").val(customer_info.customer_id);
                    $("#input_return_sale_customer").val(customer_info.first_name+' '+customer_info.last_name);
                    $("#input_return_sale_phone").val(customer_info.phone);
                    $("#input_return_sale_card_no").val(customer_info.card_no);
                    $('#input_return_sale_product').attr('type', 'text');
                    $("#total_return_sale_price").val('');
                    $("#previous_due").val(customer_due);
                    $("#current_due").val(customer_due);
                    $("#return_balance").val('');
                    $("#return_sale_order_purchase_order_no").val(data['purchase_order_no']);
                    $("#return_sale_order_product_category1").val(data['product_category1']);
                    $("#return_sale_order_product_size").val(data['product_size']);
                }
                else
                {
                    $("#input_return_sale_customer_id").val('');
                    $("#input_return_sale_customer").val('');
                    $("#input_return_sale_phone").val('');
                    $("#input_return_sale_card_no").val('');
                    $('#input_return_sale_product').attr('type', 'hidden');
                    $("#total_return_sale_price").val('');
                    $("#previous_due").val('');
                    $("#current_due").val('');
                    $("#return_balance").val('');                        
                    $("#sale_order_no").val('');  
                    $("#return_sale_order_purchase_order_no").val('');
                    $("#return_sale_order_product_category1").val('');
                    $("#return_sale_order_product_size").val('');
                }
            }
        });
    }
</script>

<script type="text/javascript">
    $(function() {
        var product_data = <?php echo json_encode($product_list_array) ?>;        
        set_product_list(product_data);
        process_sale_order_info('<?php echo $sale_order_no?>');
        $("#sale_order_no").change(function() {
            process_sale_order_info();
        });
        
        $("#update_return_sale_order").on("click", function() {
            //validation checking of sale order
            //checking whether staff is selected or not
            if ($("#staff_list").val().length === 0)
            {
                alert('Please select a staff.');
                return;
            }
            //checking whether customer is selected or not
            if ($("#input_return_sale_customer_id").val().length === 0 || $("#input_return_sale_customer_id").val() < 0)
            {
                alert('Please select a customer');
                return;
            }
            //checking whether sale order no is empty or not
            if ($("#sale_order_no").val().length === 0)
            {
                alert('Incorrect Order #');
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
            set_modal_confirmation_category_id(get_modal_confirmation_return_sale_order_category_id());
            $('#myModal').modal('show');
        });
        $("#modal_button_confirm").on("click", function() {
            if (get_modal_confirmation_category_id() === get_modal_confirmation_return_sale_order_category_id())
            {
                //creating a list based on selected products
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
                        }
//                        if ($(this).attr("name") === "purchase_order_no")
//                        {
//                            product_info.setPurchaseOrderNo($(this).attr("value"));
//                        }
                        if ($(this).attr("name") === "price")
                        {
                            product_info.setUnitPrice($(this).attr("value"));
                        }
                        if ($(this).attr("name") === "product_price")
                        {
                            product_info.setSubTotal($(this).attr("value"));
                        }
                    });
                    product_list[product_list_counter++] = product_info;
                });
                var sale_info = new Sale();
                sale_info.setOrderNo($("#sale_order_no").val());
                sale_info.setPurchaseOrderNo($("#return_sale_order_purchase_order_no").val());
                sale_info.setProductCategory1($("#return_sale_order_product_category1").val());
                sale_info.setProductSize($("#return_sale_order_product_size").val());
                sale_info.setCustomerId($("#input_return_sale_customer_id").val());
                sale_info.setRemarks($("#sale_remarks").val());
                sale_info.setCreatedBy($("#staff_list").val());
                sale_info.setTotal($("#total_return_sale_price").val());
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "sale/update_return_sale_order",
                    data: {
                        product_list: product_list,
                        sale_info: sale_info,
                        current_due: $("#current_due").val(),
                        return_balance: $("#return_balance").val()
                    },
                    success: function(data) {
                        if (data['status'] === '1')
                        {
                            alert('Trascaction is executed successfully.');
                            $("#tbody_selected_product_list").html('');
                            $("#input_return_sale_customer_id").val('');
                            $("#input_return_sale_customer").val('');
                            $("#input_return_sale_phone").val('');
                            $("#input_return_sale_card_no").val('');
                            $('#input_return_sale_product').attr('type', 'hidden');
                            $("#total_return_sale_price").val('');
                            $("#previous_due").val('');
                            $("#current_due").val('');
                            $("#return_balance").val('');
                            $("#sale_order_no").val('');                            
                        }
                        else if (data['status'] === '0')
                        {
                            alert(data['message']);
                        }
                    }
                });
            }
            $('#myModal').modal('hide');
        });
        $("#tbody_selected_product_list").on("change", "input", function() {
            var product_quantity = '';
            var product_unit_price = '';
            var total_product_price = '';
            $("input", $(this).parent().parent()).each(function() {
                if ($(this).attr("name") === "quantity")
                {
                    $(this).attr('value', $(this).val());
                    if($(this).val() === '' || !isNumber($(this).val() ))
                    {
                        product_quantity = 0;
                    }
                    else
                    {
                        product_quantity = $(this).val();
                    }
                }
                if ($(this).attr("name") === "price")
                {
                    $(this).attr('value', $(this).val());
                    if($(this).val() === '' || !isNumber($(this).val() ) )
                    {
                        product_unit_price = 0;
                    }
                    else
                    {
                        product_unit_price = $(this).val();
                    }
                }
                if ($(this).attr("name") === "product_price")
                {
                    total_product_price = (product_quantity * product_unit_price) ;
                    $(this).attr('value', total_product_price);
                    $(this).val(total_product_price);
                }
            });
            var total_return_sale_price = 0;
            $("input", "#tbody_selected_product_list").each(function() {
                if ($(this).attr("name") === "product_price")
                {
                    total_return_sale_price = +total_return_sale_price + +$(this).val();
                }
            });
            $("#total_return_sale_price").val(total_return_sale_price);
            //$("#return_balance").val(total_return_sale_price);
            var current_due = +$("#previous_due").val() - +$("#total_return_sale_price").val();
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
        $("#return_balance").change(function() {
            if( +$("#total_return_sale_price").val() < +$("#return_balance").val() )
            {
                alert('Incorrect value for Return Balance. It must be less than or equal to Total');
                $("#current_due").val('');
                $("#return_balance").val('');
                return;
            }
            var current_due = +$("#previous_due").val() - (+$("#total_return_sale_price").val() - +$("#return_balance").val());
            $("#current_due").val(current_due);
        });
    });
</script>
<script type="text/javascript">
    $(function() {
        $('.dropdown-toggle').dropdown();
        $('.dropdown').click(function(e) {
            e.stopPropagation();
        });

    });
</script>

<h3>Return Sale Order</h3>
<div class ="form-horizontal top-bottom-padding form-background">
    <div class="row">
        <div class="col-md-2">        
        </div>
        <div class ="col-md-8 form-horizontal">
            <div class="row">
                <input type="hidden" id="return_sale_order_purchase_order_no" name="return_sale_order_purchase_order_no" value=""/>
                <input type="hidden" id="return_sale_order_product_category1" name="return_sale_order_product_category1" value=""/>
                <input type="hidden" id="return_sale_order_product_size" name="return_sale_order_product_size" value=""/>
                <div class ="col-md-7 form-horizontal margin-top-bottom">
                    <div class="form-group" >
                        <label for="input_return_sale_customer" class="col-md-3 control-label requiredField">
                            Customer name
                        </label> 
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'input_return_sale_customer_id', 'id' => 'input_return_sale_customer_id', 'class' => 'form-control', 'type' => 'hidden')); ?>
                            <?php echo form_input(array('name' => 'input_return_sale_customer', 'id' => 'input_return_sale_customer', 'class' => 'form-control', 'readonly' => 'readonly')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="input_return_sale_phone" class="col-md-3 control-label requiredField">
                            Phone No.
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'input_return_sale_phone', 'id' => 'input_return_sale_phone', 'class' => 'form-control', 'readonly' => 'readonly')); ?>
                        </div> 
                    </div>
                    <?php if($shop_info['shop_type_id'] == SHOP_TYPE_SMALL){?>
                    <div class="form-group">
                        <label for="input_return_sale_card_no" class="col-md-3 control-label requiredField">
                            Card No.
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'input_return_sale_card_no', 'id' => 'input_return_sale_card_no', 'class' => 'form-control', 'readonly' => 'readonly')); ?>
                        </div> 
                    </div>
                    <?php }?>
                    <div class="form-group">
                        <label for="input_return_sale_product" class="col-md-3 control-label requiredField">
                            Product
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('type'=>'hidden', 'name' => 'input_return_sale_product', 'id' => 'input_return_sale_product', 'class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#modal_select_sold_product')); ?>
                        </div> 
                    </div>
                </div>
                <div class ="col-md-5 form-horizontal margin-top-bottom">
                    <div class="form-group">
                        <label for="sale_order_no" class="col-md-4 control-label requiredField">
                            Sale Order No.
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'sale_order_no', 'id' => 'sale_order_no', 'class' => 'form-control', 'value' => $sale_order_no)); ?>
                        </div> 
                    </div>                      
                </div>
            </div>
            <?php $this->load->view("common/order_process_products"); ?>
            <div class="row margin-top-bottom">
                <div class ="col-md-12 form-horizontal">
                    <div class="form-group">
                        <label for="sale_remarks" class="col-md-2 control-label requiredField">
                            Remarks
                        </label>
                        <div class ="col-md-3 col-md-offset-5">
                            <?php echo form_textarea(array('name' => 'sale_remarks', 'id' => 'sale_remarks', 'class' => 'form-control', 'rows' => '2', 'cols' => '4')); ?>

                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="total_return_sale_price" class="col-md-2 control-label requiredField">
                            Total
                        </label>
                        <div class ="col-md-3 col-md-offset-5">
                            <?php echo form_input(array('name' => 'total_return_sale_price', 'id' => 'total_return_sale_price', 'class' => 'form-control', 'readonly' => 'readonly')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="previous_due" class="col-md-2 control-label requiredField">
                            Previous Due
                        </label>
                        <div class ="col-md-3 col-md-offset-5">
                            <?php echo form_input(array('name' => 'previous_due', 'id' => 'previous_due', 'class' => 'form-control' , 'readonly' => 'readonly')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="current_due" class="col-md-2 control-label requiredField">
                            Current Due
                        </label>
                        <div class ="col-md-3 col-md-offset-5">
                            <?php echo form_input(array('name' => 'current_due', 'id' => 'current_due', 'class' => 'form-control', 'readonly' => 'readonly')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="return_balance" class="col-md-2 control-label requiredField">
                            Return balance
                        </label>
                        <div class ="col-md-3 col-md-offset-5">
                            <?php echo form_input(array('name' => 'return_balance', 'id' => 'return_balance', 'class' => 'form-control', 'readonly' => 'readonly')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-md-2 control-label requiredField">
                            Select Staff
                        </label>
                        <div class ="col-md-3 col-md-offset-5">
                            <?php echo form_dropdown('staff_list', array(''=>'Select')+$staff_list, '', 'class="form-control" id="staff_list"'); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="update_return_sale_order" class="col-md-2 control-label requiredField">

                        </label>
                        <div class ="col-md-3 col-md-offset-5">
                            <?php echo form_button(array('name' => 'update_return_sale_order', 'id' => 'update_return_sale_order', 'content' => 'Update', 'class' => 'form-control btn-success')); ?>
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
<?php //$this->load->view("purchase/common_modal_select_return_product");
$this->load->view("sales/modal_select_sold_product");