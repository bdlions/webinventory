<script type="text/javascript">
    $(document).ready(function() {
        set_default_values_at_sale();
        $('#input_add_sale_product').on('click',function(){
            //we are not allowing add product option during sale   
            $('#new_product_add_div').hide();
            $('#common_modal_select_product').modal();
        });
        
        var product_data = <?php echo json_encode($product_list_array) ?>;
        set_product_list(product_data);
        
        $("#button_due_collect").on("click", function() {
            $('#modal_due_collect').modal('show');
        });
        var default_purchase_order_no = '<?php echo $shop_info['sale_default_purchase_order_no'] ?>';
        if( default_purchase_order_no != "")
        {
            $('#input_table_header_purchase_order_no').val(default_purchase_order_no);
            $('.disabler_class').attr("disabled", true);
        }
        

    });
    function set_default_values_at_sale()
    {
        $("#tbody_selected_product_list").html('');
        $("#input_add_sale_customer_id").val('');
        $("#input_add_sale_customer").val('');
        $("#input_add_sale_company").val('');
        $("#input_add_sale_phone").val('');
        $("#input_add_sale_card_no").val('');
        $("#sale_order_no").val('');
        $("#sale_remarks").val('');
        $("#total_sale_price").val(0);
        $("#previous_due").val(0);
        $("#cash_paid_amount").val(0);
        $("#current_due").val(0);
        $("#checkbox_download_sale_order").removeAttr('checked');
    }
    function set_all_lot_no(lot_no_value){
        $('input[name^=purchase_order_no]').each(function(){
            $(this).val($(lot_no_value).val());
        });
    }
</script>
<script>
    function append_selected_product(prod_info)
    {
        $("#tbody_selected_product_list").html($("#tbody_selected_product_list").html()+tmpl("tmpl_selected_product_info",  prod_info));
        if( $('#input_table_header_purchase_order_no').is(":disabled") ){
            $('.disabler_class').attr("disabled", true);
            $('input[name^=purchase_order_no]').each(function(){
                $(this).val( $('#input_table_header_purchase_order_no').val() );
            })
        }
        color_setter();
        var total_sale_price = 0;
        $("input", "#tbody_selected_product_list").each(function() {
            if ($(this).attr("name") === "product_price")
            {
                total_sale_price = +total_sale_price + +$(this).val();
            }
        });
        $("#total_sale_price").val(total_sale_price);
    }

    function update_fields_selected_customer(cust_info)
    {
        $("#input_add_sale_customer_id").val(cust_info['customer_id']);
        $("#input_add_sale_customer").val(cust_info['first_name']+' '+cust_info['last_name']);
        $("#input_add_sale_card_no").val(cust_info['card_no']);
        $("#input_add_sale_phone").val(cust_info['phone']);

        var rString = randomString(13, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $("#sale_order_no").val(rString);
        
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "payment/get_customer_previous_due",
            data: {
                customer_id: cust_info['customer_id']
            },
            success: function(data) {
                $("#previous_due").val(data);
                
                var current_due = +$("#total_sale_price").val() - +$("#cash_paid_amount").val() + +$("#previous_due").val();
                $("#current_due").val(current_due);
            }
        });
    }

    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }

    function randomString(length, chars) {
        var result = '';
        for (var i = length; i > 0; --i)
            result += chars[Math.round(Math.random() * (chars.length - 1))];
        return result;
    }
</script>

