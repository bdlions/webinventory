<script type="text/javascript">
    $(function(){
        $("#button_search_customer").on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_customers_by_total_purchased",
                data: {
                    total_purchased: $("#total_purchased").val()
                },
                success: function (data) {
                    $("#tbody_customer_list").html(tmpl("tmpl_customer_list", data['customer_list']));
                }
            });
        });
        
        $("#button_message_send").on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/send_sms_to_customers_by_total_purchased",
                data: {
                    message_title: $("#message_title").val(),
                    message_body: $("#message_body").val(),
                    total_purchased: $("#total_purchased").val()
                },
                success: function (data) {
                    //
                }
            });
        });
    });
    
    function get_char_count(limit)
    {
        var tarea = document.getElementById("message_body");
        var countDisplay = document.getElementById("char_count");
        var charcount = tarea.value.length;
        var countRemains = limit - charcount;
        countDisplay.innerHTML = "Total characters: " + charcount + ".&nbsp;&nbsp;&nbsp;  Remaining: " + countRemains;
    }
</script>
<script type="text/x-tmpl" id="tmpl_customer_list">
    {% var i=0, customer_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(customer_info){ %}
    <tr>
    <td ><?php echo '{%= customer_info.first_name%}'; ?></td>
    <td ><?php echo '{%= customer_info.last_name%}'; ?></td>
    <td ><?php echo '{%= customer_info.phone%}'; ?></td>
    <td ><?php echo '{%= customer_info.address%}'; ?></td>
<?php if ($shop_info['shop_type_id'] == SHOP_TYPE_SMALL): ?>
        <td ><?php echo '{%= customer_info.card_no%}'; ?></td>
<?php endif; ?>
    <td ><?php echo '<a href="'.base_url().'transaction/show_customer_transactions/{%= customer_info.customer_id%}">Show</a>';?></td>
    <td ><?php echo '{%= customer_info.account_status%}'; ?></td>
    </tr>
    {% customer_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<h3>Search Customer by Total Purchased</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="row">
        <div class ="col-md-6">
            <div class ="row">
                <div class ="col-md-12 form-horizontal">
                    <div class="row">
                        <div class ="col-md-10 margin-top-bottom">
                            <?php echo form_open("search/download_customer_info_by_total_purchase", array('id' => 'form_download_search_result', 'name' => 'form_download_search_result', 'class' => 'form-horizontal'));?>
                            <div class="form-group">
                                <label for="total_purchased" class="col-md-4 control-label requiredField">
                                    Total Purchased
                                </label>
                                <div class ="col-md-5">
                                    <?php echo form_input($total_purchased + array('class' => 'form-control')); ?>
                                </div>
                                <label for="button_search_customer" class="control-label requiredField"></label>
                                <div class ="col-md-3">
                                    <?php echo form_input($button_search_customer + array('class' => 'form-control btn-success')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="expense_categories" class="col-md-4 control-label requiredField">
                                    Select Type
                                </label>
                                <div class ="col-md-5">
                                    <?php
                                    $options = array(
                                        DOWNLOAD_CUSTOMER_BY_NAME_ID => 'Name',
                                        DOWNLOAD_CUSTOMER_BY_MOBILE_NO_ID => 'Mobile No',
                                        DOWNLOAD_CUSTOMER_BY_NAME_MOBILE_NO_ID => 'Both'
                                    );

                                    echo form_dropdown('select_option_for_download', $options, 'both', 'class="form-control" id="select_option_for_download"');
                                    ?>
                                </div>
                                <label for="button_download_customer" class="control-label requiredField">

                                </label>
                                <div class ="col-md-3">
                                    <?php echo form_input($button_download_customer + array('class' => 'form-control btn-success')); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class ="col-md-offset-2 col-md-2">
                                    <a onclick="open_modal_active_confirm()">Active all</a>
                                </div>
                                <div class="col-md-3">
                                    <a onclick="open_modal_inactive_confirm()">Inactive all</a>
                                </div>
                            </div>
                            <?php echo form_close();?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <?php echo form_open("customer/send_custom_sms", array('id' => 'form_create_message_customers_total_purchased', 'class' => 'form-horizontal')); ?>
            <div class="row form-group">
                <label class="col-md-2">SMS Title:</label>
                <div class="col-md-8">
                    <?php echo form_input($message_title + array('class' => 'form-control')); ?>
                </div>
            </div>
            <div class="row form-group">
                <label class="col-md-2">SMS Body:</label>
                <div class="col-md-8">
                    <textarea name="message_body" id="message_body" rows="5" onkeyup="get_char_count(160)" class="form-control" style="resize: vertical"/></textarea>
                </div>
            </div>
            <div class="row form-group">
                <label class="col-md-offset-2 col-md-6" id="char_count"></label>
                <div class="col-md-2">
                    <?php echo form_input($button_message_send + array('class' => 'form-control btn-success')); ?>
                </div>
            </div>
            <?php echo form_close(); ?>
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
                    <?php if ($shop_info['shop_type_id'] == SHOP_TYPE_SMALL): ?><th>Card No</th><?php endif; ?>
                    <th>Transactions</th>
                    <th>Status </th>
                </tr>
            </thead>
            <tbody id="tbody_customer_list">                

            </tbody>
        </table>
    </div>
</div>
<?php $this->load->view("search/customer/active_status_confirmation_modal"); ?>
<?php $this->load->view("search/customer/inactive_status_confirmation_modal"); ?>