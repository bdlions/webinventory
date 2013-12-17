function Product()
{
    var product_id = '';
    var product_code = '';
    var quantity = '';
    var unit_price = '';
    var discount = '';
    var sub_total = '';
    var purchase_order_no = '';
    
    Product.prototype.setProductId = function(value)
    {
        this.product_id = value;
    }
    Product.prototype.getProductId = function()
    {
        return this.product_id;
    }
    Product.prototype.setProductCode = function(value)
    {
        this.product_code = value;
    }
    Product.prototype.getProductCode = function()
    {
        return this.product_code;
    }
    Product.prototype.setQuantity = function(value)
    {
        this.quantity = value;
    }
    Product.prototype.getQuantity = function()
    {
        return this.quantity;
    }
    Product.prototype.setUnitPrice = function(value)
    {
        this.unit_price = value;
    }
    Product.prototype.getUnitPrice = function()
    {
        return this.unit_price;
    }
    Product.prototype.setDiscount = function(value)
    {
        this.discount = value;
    }
    Product.prototype.getDiscount = function()
    {
        return this.discount;
    }
    Product.prototype.setSubTotal = function(value)
    {
        this.sub_total = value;
    }
    Product.prototype.getSubTotal = function()
    {
        return this.sub_total;
    }
    Product.prototype.setPurchaseOrderNo = function(value)
    {
        this.purchase_order_no = value;
    }
    Product.prototype.getPurchaseOrderNo = function()
    {
        return this.purchase_order_no;
    }
}

