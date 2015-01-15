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
        $this->load->library('org/common/payments');
        $this->load->library('org/common/utils');
        $this->load->library('org/shop/shop_library');
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
    
    /*
     * Ajax Call
     * This method will return supplier previous due
     * @Author Nazmul on 15th January 2015
     */
    public function get_supplier_previous_due()
    {
        $supplier_id = $this->input->post('supplier_id');
        $supplier_due = $this->payments->get_supplier_current_due($supplier_id);        
        echo $supplier_due;
    }
    /*
     * Ajax Call
     * This method will return customer previous due
     * @Author Nazmul on 15th January 2015
     */
    public function get_customer_previous_due()
    {
        $customer_id = $this->input->post('customer_id');
        $customer_due = $this->payments->get_customer_current_due($customer_id);
        echo $customer_due;
    }
    
    /*
     * Ajax call
     * This method will add due collect of a customer
     * @Author Nazmul on 15th January 2015
     */
    public function add_due_collect()
    {
        $shop_id = $this->session->userdata('shop_id');
        $customer_id = $this->input->post('customer_id');
        $amount = $this->input->post('amount');
        
        $customer_payment_data = array(
            'payment_type_id' => CUSTOMER_PAYMENT_TYPE_CASH_ID,
            'payment_category_id' => CUSTOMER_PAYMENT_CATEGORY_DUE_COLLECT_ID,
            'shop_id' => $shop_id,
            'customer_id' => $customer_id,
            'amount' => $amount,
            'description' => 'due collect',
            'created_on' => now()
        );
        $current_due = $this->payments->get_customer_current_due($customer_id);
        $customer_transaction_info_array = array();
        $customer_transaction_info1 = array(
            'shop_id' => $shop_id,
            'customer_id' => $customer_id,
            'created_on' => now(),
            'lot_no' => '',
            'name' => '',
            'quantity' => '',
            'unit_price' => '',
            'sub_total' => $amount,
            'payment_status' => 'Due Collect',
            'profit' => ''
        );
        $customer_transaction_info_array[] = $customer_transaction_info1;
        $customer_transaction_info2 = array(
            'shop_id' => $shop_id,
            'customer_id' => $customer_id,
            'created_on' => now(),
            'lot_no' => '',
            'name' => '',
            'quantity' => '',
            'unit_price' => '',
            'sub_total' => ($current_due - $amount),
            'payment_status' => 'Total due',
            'profit' => ''
        );
        $customer_transaction_info_array[] = $customer_transaction_info2;
        $id = $this->payments->add_customer_due_collect($customer_payment_data, $customer_transaction_info_array);
        if($id == FALSE)
        {
            echo 0;
        }
        else
        {
            echo 1;
        }
    }
    /*
     * This method will show due collect list of today
     * @Author Nazmul on 15th January 2015
     */
    public function show_due_collect()
    {
        $due_collect_list = array();        
        $shop_info = $this->shop_library->get_shop()->result_array();        
        if(!empty($shop_info))
        {
            $shop_info = $shop_info[0];
        }
        else
        {
            //show your page if needed
            return;
        }        
        $time = $this->utils->get_current_date_start_time();
        $due_collect_list_array = $this->payments->get_customers_due_collect_list_today($time)->result_array();
        foreach($due_collect_list_array as $due_collect)
        {
            $due_collect['created_on'] = $this->utils->process_time($due_collect['created_on']);
            $due_collect_list[] = $due_collect;
        }
        $this->data['due_collect_list'] = $due_collect_list;
        $this->data['shop_info'] = $shop_info;
        $this->template->load(null, 'search/due/due_collect',$this->data);
    }
    /*
     * Ajax Call
     * This method will delete due collect payment
     * @Author Nazmul on 15th January 2015
     */
    public function delete_due_collect_payment()
    {
        $result = array();
        $shop_id = $this->session->userdata('shop_id');
        $payment_id = $this->input->post('id');
        $customer_payment_info_array = $this->payments->get_customer_payment_info($payment_id)->result_array();
        if(!empty($customer_payment_info_array))
        {
            $payment_info = $customer_payment_info_array[0];
            $current_due = $this->payments->get_customer_current_due($payment_info['customer_id']);
            $customer_transaction_info_array = array();
            $customer_transaction_info1 = array(
                'shop_id' => $shop_id,
                'customer_id' => $payment_info['customer_id'],
                'created_on' => now(),
                'lot_no' => '',
                'name' => '',
                'quantity' => '',
                'unit_price' => '',
                'sub_total' => $payment_info['amount'],
                'payment_status' => 'Due Collect deleted',
                'profit' => ''
            );
            $customer_transaction_info_array[] = $customer_transaction_info1;
            $customer_transaction_info2 = array(
                'shop_id' => $shop_id,
                'customer_id' => $payment_info['customer_id'],
                'created_on' => now(),
                'lot_no' => '',
                'name' => '',
                'quantity' => '',
                'unit_price' => '',
                'sub_total' => ($current_due + $payment_info['amount']),
                'payment_status' => 'Total due',
                'profit' => ''
            );
            $customer_transaction_info_array[] = $customer_transaction_info2;
            if($this->payments->delete_due_collect_payment($payment_id, $customer_transaction_info_array))
            {
                $result['message'] = $this->payments->messages_alert();
            }
            else
            {
                $result['message'] = $this->payments->errors_alert();
            }
        }
        else
        {
            $result['message'] = 'Unable to delete.';
        }        
        echo json_encode($result);        
    }
    
    /*
     * This method will show due list of current date
     * @Author Nazmul on 15th January 2015
     */
    public function show_total_due()
    {
        $shop_info = $this->shop_library->get_shop()->result_array();        
        if(!empty($shop_info))
        {
            $shop_info = $shop_info[0];
        } 
        else
        {
            //write your code if required
            return;
        }
        $this->data['due_list'] = $this->payments->get_daily_sale_due_list();
        $this->data['shop_info'] = $shop_info;
        $this->template->load(null, 'search/due/due_list',$this->data);
    }
    
    /*
     * This method will show returned payment list suppliers of current date
     * @Author Nazmul on 15th January 2015
     */
    public function show_suppliers_returned_payment_list()
    {
        $time = $this->utils->get_current_date_start_time();
        $suppliers_returned_payment_list = array();
        $suppliers_returned_payment_list_today_array = $this->payments->get_suppliers_returned_payment_list_today($time)->result_array();
        if(!empty($suppliers_returned_payment_list_today_array))
        {
            foreach($suppliers_returned_payment_list_today_array as $suppliers_returned_payment_list_today)
            {
                $suppliers_returned_payment_list_today['created_on'] = $this->utils->process_time($suppliers_returned_payment_list_today['created_on']);
                $suppliers_returned_payment_list[] = $suppliers_returned_payment_list_today;
            }
        }
        $this->data['suppliers_returned_payment_list'] = $suppliers_returned_payment_list;
        $this->template->load(null, 'search/return/supplier_payment_list',$this->data);
    }
    /*
     * This method will show returned payment list customers of current date
     * @Author Nazmul on 15th January 2015
     */
    public function show_customers_returned_payment_list()
    {
        $shop_info = $this->shop_library->get_shop()->result_array();        
        if(!empty($shop_info))
        {
            $shop_info = $shop_info[0];
        }
        else
        {
            //write your code if required
            return;
        }
        $this->data['shop_info'] = $shop_info;        
        $time = $this->utils->get_current_date_start_time();
        $customers_returned_payment_list = array();
        $customers_returned_payment_list_today_array = $this->payments->get_customers_returned_payment_list_today($time)->result_array();
        if(!empty($customers_returned_payment_list_today_array))
        {
            foreach($customers_returned_payment_list_today_array as $customer_returned_payment_list_today_array)
            {
                $customer_returned_payment_list_today_array['created_on'] = $this->utils->process_time($customer_returned_payment_list_today_array['created_on']);
                $customers_returned_payment_list[] = $customer_returned_payment_list_today_array;
            }
        }
        $this->data['customers_returned_payment_list'] = $customers_returned_payment_list;
        $this->template->load(null, 'search/return/customer_payment_list',$this->data);            
    }
}
