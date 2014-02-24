<div class="btn-group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        Shop<span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="<?php echo base_url("./shop/set_shop");?>">Change Shop</a></li>
        <li><a href="<?php echo base_url("./shop/create_shop");?>">Create Shop</a></li>
        <li><a href="<?php echo base_url("./shop/show_all_shops");?>">Shop List</a></li>  
    </ul>
</div><div class="btn-group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        Sales<span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="<?php echo base_url("sale/sale_order");?>">New Sales Order</a></li>
        <li class="divider"></li>
        <li><a href="<?php echo base_url("./user/create_customer");?>">New Customer</a></li>
        <li><a href="<?php echo base_url("./user/show_all_customers");?>">Customer List</a></li>
    </ul>
</div>
<div class="btn-group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        Purchase<span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="<?php echo base_url("purchase/purchase_order");?>">New Purchase Order</a></li>
        <li class="divider"></li>
        <li><a href="<?php echo base_url("./user/create_supplier");?>">New Supplier</a></li>
        <li><a href="<?php echo base_url("./user/show_all_suppliers");?>">Supplier List</a></li>
    </ul>
</div>
<div class="btn-group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        Inventory<span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="<?php echo base_url("./product/create_product");?>">New Product</a></li>
        <li><a href="<?php echo base_url("./product/show_all_products");?>">Product List</a></li>
        <li class="divider"></li>
        <li><a href="<?php echo base_url("stock/show_all_stocks");?>">Current Stock</a></li> 
    </ul>
</div>
<div class="btn-group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        Expnese<span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="<?php echo base_url("./expense/add_expense");?>">Add Expenses</a></li>
        <li><a href="<?php echo base_url("./expense/show_expense");?>">Show Expenses</a></li> 
    </ul>
</div>
<div class="btn-group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        Reports<span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="<?php echo base_url("search/all_sales");?>">All Sales</a></li>
        <li><a href="<?php echo base_url("search/search_sales");?>">Search Sales</a></li>
        <li><a href="<?php echo base_url("search/search_sales_customer_card_no");?>">Search Customer Sales by Card No</a></li>
        <li class="divider"></li>
        <li><a href="<?php echo base_url("search/search_customer_profession");?>">Search Customer by Profession</a></li>
        <li><a href="<?php echo base_url("search/search_customer_institution");?>">Search Customer by Institution</a></li>
        <li><a href="<?php echo base_url("search/search_customer_card_no");?>">Search Customer by Card No</a></li>
        <li><a href="<?php echo base_url("search/search_customer_phone");?>">Search Customer by Mobile No</a></li>
        <li><a href="<?php echo base_url("search/search_customer_card_no_range");?>">Search Customer by Card No Range</a></li>
    </ul>
</div>
<div class="btn-group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        Tools<span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="<?php echo base_url("./user/create_salesman");?>">Create Staff</a></li>
        <li><a href="<?php echo base_url("./user/show_all_salesman");?>">Show All Staffs</a></li>
        <li><a href="<?php echo base_url("./user/create_manager");?>">Create Manager</a></li>
        <li><a href="<?php echo base_url("./user/show_all_managers");?>">Show All Managers</a></li>
        <li><a href="<?php echo base_url("./user/logout");?>">Logout</a></li> 
    </ul>
</div>
<div class="btn-group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        SMS<span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="<?php echo base_url("./sms/sms_configuration_shop");?>">Configure SMS</a></li>
        <li><a href="<?php echo base_url("./operator/create_operator");?>">Create Operator</a></li>
        <li><a href="<?php echo base_url("./operator/show_all_operators");?>">Show All Operators</a></li>
        <li><a href="<?php echo base_url("./sms/upload_file");?>">Process File</a></li>
        <li><a href="<?php echo base_url("./user/logout");?>">Logout</a></li> 
    </ul>
</div>