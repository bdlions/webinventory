<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Payments Model
 * Added in Class Diagram
 * Requirements: PHP5 or above
 */
class Payments_model extends Ion_auth_model {
    public function __construct() {
        parent::__construct();
    }
    
    /*
     * This method will return total payment of a supplier of a shop
     * @param $supplier_id, supplier id
     * @param $shop_id, shop id
     * @Author Nazmul on 15th January 2015
     */
    public function get_supplier_total_payment($supplier_id, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }        
        $this->db->where('shop_id', $shop_id);
        $this->db->where('supplier_id', $supplier_id);
        return $this->db->select('SUM(amount) as total_payment')
                            ->from($this->tables['supplier_payment_info'])
                            ->get();
    }
    /*
     * This method will return total returned payment of a supplier of a shop
     * @param $supplier_id, supplier id
     * @param $shop_id, shop id
     * @Author Nazmul on 15th January 2015
     */
    public function get_supplier_total_returned_payment($supplier_id, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id', $shop_id);
        $this->db->where('supplier_id', $supplier_id);
        return $this->db->select('SUM(amount) as total_returned_payment')
                            ->from($this->tables['supplier_returned_payment_info'])
                            ->get();
    }
    /*
     * This method will return total returned payment of all supplier of a shop
     * @param $shop_id, shop id
     * @Author Nazmul on 15th January 2015
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
     * This method will return total returned payment of all supplier of a shop of today
     * @param $time, time in milisecond
     * @param $shop_id, shop id
     * @Author Nazmul on 15th January 2015
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
     * This method will return returned payment list of all supplier of a shop of today
     * @param $time, time in milisecond
     * @param $shop_id, shop id
     * @Author Nazmul on 15th January 2015
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
    /*
     * This method will return customer payment info
     * @param $payment_id, payment id
     * @Author Nazmul on 15th January 2015
     */
    public function get_customer_payment_info($payment_id)
    {
        $this->db->where('id', $payment_id);
        return $this->db->select('*')
                    ->from($this->tables['customer_payment_info'])
                    ->get();
    }
    /*
     * This method will return total payment of a customer of a shop
     * @param $customer_id, customer id
     * @param $shop_id, shop id
     * @Author Nazmul on 15th January 2015
     */
    public function get_customer_total_payment($customer_id, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id', $shop_id);
        $this->db->where('customer_id', $customer_id);
        return $this->db->select('SUM(amount) as total_payment')
                            ->from($this->tables['customer_payment_info'])
                            ->get();
    }
    /*
     * This method will return total payment of all customers of a shop
     * @param $shop_id, shop id
     * @Author Nazmul on 15th January 2015
     */
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
    /*
     * This method will return total payment of all customers of a shop of today
     * @param $time, time in milisecond
     * @param $shop_id, shop id
     * @Author Nazmul on 15th January 2015
     */
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
    /*
     * This method will return total returned payment of a customer of a shop
     * @param $customer_id, custome id
     * @param $shop_id, shop id
     * @Author Nazmul on 15th January 2015
     */
    public function get_customer_total_returned_payment($customer_id, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id', $shop_id);
        $this->db->where('customer_id', $customer_id);
        return $this->db->select('SUM(amount) as total_returned_payment')
                            ->from($this->tables['customer_returned_payment_info'])
                            ->get();
    }
    /*
     * This method will return total returned payment of all customers of a shop
     * @param $shop_id, shop id
     * @Author Nazmul on 15th January 2015
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
     * This method will return total returned payment of all customers of a shop of today
     * @param $time, time
     * @param $shop_id, shop id
     * @Author Nazmul on 15th January 2015
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
    /*
     * This method will return returned payment list of all customers of a shop of today
     * @param $time, time
     * @param $shop_id, shop id
     * @Author Nazmul on 15th January 2015
     */
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
    /*
     * This method will return customers total sale payment of today of a shop
     * @param $start_time, time
     * @param $shop_id, shop id
     * @Author Nazmul on 15th January 2015
     */
    public function get_customers_sale_payment_today($start_time, $shop_id = '')
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id', $shop_id);
        $this->db->where('created_on >=', $start_time);
        $this->db->where('payment_category_id', CUSTOMER_PAYMENT_CATEGORY_SALE_PAYMENT_ID);
        return $this->db->select('sum(amount) as total_customer_payment')
                            ->from($this->tables['customer_payment_info'])
                            ->get();
    }
    /*
     * This method will return customers sale payment list of today of a shop
     * @param $start_time, time
     * @param $shop_id, shop id
     * @Author Nazmul on 15th January 2015
     */
    public function get_customers_sale_payment_list_today($start_time, $shop_id = '')
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id', $shop_id);
        $this->db->where('created_on >=', $start_time);
        $this->db->where('payment_category_id', CUSTOMER_PAYMENT_CATEGORY_SALE_PAYMENT_ID);
        $this->db->group_by($this->tables['customer_payment_info'].'.sale_order_no');
        return $this->db->select($this->tables['customer_payment_info'].'.sale_order_no, sum(amount) as total_payment')
                            ->from($this->tables['customer_payment_info'])
                            ->get();
    }
    /*
     * This method will return customers total due collect of today of a shop
     * @param $start_time, time
     * @param $shop_id, shop id
     * @Author Nazmul on 15th January 2015
     */
    public function get_customers_due_collect_today($start_time, $shop_id = '')
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id', $shop_id);
        $this->db->where('created_on >=', $start_time);
        $this->db->where('payment_category_id', CUSTOMER_PAYMENT_CATEGORY_DUE_COLLECT_ID);
        return $this->db->select('sum(amount) as total_due_collect')
                            ->from($this->tables['customer_payment_info'])
                            ->get();
    }
    /*
     * This method will return customers due collect list of today of a shop
     * @param $start_time, time
     * @param $shop_id, shop id
     * @Author Nazmul on 15th January 2015
     */
    public function get_customers_due_collect_list_today($start_time, $shop_id = '')
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['customer_payment_info'].'.shop_id', $shop_id);
        $this->db->where($this->tables['customer_payment_info'].'.created_on >=', $start_time);
        $this->db->where('payment_category_id', CUSTOMER_PAYMENT_CATEGORY_DUE_COLLECT_ID);
        return $this->db->select($this->tables['customer_payment_info'].'.*,'.$this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name,'.$this->tables['customers'].'.card_no')
                            ->from($this->tables['customer_payment_info'])
                            ->join($this->tables['customers'], $this->tables['customers'].'.id='.$this->tables['customer_payment_info'].'.customer_id')
                            ->join($this->tables['users'], $this->tables['users'].'.id='.$this->tables['customers'].'.user_id')
                            ->get();
    }
    /*
     * This method will return customers due collect list of a shop
     * @param $start_time, time
     * @param $end_time, time
     * @param $shop_id, shop id
     * @Author Nazmul on 15th January 2015
     */
    public function get_customers_due_collect_list($start_time, $end_time, $shop_id = '')
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['customer_payment_info'].'.shop_id', $shop_id);
        $this->db->where($this->tables['customer_payment_info'].'.created_on >=', $start_time);
        $this->db->where($this->tables['customer_payment_info'].'.created_on <=', $end_time);
        $this->db->where('payment_category_id', CUSTOMER_PAYMENT_CATEGORY_DUE_COLLECT_ID);
        return $this->db->select($this->tables['customer_payment_info'].'.*,'.$this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name,'.$this->tables['customers'].'.card_no')
                            ->from($this->tables['customer_payment_info'])
                            ->join($this->tables['customers'], $this->tables['customers'].'.id='.$this->tables['customer_payment_info'].'.customer_id')
                            ->join($this->tables['users'], $this->tables['users'].'.id='.$this->tables['customers'].'.user_id')
                            ->get();
    }
    /*
     * This method will add due collect of a customer
     * @param $payment_data, payment data
     * @param $customer_transaction_info_array, customer transaction related to due collect
     */
    public function add_customer_due_collect($payment_data, $customer_transaction_info_array)
    {
        $payment_data = $this->_filter_data($this->tables['customer_payment_info'], $payment_data);
        $this->db->trans_begin();
        $this->db->insert($this->tables['customer_payment_info'], $payment_data);
        $id = $this->db->insert_id();
        if($id > 0)
        {
            if(!empty($customer_transaction_info_array))
            {
                $this->db->insert_batch($this->tables['customer_transaction_info'], $customer_transaction_info_array);
            }
        }
        else
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        $this->db->trans_commit();
        return TRUE;        
    }
    /*
     * This method will remove a due collect payment info
     * @param $payment_id, due collect payment id
     * @param $customer_transaction_info_array, customer transaction related to due collect delete
     */
    public function delete_due_collect_payment($payment_id, $customer_transaction_info_array)
    {
        if(!isset($payment_id) || $payment_id <= 0)
        {
            $this->set_error('delete_due_collect_fail');
            return FALSE;
        }
        $this->db->trans_begin();
        $this->db->where('id', $payment_id);
        $this->db->delete($this->tables['customer_payment_info']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_due_collect_fail');
            $this->db->trans_rollback();
            return FALSE;
        }
        if(!empty($customer_transaction_info_array))
        {
            $this->db->insert_batch($this->tables['customer_transaction_info'], $customer_transaction_info_array);
        }
        $this->set_message('delete_due_collect_successful');
        $this->db->trans_commit();
        return TRUE;        
    }       
}
