var customer_list = new Array();
var supplier_list = new Array();
var product_list = new Array();
var message_list = new Array();
var purchased_product_list = new Array();

var modal_confirmation_category_id                         = "";
var modal_confirmation_add_product_category_id             = "1";
var modal_confirmation_add_supplier_category_id            = "2";
var modal_confirmation_save_purchase_order_category_id     = "3";
var modal_confirmation_add_customer_category_id            = "4";
var modal_confirmation_save_sale_order_category_id         = "5";

var modal_confirmation_raise_purchase_order_category_id    = "6";
var modal_confirmation_return_purchase_order_category_id   = "7";
var modal_confirmation_return_sale_order_category_id       = "8";

function set_modal_confirmation_category_id(value)
{
    modal_confirmation_category_id = value;
}

function get_modal_confirmation_category_id(value)
{
    return modal_confirmation_category_id;
}
function get_modal_confirmation_add_product_category_id()
{
    return modal_confirmation_add_product_category_id;
}
function get_modal_confirmation_add_supplier_category_id()
{
    return modal_confirmation_add_supplier_category_id;
}
function get_modal_confirmation_save_purchase_order_category_id()
{
    return modal_confirmation_save_purchase_order_category_id;
}
function get_modal_confirmation_add_customer_category_id()
{
    return modal_confirmation_add_customer_category_id;
}
function get_modal_confirmation_save_sale_order_category_id()
{
    return modal_confirmation_save_sale_order_category_id;
}
function get_modal_confirmation_raise_purchase_order_category_id()
{
    return modal_confirmation_raise_purchase_order_category_id;
}

function get_modal_confirmation_return_purchase_order_category_id()
{
    return modal_confirmation_return_purchase_order_category_id;
}

function get_modal_confirmation_return_sale_order_category_id()
{
    return modal_confirmation_return_sale_order_category_id;
}

function set_customer_list(c_list)
{
    customer_list = c_list;
}

function get_customer_list()
{
    return customer_list;
}

function set_supplier_list(s_list)
{
    supplier_list = s_list;
}
function get_supplier_list()
{
    return supplier_list;
}

function set_product_list(p_list)
{
    product_list = p_list;    
}

function get_product_list()
{
    return product_list;
}

function set_purchased_product_list(p_list)
{
    purchased_product_list = p_list;    
}

function get_purchased_product_list()
{
    return purchased_product_list;
}

function set_supplier_message_list(m_list)
{
    message_list = m_list;
}

function get_supplier_message_list()
{
    return message_list;
}

