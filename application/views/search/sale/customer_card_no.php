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
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_sales_by_customer_card_no",
                data: {
                    card_no: $("#card_no").val(),
                    start_date: $("#start_date").val(),
                    end_date: $("#end_date").val()
                },
                success: function(data) {
                    var result = JSON.parse(data);
                    var result_list = result['sale_list'];
                    var div_search_description = '';
                    for (var counter = 0; counter < result_list.length; counter++)
                    {
                        var result_info = result_list[counter];
                        div_search_description += '<div class="row col-md-9">';
                        div_search_description += '<div class ="col-md-1">'+result_info['name']+'</div>';
                        div_search_description += '<div class ="col-md-1">'+result_info['purchase_order_no']+'</div>';
                        div_search_description += '<div class ="col-md-1">'+result_info['quantity']+'</div>';
                        div_search_description += '<div class ="col-md-1">'+result_info['purchase_unit_price']+'</div>';
                        div_search_description += '<div class ="col-md-1">'+result_info['sale_unit_price']+'</div>';
                        div_search_description += '<div class ="col-md-1">'+result_info['quantity']*result_info['purchase_unit_price']+'</div>';
                        div_search_description += '<div class ="col-md-1">'+result_info['discount']+'</div>';
                        div_search_description += '<div class ="col-md-1">'+result_info['total_sale_price']+'</div>';
                        div_search_description += '<div class ="col-md-1">'+(result_info['total_sale_price'] - (result_info['quantity']*result_info['purchase_unit_price']))+'</div>';
                        div_search_description += '</div>';
                    }
                    
                    $("#div_search_result").html(div_search_description);
                }
            });
        });
    });
</script>
<div class ="row form-background">
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
<h2>Search Result</h2>
<div class="row form-background">
    <div class="row col-md-9">
        <div class="col-md-1">Product Name</div>
        <div class="col-md-1">Lot No</div>
        <div class="col-md-1">Quantity</div>
        <div class="col-md-1">Purchase Unit Price</div>
        <div class="col-md-1">Sale Unit Price</div>
        <div class="col-md-1">Total Purchase Price</div>
        <div class="col-md-1">Discount(%)</div>
        <div class="col-md-1">Total Sale Price</div>
        <div class="col-md-1">Net Profit</div>
    </div>
    <div class="row col-md-12" id="div_search_result">
        
    </div>
</div>