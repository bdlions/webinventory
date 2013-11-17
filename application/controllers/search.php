<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {
    /*
     * Holds account status list
     * 
     * $var array
     */

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
    }
    
    function index()
    {
        
    }
    
    function search_customer_sale_order()
    {
        $result_array = array();
        $search_category_name = $_POST['search_category_name'];
        $search_category_value = $_POST['search_category_value'];
        $customer_list_array = $this->ion_auth->search_customer($search_category_name, $search_category_value)->result_array();
        if( count($customer_list_array) > 0)
        {
            $result_array = $customer_list_array;
        }
        echo json_encode($result_array);
    }
}
