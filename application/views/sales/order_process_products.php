<div class="row">
    <div class="col-md-12">
        <div class="table-responsive" style="padding: 0 10px;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="padding: 18px">Product</th>
                        <th style="padding: 18px">Customer</th>
                        <th style="padding: 18px">Mobile No</th>
                        <th style="padding: 18px" >Card No</th>
                        <th style="padding: 18px">Lot No</th>                    
                        <th style="padding: 18px">Sub Lot No</th>                    
                        <th style="padding: 18px">Size</th>                    
                        <th style="padding: 18px">Pieces</th>                    
                        <th style="padding: 18px">Unit Price</th>
                        <th style="padding: 18px">Sub Total</th>
                        <th style="padding: 18px">Staff</th>
                        <th style="padding: 18px">Delete</th>
                    </tr>
                </thead>
                <tbody >        
                    <tr id="daily_sale_row_1" style="display: none;">
                        <td style="padding: 5px" >
                             <?php echo form_input(array('name' => 'input_add_sale_product', 'id' => 'input_add_purchase_product', 'class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#common_modal_select_product')); ?>
                        </td>
                        <td style="padding: 5px" >
                            <?php echo form_input(array('name' => 'input_add_sale_customer_id', 'id' => 'input_add_sale_customer_id', 'class' => 'form-control', 'type' => 'hidden')); ?>
                            <?php echo form_input(array('name' => 'input_add_sale_customer', 'id' => 'input_add_sale_customer', 'class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#modal_select_customer')); ?>
                        </td>
                        <td style="padding: 5px" >
                            <p>016123123123</p>
                        </td>
                        <td style="padding: 5px" >
                            <span>1000</span>
                        </td>
                        <td style="padding: 5px" >
                            <span>1</span>
                        </td>
                        <td style="padding: 5px" >
                            <span>2</span>
                        </td>
                        <td  style="padding: 5px" >
                              <span>30/sm</span>
                        </td>
                        <td style="padding: 5px" >
                            <input class="form-control input-width-table" id="Pieces" name="Pieces" type="text" value="100"/>
                        </td>
                        <td style="padding: 5px" >
                            <input class="form-control input-width-table" name="product_price" type="text" value="50"/>
                        </td>
                        <td style="padding: 5px" >
                            <input class="form-control input-width-table" name="sub_total" type="text" value="5000"/>
                        </td>
                        <td id="" style="padding: 5px" >
                          <?php echo form_dropdown('staff_list', array(''=>'Select')+$staff_list, '', 'class="form-control" id="staff_list"'); ?>
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



<script type="text/javascript">
    $('#delete_row_button_1').on('click', function() {
        $('#modal_delete_row_1').modal('show');
    });
</script>
