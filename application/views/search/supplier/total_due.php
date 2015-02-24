<script type="text/javascript">
    $(function()
    {
        $("#button_search_supplier_due").on("click", function() {
            waitScreen.show();
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_supplier_by_total_due",
                data: {
                    search_category_name: $("#dropdown_search_supplier").val(),
                    search_category_value: $("#input_search_value").val()
                },
                success: function(data) {
                    $("#label_total_due").html(data['total_due']);
                    $("#tbody_supplier_list").html(tmpl("tmpl_supplier_list", data['supplier_list']));                                   
                    waitScreen.hide();
                }
            });
        }); 
    });
</script>
<script type="text/x-tmpl" id="tmpl_supplier_list">
    {% var i=0, supplier_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(supplier_info){ %}
    <tr>
    <td ><?php echo '{%= supplier_info.first_name%}'; ?></td>
    <td ><?php echo '{%= supplier_info.last_name%}'; ?></td>
    <td ><?php echo '{%= supplier_info.phone%}'; ?></td>
        <td ><?php echo '{%= supplier_info.company%}'; ?></td>
    <td ><?php echo '{%= supplier_info.due%}'; ?></td>
    <td ><?php echo '<a href="'.base_url().'transaction/show_supplier_transactions/{%= supplier_info.supplier_id%}">Show</a>';?></td>
    </tr>
    {% supplier_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<h3>Search Supplier by Total Due</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="row" style="margin-top: 5px;">
        <div class="col-md-offset-1 col-md-5">
            <div class="row form-group">
                <div class ="col-md-6">
                    <label>Search Supplier by Total Due:</label>
                </div>
                <div class ="col-md-6">
                    <?php echo form_dropdown('dropdown_search_supplier', $supplier_search_category, '0', 'id="dropdown_search_supplier" class="form-control"'); ?>
                </div>
                <div class ="col-md-7"></div>
            </div>
            <div class="row form-group">
                <div class ="col-md-offset-6 col-md-6">
                    <input id="input_search_value" name="input_search_value" class="form-control">
                </div>
            </div>
            <div class="row form-group">
                <div class ="col-md-offset-8 col-md-4">
                    <input id="button_search_supplier_due" class="form-control btn-success" type="reset" value="Search" name="button_search_supplier_due">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row form-group">
                <div class ="col-md-offset-3 col-md-3">
                    <label>Total Due:</label>
                </div>
                <div class ="col-md-6">
                    <label id="label_total_due" name="label_total_due"></label>
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
                    <th>Company</th>
                    <th>Total Due</th>
                    <th>Transactions</th>
                </tr>
            </thead>
            <tbody id="tbody_supplier_list">                
            
            </tbody>
        </table>
    </div>
</div>
<?php $this->load->view('common/wait_screen');