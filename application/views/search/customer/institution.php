<script type="text/javascript">
    $(function() {
        $("#button_search_customer").on("click", function() {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_customer_by_institution",
                data: {
                    institution_id: $("#institution_list").val()
                },
                success: function(data) {
                    var result = JSON.parse(data);
                    var institution_list = result['institution_list'];
                    var div_customer_list = '';
                    for (var counter = 0; counter < institution_list.length; counter++)
                    {
                        var institution_info = institution_list[counter];
                        div_customer_list += '<div class="row col-md-10">';
                        div_customer_list += '<div class ="col-md-2">'+institution_info['first_name']+'</div>';
                        div_customer_list += '<div class ="col-md-2">'+institution_info['last_name']+'</div>';
                        div_customer_list += '<div class ="col-md-2">'+institution_info['phone']+'</div>';
                        div_customer_list += '<div class ="col-md-2">'+institution_info['address']+'</div>';
                        div_customer_list += '<div class ="col-md-2">'+institution_info['card_no']+'</div>';
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
                            <label for="institution_list" class="col-md-6 control-label requiredField">
                                Select Institution
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_dropdown('institution_list', $institution_list+ array('0' => 'All'), '','class="form-control" id="institution_list"'); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-6 control-label requiredField">

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