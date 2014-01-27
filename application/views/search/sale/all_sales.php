<h2>Search Result</h2>
<div class="row form-background">
    <div class="row">
        <div class="col-md-1">Product Name</div>
        <div class="col-md-1">Lot No</div>
        <div class="col-md-1">Quantity</div>
        <div class="col-md-1">Purchase Unit Price</div>
        <div class="col-md-1">Sale Unit Price</div>
        <div class="col-md-1">Total Purchase Price</div>
        <div class="col-md-1">Discount(%)</div>
        <div class="col-md-1">Total Sale Price</div>
        <div class="col-md-1">Net Profit</div>
    </div>
    <div class="row" id="div_all_sale_list_result">
        <?php foreach($sale_list as $sale_info)
        {
        ?>
            <div class="row">
                <div class="col-md-1"><?php echo $sale_info['name'];?></div>
                <div class="col-md-1"><?php echo $sale_info['purchase_order_no'];?></div>
                <div class="col-md-1"><?php echo $sale_info['quantity'];?></div>
                <div class="col-md-1"><?php echo $sale_info['purchase_unit_price'];?></div>
                <div class="col-md-1"><?php echo $sale_info['sale_unit_price'];?></div>
                <div class="col-md-1"><?php echo $sale_info['quantity']*$sale_info['purchase_unit_price'];?></div>
                <div class="col-md-1"><?php echo $sale_info['discount'];?></div>
                <div class="col-md-1"><?php echo $sale_info['total_sale_price'];?></div>
                <div class="col-md-1"><?php echo ($sale_info['total_sale_price'] - ($sale_info['quantity']*$sale_info['purchase_unit_price']));?></div>
            </div>
        <?php    
        }
        ?>
    </div>
</div>