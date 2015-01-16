<div class="btn-group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        Sales<span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="<?php echo base_url("sale/sale_order");?>">add new sale</a></li>
        <li><a href="<?php echo base_url("sale/return_sale_order");?>">return sale</a></li>
        <li><a href="<?php echo base_url("sale/delete_sale");?>">Delete Sale</a></li>
        <li class="divider"></li>
        <li><a href="<?php echo base_url("./customer/create_customer");?>">add new customer </a></li>
        <li><a href="<?php echo base_url("./customer/show_all_customers/".PAGINATION_CUSTOMER_LIST_LIMIT);?>">Customer List</a></li>
    </ul>
</div>
<div class="btn-group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        Purchase<span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="<?php echo base_url("purchase/purchase_order");?>">add new purchase</a></li>
        <li><a href="<?php echo base_url("purchase/raise_purchase_order");?>">Raise Purchase Order</a></li>
        <li><a href="<?php echo base_url("purchase/return_purchase_order");?>">Return Purchase Order</a></li>
        <li class="divider"></li>
        <li><a href="<?php echo base_url("./supplier/create_supplier");?>">add new supplier</a></li>
        <li><a href="<?php echo base_url("./supplier/show_all_suppliers/".PAGINATION_SUPPLIER_LIST_LIMIT);?>">Supplier List</a></li>
    </ul>
</div>
<div class="btn-group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        Manage Stock<span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="<?php echo base_url("product/create_product_unit_category");?>">create new product unit category</a></li>
        <li><a href="<?php echo base_url("./product/create_product");?>">add new product</a></li>
        <li><a href="<?php echo base_url("./product/show_all_products");?>">Product List</a></li>
        <li><a href="<?php echo base_url("./product/import_product");?>">Product List Import</a></li>
        <li class="divider"></li>
        <li><a href="<?php echo base_url("stock/show_all_stocks");?>">show current stock</a></li> 
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
        <li><a href="<?php echo base_url("search/daily_sales");?>">Daily Sales</a></li>
        <li><a href="<?php echo base_url("search/search_sales");?>">Search Sales</a></li>
        <li><a href="<?php echo base_url("search/search_sales_purchase_order_no");?>">Search Customer Sales by Lot No</a></li>
        <li><a href="<?php echo base_url("search/search_sales_customer_name");?>">Search Customer Sales by Name</a></li>
        <li><a href="<?php echo base_url("search/search_sales_customer_phone");?>">Search Customer Sales by Phone</a></li>
        <li class="divider"></li>
        <li><a href="<?php echo base_url("search/search_customers_total_purchased");?>">Search Customer by Total Purchased</a></li>
        <li><a href="<?php echo base_url("search/search_customer_phone");?>">Search Customer by Mobile No</a></li>        
    </ul>
</div>
<div class="btn-group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        Attendance<span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="<?php echo base_url("./attendance/store_attendance");?>">Store Attendance</a></li>
        <li><a href="<?php echo base_url("./attendance/show_attendance");?>">Show Attendance</a></li>
    </ul>
</div>
<div class="btn-group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        Tools<span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="<?php echo base_url("./upload/upload_cover");?>">Upload Cover</a></li>
        <li><a href="<?php echo base_url("./staff/create_staff");?>">Create Staff</a></li>
        <li><a href="<?php echo base_url("./staff/show_all_staffs");?>">Show All Staffs</a></li>
        <li><a href="<?php echo base_url("./salesman/create_salesman");?>">Create Equipment Supplier</a></li>
        <li><a href="<?php echo base_url("./salesman/show_all_salesmen");?>">Show All Equipment Suppliers</a></li>
        <li><a href="<?php echo base_url("./manager/create_manager");?>">Create Admin</a></li>
        <li><a href="<?php echo base_url("./manager/show_all_managers");?>">Show All Admins</a></li>
        <li class="divider"></li>
        <li><a href="<?php echo base_url("./user/logout");?>">Logout</a></li>        
    </ul>
</div>
<div class="btn-group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        Notebook<span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu"> 
       <li><a href="<?php echo base_url("./message/update_custom_message");?>">Create/Update Message</a></li>
       <li><a href="<?php echo base_url("./message/view_custom_messages");?>">View Message</a></li>
    </ul>
</div>