<script>
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
        $("#button_search_due_collect").on("click", function() {
            $.ajax({
                dataType: 'json', 
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_due_collect_by_date_range",
                data: {
                    start_date: $("#start_date").val(),
                    end_date: $("#end_date").val()
                },
                success: function(data) {
                    $("#tbody_due_collect_list").html(tmpl("tmpl_due_collect_list", data.due_collect_list));
                }
            });
        });
        
    });
</script>
<script type="text/x-tmpl" id="tmpl_due_collect_list">
    {% var i=0, due_collect_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(due_collect_info){ %}
    <tr>
        <td>{%= due_collect_info.created_on %}</td>
        <td>{%= due_collect_info.first_name %}</td>
        <td>{%= due_collect_info.last_name %}</td>
        <?php if($shop_info['shop_type_id'] == SHOP_TYPE_SMALL){ ?>
        <td>{%= due_collect_info.card_no %}</td>
        <?php }?>
        <td>{%= due_collect_info.amount %}</td>
        <td><a onclick="open_modal_delete_due_collect_confirm({%= due_collect_info.id %})">Delete</a></td>
    </tr>
    {% due_collect_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<h3>Search Due Collect by Date Range</h3>
<div class ="form-background top-bottom-padding">
    <div class="row">
        <div class="col-md-6">
            <div class="row form-group">
                <label for="expense_categories" class="col-md-offset-1 col-md-2 control-label requiredField">
                    Start Date
                </label>
                <div class ="col-md-4">
                    <?php echo form_input($start_date+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="row form-group">
                <label for="item_list" class="col-md-offset-1 col-md-2 control-label requiredField">
                    End Date
                </label>
                <div class ="col-md-4">
                    <?php echo form_input($end_date+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="row form-group">
                <div class="col-md-offset-5 col-md-2">
                    <?php echo form_input($button_search_due_collect+array('class'=>'form-control btn-success')); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Time & Date</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <?php if($shop_info['shop_type_id'] == SHOP_TYPE_SMALL){ ?>
                    <th>Card No</th>
                    <?php }?>
                    <th>Amount</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody id="tbody_due_collect_list">
                
            </tbody>
        </table>
    </div>
</div>
<?php 
$this->load->view("search/due/due_collect_list_delete_confirm_modal");