<script type="text/javascript">
    $(function()
    {
        $("#button_search_customer").on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_customer_by_total_due",
                data: {
                    search_category_name: $("#dropdown_search_customer").val(),
                    search_category_value: $("#input_search_value").val()
                },
                success: function(data) {
                                   
                }
            });
        }); 
    });
</script>
<h3>Search Customer by Total Due</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="row form-group">
        <div class ="col-md-offset-1 col-md-2">
            <label style="margin-top: 5px;">Search Customer by Total Due:</label>
        </div>
        <div class ="col-md-2">
            <?php echo form_dropdown('dropdown_search_customer', $customer_search_category, '0', 'id="dropdown_search_customer" class="form-control"'); ?>
        </div>
        <div class ="col-md-7"></div>
    </div>
    <div class="row form-group">
        <div class ="col-md-offset-3 col-md-2">
            <input id="input_search_value" name="input_search_value" class="form-control">
        </div>
        <div class ="col-md-7"></div>
    </div>
    <div class="row form-group">
        <div class ="col-md-offset-3 col-md-2">
            <input id="button_search_customer" class="form-control btn-success" type="reset" value="Search" name="button_search_customer_due">
        </div>
        <div class ="col-md-7"></div>
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
                    <th>Name</th>
                    <th>Date</th>
                    <th>Mobile No</th>
                    <th>Card No</th>
                    <th>Total Due</th>
                </tr>
            </thead>
            <tbody id="tbody_customer_list">                
            
            </tbody>
        </table>
    </div>
</div>