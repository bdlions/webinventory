<script type="text/javascript">
    $(document).ready(function() {
        var product_data = <?php echo json_encode($product_list_array) ?>;        
        set_product_list(product_data);        
        $("#total_purchase_price").val('');        
    });
</script>
<script>
    function append_selected_product(prod_info)
    {
        prod_info['unit_price'] = '';
        prod_info['readonly'] = 'false';
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
        var total_purchase_price = 0;
        $("input", "#tbody_selected_product_list").each(function() {
            if ($(this).attr("name") === "product_buy_price")
            {
                total_purchase_price = +total_purchase_price + +$(this).val();
            }
        });
        $("#total_purchase_price").val(total_purchase_price);        
    }

    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }
</script>

<script type="text/javascript">
    $(function() {
        $("#input_raise_purchase_order_no").change(function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "purchase/get_purchase_info_from_lot_no",
                data: {
                    lot_no: $("#input_raise_purchase_order_no").val()
                },
                success: function(data) {
                    var supplier_info = data['supplier_info'];
                    var purchased_product_list = data['purchased_product_list'];
                    var supplier_due = data['supplier_due'];
                    set_purchased_product_list(purchased_product_list);
                    if(supplier_info.supplier_id)
                    {
                        $("#input_raise_purchase_supplier_id").val(supplier_info.supplier_id);
                        $("#input_raise_purchase_supplier").val(supplier_info.first_name+supplier_info.last_name);
                        $("#input_raise_purchase_phone").val(supplier_info.phone);
                        $("#input_raise_purchase_company").val(supplier_info.company);
                        $('#input_raise_purchase_product').attr('type', 'text');
                        $("#total_purchase_price").val('');
                        $("#previous_due").val(supplier_due);
                        $("#current_due").val(supplier_due);
                    }
                    else
                    {
                        $("#input_raise_purchase_supplier_id").val('');
                        $("#input_raise_purchase_supplier").val('');
                        $("#input_raise_purchase_phone").val('');
                        $("#input_raise_purchase_company").val('');
                        $('#input_raise_purchase_product').attr('type', 'hidden');
                        $("#total_purchase_price").val('');
                        $("#previous_due").val('');
                        $("#current_due").val('');
                    }
                }
            });
        });
        
        $("#button_raise_purchase_order").on("click", function() {
            //validation checking of purchase order
            //checking whether supplier is assigned or not
            if ($("#input_raise_purchase_supplier_id").val().length === 0 || $("#input_raise_purchase_supplier_id").val() < 0)
            {
                alert('Please assign correct Lot #');
                return;
            }
            //checking whether purchase order no is assigned or not
            if ($("#input_raise_purchase_order_no").val().length === 0)
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
            set_modal_confirmation_category_id(get_modal_confirmation_raise_purchase_order_category_id());
            $('#myModal').modal('show');
        });
        $("#modal_button_confirm").on("click", function() {
            if( get_modal_confirmation_category_id() === get_modal_confirmation_raise_purchase_order_category_id() )
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
                            product_info.setPurchaseOrderNo($("#input_raise_purchase_order_no").val());
                        }
                        if ($(this).attr("name") === "price")
                        {
                            product_info.setUnitPrice($(this).attr("value"));
                        }
                        if ($(this).attr("name") === "product_buy_price")
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
                purchase_info.setOrderNo($("#input_raise_purchase_order_no").val());
                purchase_info.setSupplierId($("#input_raise_purchase_supplier_id").val());
                purchase_info.setRemarks($("#purchase_remarks").val());
                purchase_info.setTotal($("#total_purchase_price").val());
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "purchase/raise_purchase",
                    data: {
                        product_list: product_list,
                        purchase_info: purchase_info,
                        current_due: $("#current_due").val()
                    },
                    success: function(data) {
                        if (data['status'] === '0')
                        {
                            alert(data['message']);
                        }
                        else if (data['status'] === '1')
                        {
                            alert('Trascaction is executed successfully.');
                            $("#input_raise_purchase_order_no").val('');
                            $("#tbody_selected_product_list").html('');
                            $("#input_raise_purchase_supplier_id").val('');
                            $("#input_raise_purchase_supplier").val('');
                            $("#input_raise_purchase_phone").val('');
                            $("#input_raise_purchase_company").val('');
                            $('#input_raise_purchase_product').attr('type', 'hidden');
                            $("#purchase_order_no").val('');
                            $("#purchase_remarks").val('');
                            $("#total_purchase_price").val('');
                            $("#previous_due").val('');
                            $("#current_due").val('');
                        }
                    }
                });
            }
            $('#myModal').modal('hide');
        });
        
        $("#tbody_selected_product_list").on("change", "input", function() {
            var product_id = '';
            var product_quantity = 1;
            var product_buy_price = 100;
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
                        product_buy_price = $(this).val();
                    }
                }
                if ($(this).attr("name") === "product_buy_price")
                {
                    $(this).attr('value', product_quantity * product_buy_price);
                    $(this).val(product_quantity * product_buy_price);
                }
            });
            var total_purchase_price = 0;
            $("input", "#tbody_selected_product_list").each(function() {
                if ($(this).attr("name") === "product_buy_price")
                {
                    total_purchase_price = +total_purchase_price + +$(this).val();
                }
            });
            $("#total_purchase_price").val(total_purchase_price);
            var current_due = +$("#total_purchase_price").val() + +$("#previous_due").val();
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

