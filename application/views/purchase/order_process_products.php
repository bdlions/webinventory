<div class="row">
    <div class="col-md-offset-1 col-md-10">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="padding: 18px">Product</th>
                        <th style="padding: 18px">Suppliers</th>
                        <th style="padding: 18px" >Mobile No</th>
                        <th style="padding: 18px">Lot No</th>                    
                        <th style="padding: 18px">Sub Lot No</th>                    
                        <th style="padding: 18px">Size</th>                    
                        <th style="padding: 18px">Quantity</th>                    
                        <th style="padding: 18px">Unit Price</th>
                        <th style="padding: 18px">Sub Total</th>
                        <th style="padding: 18px">Delete</th>
                    </tr>
                </thead>
                <tbody >        
                    <tr id="daily_purchase_row_1" style="display: none;">
                        <td style="padding: 5px" >
                             <?php echo form_input(array('name' => 'input_add_purchase_product', 'id' => 'input_add_purchase_product', 'class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#common_modal_select_product')); ?>
                        </td>
                        <td style="padding: 5px" >
                            <?php echo form_input(array('name' => 'input_add_purchase_supplier_id', 'id' => 'input_add_purchase_supplier_id', 'class' => 'form-control', 'type' => 'hidden')); ?>
                            <?php echo form_input(array('name' => 'input_add_purchase_supplier', 'id' => 'input_add_purchase_supplier', 'class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#modal_select_supplier')); ?>
                        </td>
                        <td style="padding: 5px" >
                            <p>016123123123</p>
                        </td>
                        <td style="padding: 5px" >
                            <span>1</span>
                        </td>
                        <td style="padding: 5px" >
                            <span>2</span>
                        </td>
                        <td style="padding: 5px" >
                            <span>xl</span>
                        </td>

                        <td  style="padding: 5px" >
                            <input class="form-control input-width-table" id="<?php echo '{%= product_info.id%}'; ?>" name="price" type="text" value="50"/>
                        </td>
                        <td style="padding: 5px" >
                            <input class="form-control input-width-table" id="<?php echo '{%= product_info.id%}'; ?>" name="price" type="text" value="100"/>
                        </td>
                        <td style="padding: 5px" >
                            <input class="form-control input-width-table" name="product_price" type="text" readonly="true" value="5000"/>
                        </td>
                        <td id="" style="padding: 5px" >
                            <button onclick="delete_row_button_1" id="delete_row_button_1" name="delete_product_1"  class="glyphicon glyphicon-trash"></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php $this->load->view("purchase/modal_delete_daily_purchase_row"); ?>
<script type="text/javascript">
    $('#delete_row_button_1').on('click', function() {
        $('#modal_delete_row_1').modal('show');
    });
</script>
