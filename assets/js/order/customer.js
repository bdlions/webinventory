function Customer()
{
    var full_name = '';
    var phone = '';
    Customer.prototype.setFullName = function(value)
    {
        this.full_name = value;
    }
    Customer.prototype.getFullName = function()
    {
        return this.full_name;
    }
    Customer.prototype.setPhone = function(value)
    {
        this.phone = value;
    }
    Customer.prototype.getPhone = function()
    {
        return this.phone;
    } 
}

