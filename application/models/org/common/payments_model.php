<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Ion Auth Model
 *
 * Author:  Ben Edmunds
 * 		   ben.edmunds@gmail.com
 * 	  	   @benedmunds
 *
 * Added Awesomeness: Phil Sturgeon
 *
 * Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
 *
 * Created:  10.01.2009
 * 
 * Last Change: 3.22.13
 *
 * Changelog:
 * * 3-22-13 - Additional entropy added - 52aa456eef8b60ad6754b31fbdcc77bb
 * 
 * Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
 * Original Author name has been kept but that does not mean that the method has not been modified.
 *
 * Requirements: PHP5 or above
 *
 */
class Payments_model extends Ion_auth_model {
    public function __construct() {
        parent::__construct();
    }
    
    public function get_supplier_total_payment($supplier_id)
    {
        $shop_id = $this->session->userdata('shop_id');
        $this->db->where('shop_id', $shop_id);
        $this->db->where('supplier_id', $supplier_id);
        return $this->db->select('SUM(amount) as total_payment')
                            ->from($this->tables['supplier_payment_info'])
                            ->get();
    }
    
    public function get_supplier_transactions($supplier_id)
    {
        $shop_id = $this->session->userdata('shop_id');
        $this->db->where('shop_id', $shop_id);
        $this->db->where('supplier_id', $supplier_id);
        $this->response = $this->db->get($this->tables['supplier_transaction_info']);
        return $this;
    }
    
    public function get_customer_total_payment($customer_id)
    {
        $shop_id = $this->session->userdata('shop_id');
        $this->db->where('shop_id', $shop_id);
        $this->db->where('customer_id', $customer_id);
        return $this->db->select('SUM(amount) as total_payment')
                            ->from($this->tables['customer_payment_info'])
                            ->get();
    }
    
    public function get_customer_transactions($customer_id)
    {
        $shop_id = $this->session->userdata('shop_id');
        $this->db->where('shop_id', $shop_id);
        $this->db->where('customer_id', $customer_id);
        $this->response = $this->db->get($this->tables['customer_transaction_info']);
        return $this;
    }
    
    public function add_customer_due_collect($payment_data)
    {
        $payment_data = $this->_filter_data($this->tables['customer_payment_info'], $payment_data);
        $this->db->insert($this->tables['customer_payment_info'], $payment_data);
        $id = $this->db->insert_id();
        return (isset($id)) ? $id : FALSE;        
    }
    
    public function add_customer_due_collect_transaction($transaction_data)
    {
        $this->db->insert_batch($this->tables['customer_transaction_info'], $transaction_data);
        $id = $this->db->insert_id();
        return (isset($id)) ? $id : FALSE;        
    }
    
}
