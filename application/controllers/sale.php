<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends CI_Controller {
    /*
     * Holds account status list
     * 
     * $var array
     */

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('ion_auth');
        $this->load->library('org/product/product_library');
        $this->load->library('org/sale/sale_library');
        $this->load->library('org/stock/stock_library');
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
    
    function add_sale()
    {
        $this->data['customer_list_array'] = array();
        $customer_list_array = $this->ion_auth->get_all_customers()->result_array();
        if( count($customer_list_array) > 0)
        {
            $this->data['customer_list_array'] = $customer_list_array;
        }  
        $this->data['product_list_array'] = array();
        $product_list_array = $this->product_library->get_all_products()->result_array();
        if( count($product_list_array) > 0)
        {
            $this->data['product_list_array'] = $product_list_array;
        }
        //$this->stock_library->get_all_stocks();
        
        //if form is posted
        {
            //$this->sale_library->add_sale_order();
            //$this->sale_library->add_product_sale_order();

            //$this->stock_library->update_stock();
        }
        $this->template->load(SALESMAN_LOGIN_SUCCESS_TEMPLATE, 'sales/sales_order',$this->data);
    }
}
