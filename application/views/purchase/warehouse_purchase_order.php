<script type="text/javascript">
    $(document).ready(function() {
        var product_data = <?php echo json_encode($product_list_array) ?>;        
        set_product_list(product_data);
        
        $("#total_purchase_price").val(0);
        $("#previous_due").val(0);
        $("#paid_amount").val(0);
        $("#current_due").val(0);
    });
</script>
<script>
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
        var current_due = +$("#total_purchase_price").val() - +$("#paid_amount").val() + +$("#previous_due").val();
        $("#current_due").val(current_due);
    }

    function update_fields_selected_supplier(sup_info)
    {
        $("#input_add_purchase_supplier_id").val(sup_info['supplier_id']);
        $("#input_add_purchase_supplier").val(sup_info['first_name']+' '+sup_info['last_name']);
        $("#input_add_purchase_company").val(sup_info['company']);
        $("#input_add_purchase_phone").val(sup_info['phone']);
        
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "payment/get_supplier_previous_due",
            data: {
                supplier_id: sup_info['supplier_id']
            },
            success: function(data) {
                $("#previous_due").val(data);
                
                var current_due = +$("#total_purchase_price").val() - +$("#paid_amount").val() + +$("#previous_due").val();
                $("#current_due").val(current_due);
            }
        });
    }

    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }
</script>

