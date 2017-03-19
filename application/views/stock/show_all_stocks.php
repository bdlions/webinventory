<script type="text/javascript">
    $(function() {
        $("#button_search_stock").on("click", function() {
            var product_id = $("#product_list").val();
            var purchase_order_no = $("#input_lot_no").val();
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "stock/search_stock",
                data: {
                    product_id: product_id,
                    purchase_order_no: purchase_order_no
                },
                success: function(data) {
                    $("#tbody_stock_list").html(tmpl("tmpl_stock_list", data['stock_list']));
                    $("#total_quantity").html(data['total_quantity'] + ' pieces');
                    $("#total_stock_value").html(data['total_stock_value']);
                }
            });
        });
    });
</script>
<script type="text/x-tmpl" id="tmpl_stock_list">
    {% var i=0, stock_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(stock_info){ %}
    <tr>
    <td>{%= stock_info.first_name %} {%= stock_info.last_name %}</td>
    <td>{%= stock_info.product_name %}</td>
    <td>{%= stock_info.purchase_order_no %}</td>
    <td>1</td>
    <td>sm</td>
    <td>{%= stock_info.current_stock %}</td>
    <td>{%= stock_info.unit_category %}</td>
    <td>{%= stock_info.unit_price %}</td>
    <td>{%= stock_info.current_stock*stock_info.unit_price %}</td>
    </tr>
    {% stock_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<h3>Stock Information</h3>
<div class="form-horizontal form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>
                        <div class="form-group">
                            <label for="" class="col-md-6 control-label">Select Product</label>
                            <div class="col-md-6">
                                <?php echo form_dropdown('product_list', $product_list + array('0' => 'All'), '0', 'class="form-control" id="product_list"'); ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <label>
                            Total Quantity:
                        </label>
                        <label id="total_quantity">
                            <?php echo $total_quantity . ' pieces'; ?>
                        </label>
                    </td>
                    <td>
                        <label>
                            Total Stock Value:
                        </label>
                        <label id="total_stock_value">
                            <?php echo $total_stock_value; ?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <label for="input_lot_no" class="col-md-6 control-label">Lot No</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="input_lot_no" name="input_lot_no">
                            </div>
                        </div>
                    </td>
                    <td>  
                        <div class="form-group">
                            <label for="select_sub_lot_no" class="col-md-4 control-label requiredField">
                                Sub Lot No
                            </label>
                            <div class ="col-md-8">
                                <select name="select_sub_lot_no" id="select_sub_lot_no" class="form-control">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div> 
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <label for="select_product_size" class="col-md-4 control-label requiredField">
                                Size
                            </label>
                            <div class ="col-md-8">
                                <select name="select_product_size" id="select_product_size" class="form-control">
                                    <option value="lg">lg</option>
                                    <option value="xl">xl</option>
                                    <option value="sm">sm</option>
                                </select>
                            </div> 
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="button" id="button_search_stock" name="button_search_stock" class="btn btn-success pull-right">Search</button>
                            </div>
                        </div>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>    
</div>
<div class ="form-background">    
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Supplier Name</th>
                    <th>Product Name</th>
                    <th>Lot No</th>
                    <th>Sub Lot No</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Product Unit</th>
                    <th>Purchase Unit Price</th>
                    <th>Total Purchase Price</th>

                </tr>
            </thead>
            <tbody id="tbody_stock_list">
                <?php
                foreach ($stock_list as $key => $stock_info) {
                    ?>
                    <tr>
                        <td><?php echo $stock_info['first_name'] . ' ' . $stock_info['last_name'] ?></td>
                        <td><?php echo $stock_info['product_name'] ?></td>
                        <td><?php echo $stock_info['purchase_order_no'] ?></td>
                        <td>1</td>
                        <td>xl</td>
                        <td><?php echo $stock_info['current_stock'] ?></td>
                        <td><?php echo $stock_info['unit_category'] ?></td>
                        <td><?php echo $stock_info['unit_price'] ?></td>
                        <td><?php echo $stock_info['current_stock'] * $stock_info['unit_price'] ?></td>

                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>     
</div>