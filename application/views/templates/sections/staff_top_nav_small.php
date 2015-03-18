<div class="btn-group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        Sales<span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="<?php echo base_url("sale/sale_order");?>">add new sale</a></li>
        <li class="divider"></li>
        <li><a href="<?php echo base_url("./customer/create_institution");?>">add new institution</a></li>
        <li><a href="<?php echo base_url("./customer/create_profession");?>">add new profession</a></li>
        <li><a href="<?php echo base_url("./customer/create_customer");?>">add new customer </a></li>
        <li><a href="<?php echo base_url("./customer/show_all_customers/".PAGINATION_CUSTOMER_LIST_LIMIT);?>">Customer List</a></li>
    </ul>
</div>
<div class="btn-group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        Purchase<span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="<?php echo base_url("purchase/warehouse_purchase_order");?>">Add news purchase</a></li>
        <li><a href="<?php echo base_url("purchase/raise_warehouse_purchase_order");?>">Raise purchase</a></li>
        <li><a href="<?php echo base_url("purchase/return_warehouse_purchase_order");?>">Return purchase</a></li>
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
        <li><a href="<?php echo base_url("./product/create_product");?>">add new product</a></li>
        <li><a href="<?php echo base_url("./product/show_all_products");?>">Product List</a></li>
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
        <li><a href="<?php echo base_url("search/search_due_collect_date_range");?>">Search Due Collect by Date Range</a></li>
        <li><a href="<?php echo base_url("search/search_sales_purchase_order_no");?>">Search Customer Sales by Lot No</a></li>
        <li><a href="<?php echo base_url("search/search_customer_sales");?>">Search Customer Sales</a></li>
        <li><a href="<?php echo base_url("search/search_sales_customer_card_no");?>">Search Customer Sales by Card No</a></li>
        <li><a href="<?php echo base_url("search/search_sales_customer_name");?>">Search Customer Sales by Name</a></li>
        <li><a href="<?php echo base_url("search/search_sales_customer_phone");?>">Search Customer Sales by Phone</a></li>
        <li class="divider"></li>
        <li><a href="<?php echo base_url("search/search_customer_profession");?>">Search Customer by Profession</a></li>
        <li><a href="<?php echo base_url("search/search_customer_institution");?>">Search Customer by Institution</a></li>
        <li><a href="<?php echo base_url("search/search_customers_total_purchased");?>">Search Customer by Total Purchased</a></li>
        <li><a href="<?php echo base_url("search/search_customer_card_no");?>">Search Customer by Card No</a></li>
        <li><a href="<?php echo base_url("search/search_customer_phone");?>">Search Customer by Mobile No</a></li>
        <li><a href="<?php echo base_url("search/search_customer_card_no_range");?>">Search Customer by Card No Range</a></li>
        <li><a href="<?php echo base_url("search/search_customer_by_total_due");?>">Search Customer Due</a></li>
        <li class="divider"></li>
        <li><a href="<?php echo base_url("search/search_supplier_by_total_due");?>">Search Supplier Due</a></li>
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
        Notebook<span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu"> 
       <li><a href="<?php echo base_url("./message/update_custom_message");?>">Create/Update Message</a></li>
       <li><a href="<?php echo base_url("./message/view_custom_messages");?>">View Message</a></li>
    </ul>
</div>
<div class="btn-group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        Settings<span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="<?php echo base_url("./staff/create_staff");?>">Create Staff</a></li>
        <li><a href="<?php echo base_url("./staff/show_all_staffs");?>">Show All Staffs</a></li>
        <li><a href="<?php echo base_url("./salesman/create_salesman");?>">Create Equipment Supplier</a></li>
        <li><a href="<?php echo base_url("./salesman/show_all_salesmen");?>">Show All Equipment Suppliers</a></li>
        <li class="divider"></li>
        <li><a href="<?php echo base_url("./user/logout");?>">Logout</a></li>
    </ul>
</div>