<script type="text/javascript">
    $(function() {
        $('#start_date').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#start_date').text($('#start_date').data('date'));
            $('#start_date').datepicker('hide');
        });
        $('#end_date').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#end_date').text($('#end_date').data('date'));
            $('#end_date').datepicker('hide');
        });
        $("#button_search_sale").on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_sales_by_customer_card_no",
                data: {
                    card_no: $("#card_no").val(),
                    start_date: $("#start_date").val(),
                    end_date: $("#end_date").val()
                },
                success: function(data) {
                    $("#tbody_customer_sale_list").html(tmpl("tmpl_customer_sale_list", data['sale_list']));
                }
            });
        });
    });
</script>
<script type="text/x-tmpl" id="tmpl_customer_sale_list">
    {% var i=0, sale_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(sale_info){ %}
    <tr>
    <td ><?php echo '{%= sale_info.sale_order_no%}'; ?></td>
    <td ><?php echo '{%= sale_info.name%}'; ?></td>
    <td ><?php echo '{%= sale_info.purchase_order_no%}'; ?></td>
    <td ><?php echo '{%= sale_info.quantity%}'; ?></td>
    <td ><?php echo '{%= sale_info.purchase_unit_price%}'; ?></td>
    <td ><?php echo '{%= sale_info.sale_unit_price%}'; ?></td>
    <td ><?php echo '{%= sale_info.quantity*sale_info.purchase_unit_price%}'; ?></td>
    <td ><?php echo '{%= sale_info.total_sale_price%}'; ?></td>
    <td ><?php echo '{%= sale_info.total_sale_price-(sale_info.quantity*sale_info.purchase_unit_price)%}'; ?></td>
    </tr>
    {% sale_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<h3>Search Customer sale by Card No</h3>
<div class ="row form-horizontal form-background top-bottom-padding">
    <div class ="col-md-6">
        <div class ="row">
            <div class ="col-md-12 form-horizontal">
                <div class="row">
                    <div class ="col-md-6 margin-top-bottom">
                        <div class="form-group">
                            <label for="card_no" class="col-md-6 control-label requiredField">
                                Card No
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($card_no+array('class'=>'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="button_search_sale" class="col-md-6 control-label requiredField">

                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($button_search_sale+array('class'=>'form-control btn-success')); ?>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <div class ="col-md-6">
        <div class ="row">
            <div class ="col-md-12 form-horizontal">
                <div class="row">
                    <div class ="col-md-6 margin-top-bottom">
                        <div class="form-group">
                            <label for="start_date" class="col-md-6 control-label requiredField">
                                Start Date
                            </label>
                            <div class ="col-md-6">
                               <?php echo form_input($start_date+array('class'=>'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="end_date" class="col-md-6 control-label requiredField">
                                End Date
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($end_date+array('class'=>'form-control')); ?>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<h3>Search Result</h3>
<div class="row form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sale Id</th>
                    <th>Product Name</th>
                    <th>Lot No</th>
                    <th>Quantity</th>
                    <th>Purchase Unit Price</th>
                    <th>Sale Unit Price</th>
                    <th>Total Purchase Price</th>
                    <th>Total Sale Price</th>
                    <th>Net Profit</th>
                </tr>
            </thead>
            <tbody id="tbody_customer_sale_list">                
            
            </tbody>
        </table>
    </div>
</div>