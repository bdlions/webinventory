<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {
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
        $this->load->library('org/stock/stock_library');
    }
    
    function index()
    {
        
    }
    
    function show_all_stocks()
    {
        $shop_id = 1;
        $this->data['stock_list'] = array();
        $stock_list_array = $this->stock_library->get_all_stocks($shop_id)->result_array();
        if( count($stock_list_array) > 0)
        {
            $this->data['stock_list'] = $stock_list_array;
        }
        $this->template->load(null, 'stock/show_all_stocks', $this->data);
    }
}
