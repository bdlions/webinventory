<script type="text/javascript">
    $(function(){
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
                    $("#total_quantity").html(data['total_quantity']+' pieces');
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
                        <label for="" class="col-md-6 control-label">
                            <?php echo $this->lang->line("stock_stock_show_all_stocks_select_product"); ?>
                        </label>
                        <div class="col-md-6">
                          <?php echo form_dropdown('product_list', $product_list+array('0' => 'All'), '0','class="form-control" id="product_list"'); ?>
                        </div>
                      </div>
                    </td>
                    <td>
                        <label>
                            <?php echo $this->lang->line("stock_stock_show_all_stocks_total_questity"); ?>:
                        </label>
                        <label id="total_quantity">
                            <?php echo $total_quantity.' pieces';?>
                        </label>
                    </td>
                    <td>
                        <label>
                            <?php echo $this->lang->line("stock_stock_show_all_stocks_total_tock_value"); ?>:
                        </label>
                        <label id="total_stock_value">
                            <?php echo $total_stock_value;?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <label for="input_lot_no" class="col-md-6 control-label">
                                <?php echo $this->lang->line("stock_stock_show_all_stocks_lot_no"); ?>
                            </label>
                            <div class="col-md-6">
                              <input type="text" class="form-control" id="input_lot_no" name="input_lot_no">
                            </div>
                        </div>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                          <div class="col-md-12">
                            <button type="button" id="button_search_stock" name="button_search_stock" class="btn btn-success pull-right">
                                <?php echo $this->lang->line("stock_stock_show_all_stocks_search"); ?>
                            </button>
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
                    <th><?php echo $this->lang->line("stock_stock_show_all_stocks_supplier_name"); ?></th>
                    <th><?php echo $this->lang->line("stock_stock_show_all_stocks_product_name"); ?></th>
                    <th><?php echo $this->lang->line("stock_stock_show_all_stocks_lot_no"); ?></th>
                    <th><?php echo $this->lang->line("stock_stock_show_all_stocks_quentity"); ?></th>
                    <th><?php echo $this->lang->line("stock_stock_show_all_stocks_product_unit"); ?></th>
                    <th><?php echo $this->lang->line("stock_stock_show_all_stocks_purchase_unit_price"); ?></th>
                    <th><?php echo $this->lang->line("stock_stock_show_all_stocks_total_purchase_price"); ?></th>

                </tr>
            </thead>
            <tbody id="tbody_stock_list">
                <?php
                foreach ($stock_list as $key => $stock_info) {
                ?>
                    <tr>
                        <td><?php echo $stock_info['first_name'].' '.$stock_info['last_name'] ?></td>
                        <td><?php echo $stock_info['product_name'] ?></td>
                        <td><?php echo $stock_info['purchase_order_no'] ?></td>
                        <td><?php echo $stock_info['current_stock'] ?></td>
                        <td><?php echo $stock_info['unit_category'] ?></td>
                        <td><?php echo $stock_info['unit_price'] ?></td>
                        <td><?php echo $stock_info['current_stock']*$stock_info['unit_price'] ?></td>

                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>     
</div>