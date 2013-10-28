<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
    /*
     * Holds account status list
     * 
     * $var array
     */

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('org/product/product_library');
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
    
    public function create_product()
    {
        
    }
    
    public function update_product()
    {
        
    }
    
    public function delete_product()
    {
        
    }
    
    public function get_product()
    {
        
    }
    
    public function get_all_products()
    {
        
    }
    
    public function search_product()
    {
        
    }
}
