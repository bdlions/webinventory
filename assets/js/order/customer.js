function Customer()
{
    var full_name = '';
    Customer.prototype.setFullName = function(value)
    {
        this.full_name = value;
    }
    Customer.prototype.getFullName = function()
    {
        return this.full_name;
    }    
}

