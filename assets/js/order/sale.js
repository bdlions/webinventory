function Sale()
{
    var sale_order_no; 
    var purchase_order_no;
    var product_category1;
    var product_size;
    var customer_id;
    var remarks;
    var created_by;
    var total;
    var cash_paid;
    var check_paid;
    var check_description;
    var previous_due;
    var current_due;    
    Sale.prototype.setOrderNo = function(value)
    {
        this.sale_order_no = value;
    }
    Sale.prototype.getOrderNo = function()
    {
        return this.sale_order_no;
    }
    Sale.prototype.setPurchaseOrderNo = function(value)
    {
        this.purchase_order_no = value;
    }
    Sale.prototype.getPurchaseOrderNo = function()
    {
        return this.purchase_order_no;
    }
    Sale.prototype.setProductCategory1 = function(value)
    {
        this.product_category1 = value;
    }
    Sale.prototype.getProductCategory1 = function()
    {
        return this.product_category1;
    }
    Sale.prototype.setProductSize = function(value)
    {
        this.product_size = value;
    }
    Sale.prototype.getProductSize = function()
    {
        return this.product_size;
    }
    Sale.prototype.setCustomerId = function(value)
    {
        this.customer_id = value;
    }
    Sale.prototype.getCustomerId = function()
    {
        return this.customer_id;
    }
    Sale.prototype.setRemarks = function(value)
    {
        this.remarks = value;
    }
    Sale.prototype.getRemarks = function()
    {
        return this.remarks;
    }
    Sale.prototype.setCreatedBy= function(value)
    {
        this.created_by = value;
    }
    Sale.prototype.getCreatedBy = function()
    {
        return this.created_by;
    }
    Sale.prototype.setTotal = function(value)
    {
        this.total = value;
    }
    Sale.prototype.getTotal = function()
    {
        return this.total;
    }
    Sale.prototype.setCashPaid = function(value)
    {
        this.cash_paid = value;
    }
    Sale.prototype.getCashPaid = function()
    {
        return this.cash_paid;
    }
    Sale.prototype.setCheckPaid = function(value)
    {
        this.check_paid = value;
    }
    Sale.prototype.getCheckPaid = function()
    {
        return this.check_paid;
    }
    Sale.prototype.setCheckDescription = function(value)
    {
        this.check_description = value;
    }
    Sale.prototype.getCheckDescription = function()
    {
        return this.check_description;
    }
    Sale.prototype.setPreviousDue = function(value)
    {
        this.previous_due = value;
    }
    Sale.prototype.getPreviousDue = function()
    {
        return this.previous_due;
    }
    Sale.prototype.setCurrentDue = function(value)
    {
        this.current_due = value;
    }
    Sale.prototype.getCurrentDue = function()
    {
        return this.current_due;
    }
}

