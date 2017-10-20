<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Transaction Model
 * Added in Class Diagram
 * Requirements: PHP5 or above
 *
 */
class Transaction_model extends Ion_auth_model 
{    
    public function __construct() {
        parent::__construct();        
    }
    
    /*
     * This method will return transaction history of a supplier
     * @param $supplier_id, supplier id
     * @param $shop_id, shop id
     * @Author Nazmul on 15th January 2015
     */
    public function get_supplier_transactions($supplier_id, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }        
        $this->db->where('shop_id', $shop_id);
        $this->db->where('supplier_id', $supplier_id);
        $this->response = $this->db->get($this->tables['supplier_transaction_info']);
        return $this;
    }
    /*
     * This method will return transaction history of a customer
     * @param $customer_id, customer id
     * @param $shop_id, shop id
     * @Author Nazmul on 15th January 2015
     */
    public function get_customer_transactions($customer_id, $shop_id = 0, $limit = 0, $offset = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        if($limit != 0)
        {
            $this->db->offset($offset);
            $this->db->limit($limit);
        }
        $this->db->where('shop_id', $shop_id);
        $this->db->where('customer_id', $customer_id);
        $this->response = $this->db->get($this->tables['customer_transaction_info']);
        return $this;
    }
}
