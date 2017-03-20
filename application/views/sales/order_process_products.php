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
                        <th style="padding: 18px">
                            Lot No <br>
                          <input name="all_sale_order_no" id="all_sale_order_no" class="form-control">
                        </th>                    
                         <th style="padding: 18px">
                            Sub Lot No <br>
                              <select name="all_purchase_sub_order_no" id="all_purchase_sub_order_no" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </th>            
                        <th style="padding: 18px">
                            Size <br>
                         <select name="all_sale_order_product_size" id="all_sale_order_product_size" class="form-control">
                                <option value="lg">lg</option>
                                <option value="xl">xl</option>
                                <option value="sm">sm</option>
                            </select>
                        </th>                    
                        <th style="padding: 18px">Pieces</th>                    
                        <th style="padding: 18px">Unit Price</th>
                        <th style="padding: 18px">Sub Total</th>
                        <th style="padding: 18px">Staff</th>
                        <th style="padding: 18px">Delete</th>
                    </tr>
                </thead>
                <tbody >        
                    <tr id="daily_sale_row_1" style="display: none;">
                        <td style="padding: 3px" >
                             <?php echo form_input(array('name' => 'input_add_sale_product', 'id' => 'input_add_purchase_product', 'class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#common_modal_select_product')); ?>
                        </td>
                        <td style="padding: 3px" >
                            <?php echo form_input(array('name' => 'input_add_sale_customer_id', 'id' => 'input_add_sale_customer_id', 'class' => 'form-control', 'type' => 'hidden')); ?>
                            <?php echo form_input(array('name' => 'input_add_sale_customer', 'id' => 'input_add_sale_customer', 'class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#modal_select_customer')); ?>
                        </td>
                        <td style="padding: 3px" >
                            <p style="margin-top: 8px;">016123123123</p>
                        </td>
                        <td style="padding: 3px" >
                            <p style="margin-top: 8px;">100</p>
                        </td>
                        <td style="padding: 3px" >
                            <input name="sale_order_no" id="sale_order_no" class="form-control">
                        </td>
                        <td style="padding: 3px" >
                             <select name="sale_sub_order_no" id="sale_sub_order_no" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </td>
                        <td  style="padding: 3px" >
                              <select name="sale_order_product_size" id="sale_order_product_size" class="form-control">
                                <option value="lg">lg</option>
                                <option value="xl">xl</option>
                                <option value="sm">sm</option>
                            </select>
                        </td>
                        <td style="padding: 3px" >
                            <input class="form-control input-width-table" id="Pieces" name="Pieces" type="text" value="100"/>
                        </td>
                        <td style="padding: 3px" >
                            <input class="form-control input-width-table" name="product_price" type="text" value="50"/>
                        </td>
                        <td style="padding: 3px" >
                            <input class="form-control input-width-table" name="sub_total" type="text" value="5000"/>
                        </td>
                        <td id="" style="padding: 3px" >
                          <?php echo form_dropdown('staff_list', array(''=>'Select')+$staff_list, '', 'class="form-control" id="staff_list"'); ?>
                        </td>
                        <td id="" style="padding: 3px" >
                            <button onclick="delete_row_button_1" id="delete_row_button_1" name="delete_product_1"  class="glyphicon glyphicon-trash"></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $this->load->view("sales/modal_delete_daily_sale_row"); ?>
<script type="text/javascript">
    $('#delete_row_button_1').on('click', function() {
        $('#modal_daily_sale_delete_row').modal('show');
    });
     $('#modal_ok_click_id').on('click', function() {
        $('#modal_daily_sale_delete_row').modal('hide');
        $('#daily_sale_row_1').hide();
    });
</script>