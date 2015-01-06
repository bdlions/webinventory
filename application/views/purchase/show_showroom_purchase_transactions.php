<script type="text/javascript">
    $(function() {
        
    });
</script>
<h3>Search Purchase Transactions</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="row">
        <div class ="col-md-6">
            <div class ="row">
                <div class ="col-md-12 form-horizontal">
                    <div class="row">
                        <div class ="col-md-6 margin-top-bottom">
                            <?php echo form_open("purchase/show_showroom_purchase_transactions", array('id' => 'form_download_search_customer_by_card_no', 'class' => 'form-horizontal')); ?>
                            <div class="form-group">
                                <label for="card_no" class="col-md-6 control-label requiredField">
                                    Lot No
                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_input($lot_no+array('class'=>'form-control')); ?>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label for="button_search_customer" class="col-md-6 control-label requiredField">

                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_input($button_search_transactions+array('class'=>'form-control btn-success')); ?>
                                </div> 
                            </div>
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
                    <th>Date</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody id="tbody_customer_list">                
                <tr>
                    <th>04-01-2014 10:00AM</th>
                    <th>tshirt</th>
                    <th>100</th>
                    <th>300</th>
                    <th>Stock In</th>
                    <th>Stock is added</th>
                </tr>
                <tr>
                    <th>04-01-2014 11:00AM</th>
                    <th>tshirt</th>
                    <th>10</th>
                    <th>300</th>
                    <th>Stock Updated</th>
                    <th>Stock is updated</th>
                </tr>
                <tr>
                    <th>04-01-2014 11:30AM</th>
                    <th>tshirt</th>
                    <th>5</th>
                    <th>300</th>
                    <th>Stock Return</th>
                    <th>Stock is returned</th>
                </tr>
            </tbody>
        </table>
    </div>
</div>