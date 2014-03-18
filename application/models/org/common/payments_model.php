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
    protected $payment_category_list = array();
    public function __construct() {
        parent::__construct();
        $this->payment_category_list = $this->config->item('payment_category', 'ion_auth');
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
    
    public function get_supplier_total_returned_payment($supplier_id)
    {
        $shop_id = $this->session->userdata('shop_id');
        $this->db->where('shop_id', $shop_id);
        $this->db->where('supplier_id', $supplier_id);
        return $this->db->select('SUM(amount) as total_returned_payment')
                            ->from($this->tables['supplier_returned_payment_info'])
                            ->get();
    }
    /*
     * Suppliers total returned payment
     */
    public function get_suppliers_total_returned_payment($shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }        
        $this->db->where('shop_id', $shop_id);
        return $this->db->select('SUM(amount) as total_returned_payment')
                            ->from($this->tables['supplier_returned_payment_info'])
                            ->get();
    }
    /*
     * Suppliers total returned payment of today
     */
    public function get_suppliers_total_returned_payment_today($time, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }        
        $this->db->where('shop_id', $shop_id);
        $this->db->where('created_on >=', $time);
        return $this->db->select('SUM(amount) as total_returned_payment')
                            ->from($this->tables['supplier_returned_payment_info'])
                            ->get();
    }
    
    /*
     * Suppliers returned payment list of today
     */
    public function get_suppliers_returned_payment_list_today($time, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }        
        $this->db->where($this->tables['supplier_returned_payment_info'].'.shop_id', $shop_id);
        $this->db->where($this->tables['supplier_returned_payment_info'].'.created_on >=', $time);
        return $this->db->select($this->tables['supplier_returned_payment_info'].'.*,'.$this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name')
                            ->from($this->tables['supplier_returned_payment_info'])
                            ->join($this->tables['suppliers'], $this->tables['suppliers'].'.id='.$this->tables['supplier_returned_payment_info'].'.supplier_id')
                            ->join($this->tables['users'], $this->tables['users'].'.id='.$this->tables['suppliers'].'.user_id')
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
    
    public function get_customers_total_payment($shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }        
        $this->db->where('shop_id', $shop_id);
        return $this->db->select('SUM(amount) as total_payment')
                            ->from($this->tables['customer_payment_info'])
                            ->get();
    }
    
    public function get_customers_total_payment_today($time, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }        
        $this->db->where('shop_id', $shop_id);
        $this->db->where('created_on >=', $time);
        return $this->db->select('SUM(amount) as total_payment')
                            ->from($this->tables['customer_payment_info'])
                            ->get();
    }
    
    public function get_customer_total_returned_payment($customer_id)
    {
        $shop_id = $this->session->userdata('shop_id');
        $this->db->where('shop_id', $shop_id);
        $this->db->where('customer_id', $customer_id);
        return $this->db->select('SUM(amount) as total_returned_payment')
                            ->from($this->tables['customer_returned_payment_info'])
                            ->get();
    }
    /*
     * Customers total returned payment
     */
    public function get_customers_total_returned_payment($shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }        
        $this->db->where('shop_id', $shop_id);
        return $this->db->select('SUM(amount) as total_returned_payment')
                            ->from($this->tables['customer_returned_payment_info'])
                            ->get();
    }
    /*
     * Customers total returned payment of today
     */
    public function get_customers_total_returned_payment_today($time, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }        
        $this->db->where('shop_id', $shop_id);
        $this->db->where('created_on >=', $time);
        return $this->db->select('SUM(amount) as total_returned_payment')
                            ->from($this->tables['customer_returned_payment_info'])
                            ->get();
    }
    
    public function get_customers_returned_payment_list_today($time, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }        
        $this->db->where($this->tables['customer_returned_payment_info'].'.shop_id', $shop_id);
        $this->db->where($this->tables['customer_returned_payment_info'].'.created_on >=', $time);
        return $this->db->select($this->tables['customer_returned_payment_info'].'.*,'.$this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name,'.$this->tables['customers'].'.card_no')
                            ->from($this->tables['customer_returned_payment_info'])
                            ->join($this->tables['customers'], $this->tables['customers'].'.id='.$this->tables['customer_returned_payment_info'].'.customer_id')
                            ->join($this->tables['users'], $this->tables['users'].'.id='.$this->tables['customers'].'.user_id')
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
    
    public function get_customer_due_collect_today($start_time, $shop_id = '')
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id', $shop_id);
        $this->db->where('created_on >=', $start_time);
        $this->db->where('payment_category_id', $this->payment_category_list['due_collect_id']);
        return $this->db->select('sum(amount) as total_due_collect')
                            ->from($this->tables['customer_payment_info'])
                            ->get();
    }
    
    public function get_customer_due_collect_list_today($start_time, $shop_id = '')
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['customer_payment_info'].'.shop_id', $shop_id);
        $this->db->where($this->tables['customer_payment_info'].'.created_on >=', $start_time);
        $this->db->where('payment_category_id', $this->payment_category_list['due_collect_id']);
        return $this->db->select($this->tables['customer_payment_info'].'.*,'.$this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name,'.$this->tables['customers'].'.card_no')
                            ->from($this->tables['customer_payment_info'])
                            ->join($this->tables['customers'], $this->tables['customers'].'.id='.$this->tables['customer_payment_info'].'.customer_id')
                            ->join($this->tables['users'], $this->tables['users'].'.id='.$this->tables['customers'].'.user_id')
                            ->get();
    }
    
    public function get_customer_previous_due_collect($current_date, $shop_id = 0)
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id', $shop_id);
        $this->db->where('created_on <', $current_date);
        $this->db->where('payment_category_id', $this->payment_category_list['due_collect_id']);
        return $this->db->select('sum(amount) as total_previous_due_collect')
                            ->from($this->tables['customer_payment_info'])
                            ->get();
    }
    
    public function add_customer_transactions($customer_transaction_info_array)
    {
        $this->db->insert_batch($this->tables['customer_transaction_info'], $customer_transaction_info_array);
    }
    
    public function delete_customer_payment($sale_order_no, $shop_id = 0)
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id', $shop_id);
        $this->db->where('sale_order_no', $sale_order_no);
        return $this->db->delete($this->tables['customer_payment_info']);
    }
    
}
