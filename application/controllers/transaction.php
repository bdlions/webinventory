<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Name:  Transaction
 * Added in Class Diagram
 */
class Transaction extends CI_Controller {
    public $tables = array();
    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('org/sale/sale_library');
        $this->load->library('org/shop/shop_library');
        $this->load->library('org/transaction/transaction_library');
        $this->load->helper('url');
        $this->tables = $this->config->item('tables', 'ion_auth');
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
        $user_group = $this->ion_auth->get_users_groups()->result_array();        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
            $this->user_group = $user_group;
            $this->data['user_group'] = $user_group;
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
        $supplier_info_array = $this->ion_auth->get_supplier_info(0, $supplier_id)->result_array();
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
        $customer_info_array = $this->ion_auth->get_customer_info(0, $customer_id)->result_array();
        if(!empty($customer_info_array))
        {
            $customer_info = $customer_info_array[0];
        }
        $this->data['customer_info'] = $customer_info;
        
        $total_sale_price = 0;
        $total_quantity= 0;
        $total_profit = 0;
        $where = array(
            $this->tables['customers'].'.id' => $customer_id
        );
        $customer_sales_array = $this->sale_library->where($where)->get_customer_sales()->result_array();
        foreach($customer_sales_array as $sale_info)
        {
            $total_sale_price = $total_sale_price + ($sale_info['sale_unit_price']*$sale_info['total_sale']);
            $total_quantity = $total_quantity + $sale_info['total_sale'];
            $total_profit = $total_profit + ($sale_info['sale_unit_price'] - $sale_info['purchase_unit_price'])*$sale_info['total_sale'];            
        }
        $this->data['total_sale_price'] = $total_sale_price;
        $this->data['total_quantity'] = $total_quantity;
        $this->data['total_profit'] = $total_profit;
        
        $this->template->load(null, 'customer/show_customer_transactions',$this->data);  
    }    
}