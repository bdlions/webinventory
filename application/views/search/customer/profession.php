<script type="text/javascript">
    $(function() {
        $("#button_search_customer").on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_customer_by_profession",
                data: {
                    profession_id: $("#profession_list").val()
                },
                success: function(data) {
                    $("#tbody_customer_list").html(tmpl("tmpl_customer_list", data));                    
                }
            });
        });
    });
</script>
<div class ="row form-background">
    <div class ="top-bottom-padding col-md-6">
        <div class ="row">
            <div class ="col-md-12 form-horizontal">
                <div class="row">
                    <div class ="col-md-6 margin-top-bottom">
                        <div class="form-group">
                            <label for="profession_list" class="col-md-6 control-label requiredField">
                                Select Profession
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_dropdown('profession_list', $profession_list + array('0' => 'All'), '', 'class="form-control" id="profession_list"'); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-6 control-label requiredField">

                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($button_search_customer + array('class' => 'form-control btn-success')); ?>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<h2>Search Result</h2>
<div class="row col-md-11 form-background">
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
            </tbody>
        </table>
    </div>
</div>