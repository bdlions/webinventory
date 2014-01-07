<div class="container">
    <div class="col-12">
        <div class="home"><a class="home" style="float:left;" href="./index.php">Home</a></div>
        <div class="btn-toolbar">        
            <div class="btn-group general">
                <button class="btn btn-success dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">Genaral <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="#">Home Page</a></li>
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Get Started</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Import Data</a></li>
                    <li><a href="#">Export Data</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Backup Data</a></li>
                    <li><a href="#">Restore Data</a></li>
                    <li><a href="#">Reset All Data</a></li>
                </ul>
            </div> <!-- .btn-group -->
            <div class="btn-group sales">
                <button class="btn btn-success dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">Sales <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="#">New Sales Quote</a></li>
                    <li><a href="<?php echo base_url("sale/sale_order");?>">New Sales Order</a></li>
                    <li><a href="#">Sales Order List</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Recent Orders</a></li>
                    <li><a href="#">Open Orders</a></li>
                    <li><a href="#">Invoiced Orders</a></li>
                    <li><a href="<?php echo base_url("./Sales/paidOrders");?>">Paid Orders</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url("./Sales/newCustomer");?>">New Customer</a></li>
                    <li><a href="<?php echo base_url("./Sales/customerList");?>">Customer List</a></li>
                </ul>
            </div> <!-- .btn-group -->
            <div class="btn-group purchasing">
                <button class="btn btn-success dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">Purchasing <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url("purchase/purchase_order");?>">New Purchase Order</a></li>
                    <li><a href="#">Purchase Order List</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Recent Orders</a></li>
                    <li><a href="#">Open Orders</a></li>
                    <li><a href="#">Received Orders</a></li>
                    <li><a href="#">Paid Orders</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url("./Purchasing/newVendor");?>">New Vendor</a></li>
                    <li><a href="#">Vendor List</a></li>
                </ul>
            </div> <!-- .btn-group -->
            <div class="btn-group inventory">
                <button class="btn btn-success dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">Inventory <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url("./Inventory/newProduct");?>">New Product</a></li>
                    <li><a href="<?php echo base_url("./Inventory/productList");?>">Product List</a></li>
                    <li><a href="<?php echo base_url("./Inventory/productCategories");?>">Product Categories</a></li>
                    <li><a href="<?php echo base_url("./Inventory/productPricing");?>">Product Pricing</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url("stock/show_all_stocks");?>">Current Stock</a></li>
                    <li><a href="<?php echo base_url("./Inventory/movementHistory");?>">Movement History</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url("./Inventory/adjustStock");?>">Adjust Stock</a></li>
                    <li><a href="<?php echo base_url("./Inventory/countSheet");?>">Count Sheet</a></li>
                    <li><a href="<?php echo base_url("./Inventory/transferStock");?>">Transfer Stock</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url("./Inventory/reorderStock");?>">Reorder Stock</a></li>
                    <li><a href="<?php echo base_url("./Inventory/workOrder");?>">Work Order</a></li>
                </ul>
            </div> <!-- .btn-group -->
            <div class="btn-group">
                <button class="btn btn-success dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">Invoice <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url("./Invoice/newInvoice");?>">New Invoice..</a></li>
                    <li><a href="<?php echo base_url("./Invoice/applyPayment");?>">Apply Payment..</a></li>
                    <li><a href="<?php echo base_url("./Invoice/openInvoiceList");?>">Open Invoices List</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url("./Invoice/newQuote");?>">New Quote..</a></li>
                    <li><a href="<?php echo base_url("./Invoice/openQuotesList");?>">Open Quotes List</a></li>
                    <li><a href="#">New Order..</a></li>
                    <li><a href="#">Open Orders List</a></li>
                    <li><a href="#">New Credit Note..</a></li>
                    <li><a href="#">Open Credit Notes List</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url("./Invoice/addNewCustomer");?>">Add New Customer..</a></li>
                    <li><a href="<?php echo base_url("./Invoice/openCustomersList");?>">Open Customers List</a></li>
                    <li><a href="#">Add New Item..</a></li>
                    <li><a href="#">Open Items List</a></li>
                    <li><a href="<?php echo base_url("./Invoice/newCashTransaction");?>">New Cash Transaction</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Close</a></li>
                </ul>
            </div> <!-- .btn-group -->
            <div class="btn-group">
                <button class="btn btn-success dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">Reports <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="#">unpaid Accounts</a></li>
                    <li><a href="<?php echo base_url("./Reports/reportInvoice");?>">Invoices</a></li>
                    <li><a href="<?php echo base_url("./Reports/reportQuotes");?>">Quotes</a></li>
                    <li><a href="<?php echo base_url("./Reports/reportOrders");?>">Orders</a></li>
                    <li><a href="<?php echo base_url("./Reports/reportPayments");?>">payments</a></li>
                    <li><a href="<?php echo base_url("./Reports/reportSalesperson");?>">Salesperson</a></li>
                    <li><a href="<?php echo base_url("./Reports/reportItemSales");?>">Item Sales</a></li>
                    <li><a href="<?php echo base_url("./Reports/reportItemsPerCustomer");?>">Items Per Customer</a></li>
                    <li><a href="<?php echo base_url("./Reports/reportInventory");?>">Inventory</a></li>
                    <li><a href="<?php echo base_url("./Reports/reportCustomers");?>">Customers</a></li>
                    <li><a href="<?php echo base_url("./Reports/reportCustomerSales");?>">Customer Sales</a></li>
                    <li><a href="<?php echo base_url("./Reports/reportAging");?>">Aging Report</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Financial Reports
                            <ul class="sub-menu center">
                                <li><a href="">Optional</a></li>					
                                <li class="divider"></li>			
                                <li><a href="">Flash Report - Month to Date</a></li>
                                <li><a href="">Order gross Profit - prior month</a></li>
                                <li><a href="">Accountant Summary</a></li>					
                                <li class="divider"></li>			
                                <li><a href="">Audit (Security Issues, pricing Changes)</a></li>
                                <li><a href="">Cash paid Out</a></li>
                                <li><a href="">Coupon and discount Redemption Summary</a></li>
                                <li><a href="">Daily Order Detail</a></li>
                                <li><a href="">Daily Order Summary</a></li>
                                <li><a href="">Daily Sales Comparison</a></li>
                                <li><a href="">Discount Review with order detail</a></li>
                                <li><a href="">Driver Delivery Detail</a></li>
                                <li><a href="">Flash Report</a></li>
                                <li><a href="">Flash Report - Prior Month</a></li>
                                <li><a href="">Flash Report - Prior Year</a></li>
                                <li><a href="">Flash Report - Year to Date</a></li>
                                <li><a href="">Food Cost Analysis</a></li>
                                <li><a href="">Hourly Sales by day of Week</a></li>
                                <li><a href="">Labor Cost by Deparent</a></li>
                                <li><a href="">Order Gross Profit - Month to Date</a></li>
                                <li><a href="">Order Gross Profit - Prior Year</a></li>
                                <li><a href="">Order Gross Profit - Year to Date</a></li>
                                <li><a href="">Order Gross Profit Summary</a></li>
                                <li><a href="">Order List</a></li>
                                <li><a href="">Product Sales by Category</a></li>
                                <li><a href="">Revenue by Product Type</a></li>
                                <li><a href="">Revenue by Service Type</a></li>
                                <li><a href="">Sales Tax Collected</a></li>
                                <li><a href="">Sales by Product Category</a></li>
                                <li><a href="">Till and Bank Drop List</a></li>
                                <li><a href="">Till and Bank Over and Short</a></li>
                                <li><a href="">Till and Bank Reconciliation</a></li>
                                <li><a href="">Till and Bank Reconciliation List</a></li>
                                <li><a href="">Voided Order List</a></li>					
                            </ul>
                        </a></li>
                    <li class="divider"></li>			
                    <li><a href="#">Marketing Reports</a></li>
                    <li><a href="">Marketing and Advertising Analysis</a></li>					
                    <li><a href="">Repeat Customer Analysis</a></li>					
                    <li><a href="">New Customer List</a></li>								
                    <li class="divider"></li>						
                    <li><a href="">Optional</a></li>					
                    <li><a href="">Customer Email Export</a></li>					
                    <li><a href="">Customer List</a></li>					
                    <li><a href="">Customer Mailing Labels</a></li>					
                    <li><a href="">Customer Purchase History Detail</a></li>					
                    <li><a href="">Customer Source Analysis</a></li>					
                    <li><a href="">Customer Source Analysis (Sorted by Sales)</a></li>					
                    <li><a href="">Good Customer Labels</a></li>					
                    <li><a href="">Late Deliveries</a></li>					
                    <li><a href="">Lazy or Lost Customer List and Mailing Labels (30 days)</a></li>					
                    <li><a href="">Lazy or Lost Customer List and Mailing Labels (60 days)</a></li>					
                    <li><a href="">Lazy or Lost Customer List and Mailing Labels (90 days)</a></li>					
                    <li><a href="">Lazy or Lost Customer List and Mailing Labels (120 days)</a></li>					
                    <li><a href="#">New Customer Mailing Labels</a></li>
                    <li><a href="#">Product Buyers</a></li>
                    <li><a href="#">Product Sales Achievement by Staff</a></li>
                    <li><a href="#">Product Sales by Category</a></li>
                    <li><a href="#">Referral Type</a></li>
                    <li><a href="#">Top 50 Business Customers</a></li>
                    <li><a href="#">Top 50 Customers</a></li>
                    <li><a href="#">Top 50 Residential Customers</a></li>
                    <li class="divider"></li>			
                    <li><a href="#">Production Reports</a></li>
                    <li><a href="#">Hourly Sales by Day of Week (Detail)</a></li>			
                    <li><a href="#">Promised Delivery Time Analysis</a></li>			
                    <li><a href="#">Delivery Order List</a></li>			
                    <li><a href="#">Delivery Production by Staff Member</a></li>			
                    <li><a href="#">Delivery Time by Driver</a></li>			
                    <li><a href="#">Hourly Sales by Day of Week</a></li>			
                    <li><a href="#">Order Entry Production by Staff Member</a></li>			
                    <li><a href="#">Promised Delivery Time Analysis</a></li>			
                    <li><a href="#">Revenue by Server</a></li>			
                    <li class="divider"></li>			
                    <li><a href="#">General Reports</a></li>
                    <li><a href="#">Discounts Summary</a></li>
                    <li><a href="#">Order List</a></li>
                    <li><a href="#">Insurance Expiration (Driver)</a></li>
                    <li><a href="#">Next MVD (Motor Vehicle Division) Report</a></li>
                    <li><a href="#">Product List</a></li>
                    <li><a href="#">Staff Birthday List</a></li>
                    <li><a href="#">Staff List</a></li>
                    <li><a href="#">Staff Mailing Labels</a></li>
                    <li class="divider"></li>			
                </ul>
            </div> <!-- .btn-group -->
            <div class="btn-group">
                <button class="btn btn-success dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">View <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="#">Invoices</a></li>
                    <li><a href="#">Quotes</a></li>
                    <li><a href="#">Orders</a></li>
                    <li><a href="#">Customers</a></li>
                    <li><a href="#">payments</a></li>
                    <li><a href="#">Items</a></li>
                    <li><a href="#">Recurring Invoices</a></li>
                    <li><a href="#">Recurring Orders</a></li>
                    <li><a href="#">Credit Notes</a></li>
                    <li><a href="#">Salespeople</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Customize Toolbar</a></li>
                </ul>
            </div> <!-- .btn-group -->
            <div class="btn-group">
                <button class="btn btn-success dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">Tools <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url("./expense/add_expense");?>">Add Expenses</a></li>
                    <li><a href="<?php echo base_url("./expense/show_expense");?>">Show Expenses</a></li>
                    <li><a href="<?php echo base_url("./user/create_supplier");?>">Create Supplier</a></li>
                    <li><a href="<?php echo base_url("./user/create_customer");?>">Create Customer</a></li>
                    <li><a href="<?php echo base_url("./shop/create_shop");?>">Create Shop</a></li>
                    <li><a href="<?php echo base_url("./shop/show_all_shops");?>">Shop List</a></li>
                    <li><a href="<?php echo base_url("./product/create_product");?>">Create Product</a></li>
                    <li><a href="<?php echo base_url("./product/show_all_products");?>">Product List</a></li>
                    <li><a href="<?php echo base_url("./Tools/createUser");?>">Create User</a></li>
                    <li><a href="<?php echo base_url("./Tools/loginDetails");?>">login details</a></li>
                    <li><a href="<?php echo base_url("./Tools/signUp");?>">sign up</a></li>			
                    <li><a href="<?php echo base_url("./Tools/home");?>">Home Page</a></li>
                    <li><a href="<?php echo base_url("./user/logout");?>">Logout</a></li>
                </ul>
            </div> <!-- .btn-group -->        
        </div>
    </div>
</div>