<script type="text/javascript">
    $(function() {
        $("#button_save_purchase_order").on("click", function() {
            //validation checking of purchase order
            //checking whether supplier is selected or not
            if ($("#input_add_purchase_supplier_id").val().length === 0 || $("#input_add_purchase_supplier_id").val() < 0)
            {
                alert('Please select a supplier');
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
            set_modal_confirmation_category_id(get_modal_confirmation_save_purchase_order_category_id());
            $('#myModal').modal('show');
        });
        $("#modal_button_confirm").on("click", function() {
            if( get_modal_confirmation_category_id() === get_modal_confirmation_save_purchase_order_category_id() )
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
                var purchase_info = new Purchase();
                purchase_info.setOrderNo($("#purchase_order_no").val());
                purchase_info.setSupplierId($("#input_add_purchase_supplier_id").val());
                purchase_info.setRemarks($("#remarks").val());
                purchase_info.setTotal($("#total_purchase_price").val());
                purchase_info.setPaid($("#paid_amount").val());
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "purchase/add_warehouse_purchase",
                    data: {
                        product_list: product_list,
                        purchase_info: purchase_info,
                        current_due: $("#current_due").val(),
                        forward_showroom:($("#checkbox_forward_showroom").prop('checked'))?1:0
                    },
                    success: function(data) {
                        var response = JSON.parse(data);
                        if (response['status'] === '0')
                        {
                            alert(response['message']);
                        }
                        else if (response['status'] === '1')
                        {
                            alert('Purchase order is executed successfully.');
                            $("#tbody_selected_product_list").html('');
                            $("#input_add_purchase_supplier_id").val('');
                            $("#input_add_purchase_supplier").val('');
                            $("#input_add_purchase_company").val('');
                            $("#input_add_purchase_phone").val('');
                            $("#purchase_order_no").val(+$("#purchase_order_no").val() + 1);
                            $("#remarks").val('');
                            $("#total_purchase_price").val(0);
                            $("#previous_due").val(0);
                            $("#paid_amount").val(0);
                            $("#current_due").val(0);
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
                    /*if ($(this).val() === '' || $(this).val() <= 0 || !isNumber($(this).val()))
                    {
                        $(this).val('1');
                        alert("Invalid quantity.");
                        return false;
                    }
                    else if ($(this).attr("id") > 0)
                    {
                        product_id = $(this).attr("id");
                        $(this).attr('value', $(this).val());
                        product_quantity = $(this).val();
                    }*/
                    if ($(this).attr("id") > 0)
                    {
                        product_id = $(this).attr("id");
                        $(this).attr('value', $(this).val());
                        product_quantity = $(this).val();
                    }
                }
                if ($(this).attr("name") === "price")
                {
                    /*if ($(this).val() === '' || $(this).val() <= 0 || !isNumber($(this).val()))
                    {
                        $(this).val('100');
                        alert("Invalid price.");
                        return false;
                    }
                    else if ($(this).attr("id") > 0)
                    {
                        product_id = $(this).attr("id");
                        $(this).attr('value', $(this).val());
                        product_price = $(this).val();
                    }*/
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
            
            var current_due = +$("#total_purchase_price").val() - +$("#paid_amount").val() + +$("#previous_due").val();
            $("#current_due").val(current_due);

        });
        
        $("#paid_amount").on("change", function() {
            var current_due = +$("#total_purchase_price").val() - +$("#paid_amount").val() + +$("#previous_due").val();
            $("#current_due").val(current_due);
        });
    });
</script>
<script type="text/javascript">
    $(function() {
        $('.dropdown-toggle').dropdown();
        $(".dropdown-menu").on("click", function(e) {
            e.stopPropagation();
        });
        $(".btn-default").on("click", function(e) {
            $('#myModal').modal('hide');
            e.stopPropagation();
        });
    });
</script>

<h3>Warehouse Purchase Order</h3>
<div class ="form-horizontal top-bottom-padding form-background">
    <div class="row">
        <div class="col-md-2">        
        </div>
        <div class ="col-md-8 form-horizontal">
            <div class="row">
                <div class ="col-md-7 form-horizontal margin-top-bottom">
                    <div class="form-group" >
                        <label for="input_add_purchase_supplier" class="col-md-3 control-label requiredField">
                            Supplier Name
                        </label> 
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'input_add_purchase_supplier_id', 'id' => 'input_add_purchase_supplier_id', 'class' => 'form-control', 'type' => 'hidden')); ?>
                            <?php echo form_input(array('name' => 'input_add_purchase_supplier', 'id' => 'input_add_purchase_supplier', 'class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#modal_select_supplier')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="input_add_purchase_phone" class="col-md-3 control-label requiredField">
                            Phone No.
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'input_add_purchase_phone', 'id' => 'input_add_purchase_phone', 'class' => 'form-control')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="input_add_purchase_company" class="col-md-3 control-label requiredField">
                            Company
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'input_add_purchase_company', 'id' => 'input_add_purchase_company', 'class' => 'form-control')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="product" class="col-md-3 control-label requiredField">
                            Product
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'input_add_purchase_supplier', 'id' => 'input_add_purchase_supplier', 'class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#common_modal_select_product')); ?>
                        </div> 
                    </div>
                </div>
                <div class ="col-md-5 form-horizontal margin-top-bottom">
                    <div class="form-group">
                        <label for="purchase_order_no" class="col-md-4 control-label requiredField">
                            Lot No
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'purchase_order_no', 'id' => 'purchase_order_no', 'class' => 'form-control','value' => $purchase_order_no)); ?>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><label style="padding: 5px 5px;"><input type="checkbox" onclick="check_all_checkbox(this)" value="" style="margin: 10px,10px,0px,0px;"><span style="padding-left: 2px">Check All</span></label></th>
                                <th style="padding: 18px">Product Name</th>
                                <th style="padding: 18px">Quantity</th>
                                <th style="padding: 18px">Product Unit</th>
                                <th style="padding: 18px">Unit Price</th>
                                <th style="padding: 18px">Sub Total</th>
                                <th style="padding: 18px">Delete</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_selected_product_list">                        
                        </tbody>
                    </table>
                </div>
            </div>
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
                        <label for="paid_amount" class="col-md-7 control-label requiredField">
                            Payment Amount
                        </label>
                        <div class ="col-md-3">
                            <?php echo form_input(array('name' => 'paid_amount', 'id' => 'paid_amount', 'class' => 'form-control')); ?>
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
                        <label for="current_due" class="col-md-7 control-label requiredField">
                            Forward to Showroom
                        </label>
                        <div class ="col-md-3">
                            <input id="checkbox_forward_showroom" name="checkbox_forward_showroom" type="checkbox"/>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="save" class="col-md-2 control-label requiredField">

                        </label>
                        <div class ="col-md-3 col-md-offset-5">
                            <?php echo form_button(array('name' => 'button_save_purchase_order', 'id' => 'button_save_purchase_order', 'content' => 'Save', 'class' => 'form-control btn-success')); ?>
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
<?php $this->load->view("purchase/modal_select_supplier"); ?>
<?php $this->load->view("purchase/common_modal_select_product"); ?>
<?php $this->load->view("purchase/common_append_template"); ?>