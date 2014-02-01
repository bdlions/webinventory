<script type="text/javascript">
    $(function() {
        $("#button_search_customer").on("click", function() {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_customer_by_card_no",
                data: {
                    card_no: $("#card_no").val()
                },
                success: function(data) {
                    var result = JSON.parse(data);
                    var customer_list = result['customer_list'];
                    var div_customer_list = '';
                    for (var counter = 0; counter < customer_list.length; counter++)
                    {
                        var customer_info = customer_list[counter];
                        div_customer_list += '<div class="row col-md-10">';
                        div_customer_list += '<div class ="col-md-2">'+customer_info['first_name']+'</div>';
                        div_customer_list += '<div class ="col-md-2">'+customer_info['last_name']+'</div>';
                        div_customer_list += '<div class ="col-md-2">'+customer_info['phone']+'</div>';
                        div_customer_list += '<div class ="col-md-2">'+customer_info['address']+'</div>';
                        div_customer_list += '<div class ="col-md-2">'+customer_info['card_no']+'</div>';
                        div_customer_list += '</div>';
                    }
                    
                    $("#div_customer_list_result").html(div_customer_list);
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
                            <label for="button_search_customer" class="col-md-6 control-label requiredField">

                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($button_search_customer+array('class'=>'form-control btn-success')); ?>
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
    <div class="row col-md-10">
        <div class="col-md-2">First Name</div>
        <div class="col-md-2">Last Name</div>
        <div class="col-md-2">Phone</div>
        <div class="col-md-2">Address</div>
        <div class="col-md-2">Card No</div>
    </div>
    <div class="row col-md-12" id="div_customer_list_result">
        
    </div>
</div>