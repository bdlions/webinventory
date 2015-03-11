<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Name:  Payment
 * Added in Class Diagram
 * Requirements: PHP5 or above
 */
class Payment extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('org/common/utils');
        $this->load->helper('url');
        $this->load->helper('file');

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $this->load->helper('language');
        
        if(!$this->ion_auth->logged_in())
        {
            redirect("user/login","refresh");
        }
    }
    
    function index()
    {
        //write your code if required
    }
    
   
    public function get_total_sale_by_date()
    {
        
    }
    public function get_total_cash_by_date_range()
    {
        
    }
    public function get_showroom_total_cost()
    {
        
    }
    public function get_supplier_previous_due()
    {
        
    }
   
    public function get_customer_previous_due()
    {
        
    }
    
    
    public function add_due_collect()
    {
 
    }
    /*
     * This method will show due collect list of today
     * @Author Nazmul on 15th January 2015
     */
    public function show_due_collect()
    {
      
    }
   
    public function show_total_due()
    {
      
    }
    
    /*
     * This method will show returned payment list suppliers of current date
     * @Author Nazmul on 15th January 2015
     */
    public function show_suppliers_returned_payment_list()
    {
    }
    /*
     * This method will show returned payment list customers of current date
     * @Author Nazmul on 15th January 2015
     */
    public function show_customers_returned_payment_list()
    {
                 
    }
}
