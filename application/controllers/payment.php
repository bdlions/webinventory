<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {
    /*
     * Holds account status list
     * 
     * $var array
     */

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('sms_library');
        $this->load->library('org/common/payments');
        $this->load->library('org/purchase/purchase_library');
        $this->load->library('org/sale/sale_library');
        $this->load->helper('url');
        $this->load->helper('file');

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
    
    public function get_supplier_previous_due()
    {
        $supplier_id = $_POST['supplier_id'];
        $supplier_due = $this->payments->get_supplier_current_due($supplier_id);        
        echo $supplier_due;
    }
    
    public function show_supplier_transactions($supplier_id)
    {
        $supplier_transaction_list = array();
        $supplier_transactions_array = $this->payments->get_supplier_transactions($supplier_id)->result_array();
        if(!empty($supplier_transactions_array))
        {
            foreach($supplier_transactions_array as $supplier_transaction)
            {
                $created_on = $supplier_transaction['created_on'];
                $time_zone_array = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, 'BD');
                $dateTimeZone = new DateTimeZone($time_zone_array[0]);
                $dateTime = new DateTime("now", $dateTimeZone);
                $supplier_transaction['created_on'] = unix_to_human($created_on + $dateTime->getOffset());
                $supplier_transaction_list[] = $supplier_transaction;
            }
        }
        $this->data['supplier_transaction_list'] = $supplier_transaction_list;
        $supplier_info = array();
        $supplier_info_array = $this->ion_auth->get_supplier(0, $supplier_id)->result_array();
        if(!empty($supplier_info_array))
        {
            $supplier_info = $supplier_info_array[0];
        }
        $this->data['supplier_info'] = $supplier_info;
        $this->template->load(null, 'supplier/show_supplier_transactions',$this->data);
    }
    
    public function get_customer_previous_due()
    {
        $customer_id = $_POST['customer_id'];
        $customer_due = $this->payments->get_customer_current_due($customer_id);
        echo $customer_due;
    }
    
    public function show_customer_transactions($customer_id)
    {
        $customer_transaction_list = array();
        $customer_transactions_array = $this->payments->get_customer_transactions($customer_id)->result_array();
        if(!empty($customer_transactions_array))
        {
            foreach($customer_transactions_array as $customer_transaction)
            {
                $created_on = $customer_transaction['created_on'];
                $time_zone_array = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, 'BD');
                $dateTimeZone = new DateTimeZone($time_zone_array[0]);
                $dateTime = new DateTime("now", $dateTimeZone);
                $customer_transaction['created_on'] = unix_to_human($created_on + $dateTime->getOffset());
                $customer_transaction_list[] = $customer_transaction;
            }
        }
        $this->data['customer_transaction_list'] = $customer_transaction_list;
        $customer_info = array();
        $customer_info_array = $this->ion_auth->get_customer(0, $customer_id)->result_array();
        if(!empty($customer_info_array))
        {
            $customer_info = $customer_info_array[0];
        }
        $this->data['customer_info'] = $customer_info;
        $this->template->load(null, 'customer/show_customer_transactions',$this->data);
    }
    
    public function add_due_collect()
    {
        $shop_id = $this->session->userdata('shop_id');
        $customer_id = $_POST['customer_id'];
        $amount = $_POST['amount'];
        
        $customer_payment_data = array(
            'shop_id' => $shop_id,
            'customer_id' => $customer_id,
            'amount' => $amount,
            'description' => 'due collect',
            'created_on' => now()
        );
        $id = $this->payments->add_customer_due_collect($customer_payment_data);
        if($id == FALSE)
        {
            echo 0;
        }
        else
        {
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
                'sub_total' => $current_due,
                'payment_status' => 'Total due',
                'profit' => ''
            );
            $customer_transaction_info_array[] = $customer_transaction_info2;
            $this->payments->add_customer_due_collect_transaction($customer_transaction_info_array);
            echo 1;
        }
    }
}