<script type="text/javascript">
    $(function() {
        
        $("#save_sale_order").on("click", function() {
            //validation checking of sale order
            //checking whether staff is selected or not
            if ($("#staff_list").val().length === 0)
            {
                alert('Please select a staff.');
                return;
            }
            //checking whether customer is selected or not
            if ($("#input_add_sale_customer_id").val().length === 0 || $("#input_add_sale_customer_id").val() < 0)
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
            if ( +$("#total_sale_price").val() < (+$("#cash_paid_amount").val()) )
            {
                alert('Please click on Due Collect to pay previous due.');
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
            set_modal_confirmation_category_id(get_modal_confirmation_save_sale_order_category_id());
            $('#myModal').modal('show');
        });
        $("#modal_button_confirm").on("click", function() {
            if (get_modal_confirmation_category_id() === get_modal_confirmation_save_sale_order_category_id())
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
                        if ($(this).attr("name") === "product_name")
                        {
                            product_info.setName( $(this).attr("value") );
                        }
                        if ($(this).attr("name") === "purchase_order_no")
                        {
                            product_info.setPurchaseOrderNo($(this).attr("value"));
                        }
                        if ($(this).attr("name") === "price")
                        {
                            product_info.setUnitPrice($(this).attr("value"));
                        }
                        if ($(this).attr("name") === "discount")
                        {
                            product_info.setDiscount($(this).attr("value"));
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
                sale_info.setCustomerId($("#input_add_sale_customer_id").val());
                sale_info.setRemarks($("#sale_remarks").val());
                sale_info.setCreatedBy($("#staff_list").val());
                sale_info.setTotal($("#total_sale_price").val());
                sale_info.setCashPaid($("#cash_paid_amount").val());
                sale_info.setCheckPaid('0');
                sale_info.setCheckDescription('');
                sale_info.setPreviousDue($("#previous_due").val());
                sale_info.setCurrentDue($("#current_due").val());
                var customer_info = new Customer();
                customer_info.setFullName($("#input_add_sale_customer").val());
                customer_info.setPhone($("#input_add_sale_phone").val());
                waitScreen.show();
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "sale/add_sale",
                    data: {
                        product_list: product_list,
                        sale_info: sale_info,
                        customer_info: customer_info,
                        current_due: $("#current_due").val()
                    },
                    success: function(data) {
                        waitScreen.hide();
                        if (data['status'] === '1')
                        {
                            $("#print_sale_order_no").val($("#sale_order_no").val());
                            if($("#checkbox_download_sale_order").prop('checked'))
                            {
                                $("#form_download_sale_order").submit();
                            } 
                            else
                            {
                                alert('Sale order is executed successfully.');                                
                            }
                            set_default_values_at_sale();
                            //printPDF();
//                            alert('Sale order is executed successfully.');// replace this w
                            
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
            var product_discount = '';
            var product_unit_price = '';
            var total_product_price = '';
            var product_lot_map = Array();
            var is_valid = true;
            //user will not be able to use same lot no more than one for same product
            $("input", "#tbody_selected_product_list").each(function() {
                if ($(this).attr("name") === "purchase_order_no" && $(this).val() != '' && is_valid)
                {
                    var key = $(this).attr("id")+'_'+$(this).val();
                    if(product_lot_map.indexOf(key) >= 0) {
                        alert('Duplicate lot no. Please use a different lot no.');
                        $(this).attr('value', '');
                        $(this).val('');
                        is_valid = false;
                        return;
                    }
                    else {
                        product_lot_map.push(key);
                    }
                }
            });
            if(!is_valid)
            {
                return;
            }
            $("input", $(this).parent().parent()).each(function() {
                if ($(this).attr("name") === "purchase_order_no")
                {
                    /*if ($(this).val() === '')
                    {
                        $(this).val('1');
                        alert("Invalid Lot No.");
                        return false;
                    }*/
                    $(this).attr('value', $(this).val());
                }
                if ($(this).attr("name") === "quantity")
                {
                    /*if ($(this).val() === '' || $(this).val() <= 0 || !isNumber($(this).val()))
                    {
                        $(this).val('1');
                        alert("Invalid quantity.");
                        return false;
                    }*/
                    $(this).attr('value', $(this).val());
                    if($(this).val() == '' || !isNumber($(this).val() ))
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
                    /*if ($(this).val() === '' || $(this).val() < 0 || !isNumber($(this).val()))
                    {
                        $(this).val('1');
                        alert("Invalid quantity.");
                        return false;
                    }*/
                    $(this).attr('value', $(this).val());
                    if($(this).val() == '' || !isNumber($(this).val() ) )
                    {
                        product_unit_price = 0;
                    }
                    else
                    {
                        product_unit_price = $(this).val();
                    }
                }
                /*if ($(this).attr("name") === "discount")
                {
                    if ($(this).val() === '' || !isNumber($(this).val()) || +$(this).val() < 0 || +$(this).val() > 100)
                    {
                        $(this).val('0');
                        alert("Invalid discount.");
                        return false;
                    }
                    $(this).attr('value', $(this).val());
                    product_discount = $(this).val();
                }*/
                if ($(this).attr("name") === "product_price")
                {
                    //total_product_price = (product_quantity * product_unit_price) - (product_quantity * product_unit_price * product_discount / 100);
                    total_product_price = (product_quantity * product_unit_price) ;
                    $(this).attr('value', total_product_price);
                    $(this).val(total_product_price);
                }
            });

            var total_sale_price = 0;
            $("input", "#tbody_selected_product_list").each(function() {
                if ($(this).attr("name") === "product_price")
                {
                    total_sale_price = +total_sale_price + +$(this).val();
                }
            });
            $("#total_sale_price").val(total_sale_price);
            var current_due = +$("#total_sale_price").val() - +$("#cash_paid_amount").val() + +$("#previous_due").val();
            $("#current_due").val(current_due);
        });
        $("#cash_paid_amount").on("change", function() {
            var current_due = +$("#total_sale_price").val() - +$("#cash_paid_amount").val() + +$("#previous_due").val();
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
<h3>Sales Order</h3>
<div class ="form-horizontal top-bottom-padding form-background">
    <div class="row">
        <div class="col-md-2">        
        </div>
        <div class ="col-md-8 form-horizontal">
            <div class="row">
                <div class ="col-md-7 form-horizontal margin-top-bottom">
                    <div class="form-group" >
                        <label for="input_add_sale_customer" class="col-md-3 control-label requiredField">
                            Customer name
                        </label> 
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'input_add_sale_customer_id', 'id' => 'input_add_sale_customer_id', 'class' => 'form-control', 'type' => 'hidden')); ?>
                            <?php echo form_input(array('name' => 'input_add_sale_customer', 'id' => 'input_add_sale_customer', 'class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#modal_select_customer')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="input_add_sale_phone" class="col-md-3 control-label requiredField">
                            Phone No.
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'input_add_sale_phone', 'id' => 'input_add_sale_phone', 'class' => 'form-control')); ?>
                        </div> 
                    </div>
                    <?php if($shop_info['shop_type_id'] == SHOP_TYPE_SMALL){?>
                    <div class="form-group">
                        <label for="input_add_sale_card_no" class="col-md-3 control-label requiredField">
                            Card No.
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'input_add_sale_card_no', 'id' => 'input_add_sale_card_no', 'class' => 'form-control')); ?>
                        </div> 
                    </div>
                    <?php }?>
                    <div class="form-group">
                        <label for="product" class="col-md-3 control-label requiredField">
                            Product
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'input_add_sale_product', 'id' => 'input_add_sale_product', 'class' => 'form-control')); ?>
                        </div> 
                    </div>
                </div>
                <div class ="col-md-5 form-horizontal margin-top-bottom">

                    <input type="hidden" id="sale_order_no" name="sale_order_no" value=""/>
                    <div class="form-group">
                        <label for="status" class="col-md-4 control-label requiredField">
                            &nbsp;
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_button(array('name' => 'button_due_collect', 'id' => 'button_due_collect', 'content' => 'Due Collect', 'class' => 'form-control btn-success')); ?>
                        </div> 
                    </div>
                </div>
            </div>
            <?php $this->load->view("common/order_process_products"); ?>
            <div class="row margin-top-bottom">
                <div class ="col-md-12 form-horizontal">
                    <div class="form-group">
                        <label for="sale_remarks" class="col-md-7 control-label requiredField">
                            Remarks
                        </label>
                        <div class ="col-md-3">
                            <?php echo form_textarea(array('name' => 'sale_remarks', 'id' => 'sale_remarks', 'class' => 'form-control', 'rows' => '5', 'cols' => '4')); ?>

                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="total_sale_price" class="col-md-7 control-label requiredField">
                            Total
                        </label>
                        <div class ="col-md-3">
                            <?php echo form_input(array('name' => 'total_sale_price', 'id' => 'total_sale_price', 'class' => 'form-control', 'readonly' => 'readonly')); ?>
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
                        <label for="cash_paid_amount" class="col-md-7 control-label requiredField">
                            Cash Payment
                        </label>
                        <div class ="col-md-3">
                            <?php echo form_input(array('name' => 'cash_paid_amount', 'id' => 'cash_paid_amount', 'class' => 'form-control')); ?>
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
                        <label for="status" class="col-md-7 control-label requiredField">
                            Select Staff
                        </label>
                        <div class ="col-md-3">
                            <?php echo form_dropdown('staff_list', array(''=>'Select')+$staff_list, '', 'class="form-control" id="staff_list"'); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="checkbox_download_sale_order" class="col-md-7 control-label requiredField">
                            Download sale order
                        </label>
                        <div class ="col-md-3">
                            <input id="checkbox_download_sale_order" name="checkbox_download_sale_order" type="checkbox"/>
                        </div> 
                    </div>
                    <div class="form-group">
                        <?php echo form_open("sale/sale_order", array('id' => 'form_download_sale_order', 'class' => 'form-horizontal'));?>
                        <input type="hidden" id="print_sale_order_no" name="print_sale_order_no" value=""/>
                        <?php echo form_close();?>
                    </div>
                    <div class="form-group">
                        <label for="save_sale_order" class="col-md-2 control-label requiredField">

                        </label>
                        <div class ="col-md-3 col-md-offset-5">
                            <?php echo form_button(array('name' => 'save_sale_order', 'id' => 'save_sale_order', 'content' => 'Save', 'class' => 'form-control btn-success')); ?>
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
<?php $this->load->view("sales/modal_due_collect"); ?>
<?php $this->load->view("sales/modal_select_customer"); ?>
<?php $this->load->view("common/modal_select_product_order"); ?>
<?php $this->load->view('common/wait_screen');