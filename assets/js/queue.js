var phone_list_under_queue = new Array();
var current_modal_id;
var no_of_msg_in_current_queue;

function set_phone_list(c_list)
{
    phone_list_under_queue = c_list;
}

function get_phone_list()
{
    return phone_list_under_queue;
}
