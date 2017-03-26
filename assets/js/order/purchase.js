function Purchase()
{
    var order_no; 
    var product_category1;
    var product_size;
    var supplier_id;
    var remarks;
    var total;
    var paid;
    var fast_forward;
    Purchase.prototype.setOrderNo = function(value)
    {
        this.order_no = value;
    }
    Purchase.prototype.getOrderNo = function()
    {
        return this.order_no;
    }
    Purchase.prototype.setProductCategory1 = function(value)
    {
        this.product_category1 = value;
    }
    Purchase.prototype.getProductCategory1 = function()
    {
        return this.product_category1;
    }
    Purchase.prototype.setProductSize = function(value)
    {
        this.product_size = value;
    }
    Purchase.prototype.getProductSize = function()
    {
        return this.product_size;
    }
    Purchase.prototype.setSupplierId = function(value)
    {
        this.supplier_id = value;
    }
    Purchase.prototype.getSupplierId = function()
    {
        return this.supplier_id;
    }
    Purchase.prototype.setRemarks = function(value)
    {
        this.remarks = value;
    }
    Purchase.prototype.getRemarks = function()
    {
        return this.remarks;
    }
    Purchase.prototype.setTotal = function(value)
    {
        this.total = value;
    }
    Purchase.prototype.getTotal = function()
    {
        return this.total;
    }
    Purchase.prototype.setPaid = function(value)
    {
        this.paid = value;
    }
    Purchase.prototype.getPaid = function()
    {
        return this.paid;
    }
    Purchase.prototype.setFastForward = function(value)
    {
        this.fast_forward = value;
    }
    Purchase.prototype.getFastForward = function()
    {
        return this.fast_forward;
    }
}

