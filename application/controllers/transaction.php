<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Name:  Transaction
 * Added in Class Diagram
 */
class Transaction extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('org/shop/shop_library');
        $this->load->library('org/transaction/transaction_library');
        $this->load->helper('url');

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
        //write your code here if needed
    }
    
    /*
     * Supplier transactions
     * @param $supplier_id, supplier id
     * @Author Nazmul on 15th January 2015
     */
    public function show_supplier_transactions($supplier_id = 0)
    {
        //validate supplier id
        $this->data['supplier_transaction_list'] = $this->transaction_library->get_supplier_transactions($supplier_id);
        $supplier_info = array();
        $supplier_info_array = $this->ion_auth->get_supplier(0, $supplier_id)->result_array();
        if(!empty($supplier_info_array))
        {
            $supplier_info = $supplier_info_array[0];
        }
        $this->data['supplier_info'] = $supplier_info;
        $this->template->load(null, 'supplier/show_supplier_transactions',$this->data);
    }
    
    /*
     * Customer transactions
     * @param $customer_id, customer id
     * @Author Nazmul on 15th January 2015
     */
    public function show_customer_transactions($customer_id)
    {
        $shop_info = array();
        $shop_info_array = $this->shop_library->get_shop()->result_array();
        if(!empty($shop_info_array))
        {
            $shop_info = $shop_info_array[0];
        }
        $this->data['shop_info'] = $shop_info;
        $this->data['customer_transaction_list'] = $this->transaction_library->get_customer_transactions($customer_id);
        $customer_info = array();
        $customer_info_array = $this->ion_auth->get_customer(0, $customer_id)->result_array();
        if(!empty($customer_info_array))
        {
            $customer_info = $customer_info_array[0];
        }
        $this->data['customer_info'] = $customer_info;
        if($shop_info['shop_type_id'] == SHOP_TYPE_SMALL) 
        {   
            $this->template->load(null, 'customer/show_customer_transactions',$this->data);        
        }
        else if($shop_info['shop_type_id'] == SHOP_TYPE_MEDIUM) 
        {
            $this->template->load(null, 'customer/show_customer_transactions_medium',$this->data);       
        }
    }    
}