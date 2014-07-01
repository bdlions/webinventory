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
<h3><?php echo $this->lang->line("search_search_customer_profession_search_customer_by_profession"); ?></h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="row">
        <div class ="col-md-6">
            <div class ="row">
                <div class ="col-md-12 form-horizontal">
                    <div class="row">
                        <div class ="col-md-6 margin-top-bottom">
                            <?php echo form_open("search/download_search_customer_by_profession", array('id' => 'form_download_search_customer_profession', 'class' => 'form-horizontal')); ?>
                            <div class="form-group">
                                <label for="profession_list" class="col-md-6 control-label requiredField">
                                    <?php echo $this->lang->line("search_search_customer_profession_select_profession"); ?>
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
                            <?php if($user_group['id'] != USER_GROUP_SALESMAN):?>
                            <div class="form-group">
                                <label for="button_download_customer" class="col-md-6 control-label requiredField">

                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_input($button_download_customer + array('class' => 'form-control btn-success')); ?>
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
<h3><?php echo $this->lang->line("search_search_customer_profession_search_result"); ?></h3>
<div class="form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><?php echo $this->lang->line("search_search_customer_profession_first_name"); ?></th>
                    <th><?php echo $this->lang->line("search_search_customer_profession_last_name"); ?></th>
                    <th><?php echo $this->lang->line("search_search_customer_profession_phone"); ?></th>
                    <th><?php echo $this->lang->line("search_search_customer_profession_address"); ?></th>
                    <th><?php echo $this->lang->line("search_search_customer_profession_card_no"); ?></th>
                </tr>
            </thead>
            <tbody id="tbody_customer_list">                
            
            </tbody>
        </table>
    </div>
</div>