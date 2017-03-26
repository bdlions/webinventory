function Product()
{
    var product_id = '';
    var name = '';
    var quantity = '';
    var unit_price = '';
    var discount = '';
    var sub_total = '';
    var purchase_order_no = '';
    var product_category1 = '';
    var product_size = '';
    
    Product.prototype.setProductId = function(value)
    {
        this.product_id = value;
    }
    Product.prototype.getProductId = function()
    {
        return this.product_id;
    }
    Product.prototype.setName = function(value)
    {
        this.name = value;
    }
    Product.prototype.getName = function()
    {
        return this.name;
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
    Product.prototype.setProductCategory1 = function(value)
    {
        this.product_category1 = value;
    }
    Product.prototype.getProductCategory1 = function()
    {
        return this.product_category1;
    }
    Product.prototype.setProductSize = function(value)
    {
        this.product_size = value;
    }
    Product.prototype.getProductSize = function()
    {
        return this.product_size;
    }
}

