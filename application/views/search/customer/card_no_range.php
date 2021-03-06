<script type="text/javascript">
    $(function() {
        $("#button_search_customer").on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_customer_by_card_no_range",
                data: {
                    start_card_no: $("#start_card_no").val(),
                    end_card_no: $("#end_card_no").val()
                },
                success: function(data) {
                    $("#tbody_customer_list").html(tmpl("tmpl_customer_list", data['customer_list']));   
                }
            });
            return false;
        });
    });
</script>
<script type="text/x-tmpl" id="tmpl_customer_list">
    {% var i=0, customer_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(customer_info){ %}
    <tr>
    <td ><?php echo '{%= customer_info.first_name%}'; ?></td>
    <td ><?php echo '{%= customer_info.last_name%}'; ?></td>
    <td ><?php echo '{%= customer_info.phone%}'; ?></td>
    <td ><?php echo '{%= customer_info.address%}'; ?></td>
    <td ><?php echo '{%= customer_info.card_no%}'; ?></td>
    </tr>
    {% customer_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<h3>Search Customer by Card Range</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="row">
        <div class ="col-md-6">
            <div class ="row">
                <div class ="col-md-12 form-horizontal">
                    <div class="row">
                        <?php echo form_open("search/download_search_customer_by_card_no_range", array('id' => 'form_download_search_customer_by_card_no_range', 'class' => 'form-horizontal')); ?>
                        <div class ="col-md-6 margin-top-bottom">
                            <div class="form-group">
                                <label for="start_card_no" class="col-md-6 control-label requiredField">
                                    Start Card No
                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_input($start_card_no+array('class'=>'form-control')); ?>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label for="end_card_no" class="col-md-6 control-label requiredField">
                                    Start Card No
                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_input($end_card_no+array('class'=>'form-control')); ?>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label for="button_search_customer" class="col-md-6 control-label requiredField">

                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_input($button_search_customer+array('class'=>'form-control btn-success')); ?>
                                </div> 
                            </div>
                            <?php if($user_group['id'] != USER_GROUP_SALESMAN):?>
                            <div class="form-group">
                                <label for="button_download_customer" class="col-md-6 control-label requiredField">

                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_input($button_download_customer+array('class'=>'form-control btn-success')); ?>
                                </div> 
                            </div>
                            <?php endif;?>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
<h3>Search Result</h3>
<div class="form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Card No</th>
                </tr>
            </thead>
            <tbody id="tbody_customer_list">                
            
            </tbody>
        </table>
    </div>
</div>