<h3>Raise Warehouse Purchase Order</h3>
<div class ="top-bottom-padding form-background">
    <div class="row">
        <div class="col-md-2">        
        </div>
        <div class ="col-md-8 form-horizontal">
            <div class="row">
                <div class ="col-md-7 form-horizontal margin-top-bottom">
                    <div class="form-group">
                        <label for="input_raise_purchase_supplier" class="col-md-3 control-label requiredField">
                            Supplier Name
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'input_raise_purchase_supplier_id', 'id' => 'input_raise_purchase_supplier_id', 'type'=>'hidden', 'class' => 'form-control')); ?>
                            <?php echo form_input(array('name' => 'input_raise_purchase_supplier', 'id' => 'input_raise_purchase_supplier', 'readonly'=>'true', 'class' => 'form-control')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="input_raise_purchase_phone" class="col-md-3 control-label requiredField">
                            Phone No
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'input_raise_purchase_phone', 'id' => 'input_raise_purchase_phone', 'readonly'=>'true', 'class' => 'form-control')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="input_raise_purchase_company" class="col-md-3 control-label requiredField">
                            Company
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'input_raise_purchase_company', 'id' => 'input_raise_purchase_company', 'readonly'=>'true', 'class' => 'form-control')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="input_raise_purchase_product" class="col-md-3 control-label requiredField">
                            Product
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('type'=>'hidden', 'name' => 'input_raise_purchase_product', 'id' => 'input_raise_purchase_product', 'class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#modal_select_product')); ?>
                        </div> 
                    </div>
                </div>
                <div class ="col-md-5 form-horizontal margin-top-bottom">
                    <div class="form-group">
                        <label for="input_raise_purchase_order_no" class="col-md-4 control-label requiredField">
                            Lot No
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'input_raise_purchase_order_no', 'id' => 'input_raise_purchase_order_no', 'class' => 'form-control')); ?>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="row col-md-11">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Product Unit</th>
                                <th>Unit Price</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_selected_product_list">                        
                        </tbody>
                        <?php //echo '<pre/>';print_r($product_list_array);exit;?>
                        <script type="text/x-tmpl" id="tmpl_selected_product_info">
                            {% var i=0, product_info = ((o instanceof Array) ? o[i++] : o); %}
                            {% while(product_info){ %}
                            <tr>
                            <td id="<?php echo '{%= product_info.id%}'; ?>"><input name="name" type="hidden" value="<?php echo '{%= product_info.name%}'; ?>"/><?php echo '{%= product_info.name%}'; ?></td>
                            <td><input class="input-width-table" id="<?php echo '{%= product_info.id%}'; ?>" name="quantity" type="text" value=""/></td>
                            {% if(product_info.readonly == 'true') { %}
                            <td><?php echo '{%= product_info.category_unit %}'; ?></td>
                            <td><input readonly="readonly" class="input-width-table" id="<?php echo '{%= product_info.id%}'; ?>" name="price" type="text" value="{%= product_info.unit_price %}"/></td>
                            {% }else{ %} 
                            <td><input class="input-width-table" id="<?php echo '{%= product_info.id%}'; ?>" name="price" type="text" value=""/></td>
                            {% } %}
                            <td><input class="input-width-table" name="product_buy_price" type="text" readonly="true" value=""/></td>
                            </tr>
                            {% product_info = ((o instanceof Array) ? o[i++] : null); %}
                            {% } %}
                        </script>
                    </table>
                </div>
            </div>
            <div class="row margin-top-bottom">
                <div class ="col-md-12 form-horizontal">
                    <div class="form-group">
                        <label for="remarks" class="col-md-2 control-label requiredField">
                            Remarks
                        </label>
                        <div class ="col-md-3 col-md-offset-5">
                            <?php echo form_textarea(array('name' => 'remarks', 'id' => 'remarks', 'class' => 'form-control', 'rows' => '2', 'cols' => '4')); ?>

                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="total_purchase_price" class="col-md-2 control-label requiredField">
                            Total
                        </label>
                        <div class ="col-md-3 col-md-offset-5">
                            <?php echo form_input(array('name' => 'total_purchase_price', 'id' => 'total_purchase_price', 'class' => 'form-control', 'readonly' => 'readonly')); ?>
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
                        <label for="button_raise_purchase_order" class="col-md-2 control-label requiredField">

                        </label>
                        <div class ="col-md-3 col-md-offset-5">
                            <?php echo form_button(array('name' => 'button_raise_purchase_order', 'id' => 'button_raise_purchase_order', 'content' => 'Update', 'class' => 'form-control btn-success')); ?>
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
<?php $this->load->view("purchase/modal_select_product"); ?>