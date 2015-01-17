<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Ion Auth Model
 * Requirements: PHP5 or above
 *
 */
class Expense_model extends Ion_auth_model {
    public function __construct() {
        parent::__construct();
        $this->load->library('org/common/payments');
    }
    /*
     * This method will return all expense types
     * @Author Nazmul on 17th January 2015
     */
    public function get_all_expense_types()
    {
        $this->response = $this->db->get($this->tables['expense_type']);
        return $this;
    }
    /**
     * This method checks whether shop exists or not
     * @param $shop_id, shop id
     * @author Nazmul on 17th January 2015
     * */
    public function shop_id_check($shop_id = '') {
        $this->trigger_events('shop_id_check');
        if (empty($shop_id)) {
            return FALSE;
        }
        $this->trigger_events('extra_where');
        return $this->db->where('id', $shop_id)
                        ->count_all_results($this->tables['shop_info']) > 0;
    }
    /**
     * This method checks whether supplier exists or not
     * @param $supplier_id, supplier id
     * @author Nazmul on 17th January 2015
     * */
    public function supplier_id_check($supplier_id = '') {
        $this->trigger_events('supplier_id_check');
        if (empty($supplier_id)) {
            return FALSE;
        }
        $this->trigger_events('extra_where');
        return $this->db->where('id', $supplier_id)
                        ->count_all_results($this->tables['suppliers']) > 0;
    }
    /**
     * This method checks whether user exists or not
     * @param $supplier_id, supplier id
     * @author Nazmul on 17th January 2015
     * */
    public function user_id_check($user_id = '') {
        $this->trigger_events('user_id_check');
        if (empty($user_id)) {
            return FALSE;
        }
        $this->trigger_events('extra_where');
        return $this->db->where('id', $user_id)
                        ->count_all_results($this->tables['users']) > 0;
    }
    /*
     * This method will add expense
     * @param $data, expense data
     * @author Nazmul on 17th January 2015
     */
    public function add_expense($data)
    {
        $current_time = now();
        $shop_id = $this->session->userdata('shop_id');
        if($data['expense_type_id'] == EXPENSE_SHOP_TYPE_ID)
        {
            //checking whether shop exists or not
            if ( !isset($data['reference_id']) || !$this->shop_id_check($data['reference_id']) ) {
                $this->set_error('add_expense_invalid_shop');
                return FALSE;
            }            
        }
        if($data['expense_type_id'] == EXPENSE_SUPPLIER_TYPE_ID)
        {
            //checking whether supplier exists or not
            if ( !isset($data['reference_id']) || !$this->supplier_id_check($data['reference_id']) ) {
                $this->set_error('add_expense_invalid_supplier');
                return FALSE;
            }
        }
        if($data['expense_type_id'] == EXPENSE_EQUIPMENT_SUPPLIER_TYPE_ID || $data['expense_type_id'] == EXPENSE_STAFF_TYPE_ID)
        {
            //checking whether user exists or not
            if ( !isset($data['reference_id']) || !$this->user_id_check($data['reference_id']) ) {
                $this->set_error('add_expense_invalid_user');
                return FALSE;
            }
        }
        $this->db->trans_begin();
        $data['created_by'] = $this->session->userdata('user_id');
        $this->trigger_events('pre_add_expense');
            
        //filter out any data passed that doesnt have a matching column in the users table
        $additional_data = $this->_filter_data($this->tables['expense_info'], $data);
        $this->db->insert($this->tables['expense_info'], $additional_data);
        $id = $this->db->insert_id();        
        if($id > 0 && $data['expense_type_id'] == EXPENSE_SUPPLIER_TYPE_ID)
        {
            $supplier_payment_data = array(
                'shop_id' => $shop_id,
                'supplier_id' => $data['reference_id'],
                'amount' => $data['expense_amount'],
                'description' => 'expense',
                'payment_category_id' => PAYMENT_EXPENSE_PAYMENT,
                'reference_id' => $id,
                'created_on' => $current_time
            );
            $this->db->insert($this->tables['supplier_payment_info'], $supplier_payment_data);
            
            $supplier_transaction_info_array = array();
            $current_due = $this->payments->get_supplier_current_due($data['reference_id']);
            $supplier_transaction_info1 = array(
                'shop_id' => $shop_id,
                'supplier_id' => $data['reference_id'],
                'created_on' => $current_time,
                'lot_no' => '',
                'name' => '',
                'quantity' => '',
                'unit_price' => '',
                'sub_total' => $data['expense_amount'],
                'payment_status' => 'Payment(Exp)'
            );
            $supplier_transaction_info_array[] = $supplier_transaction_info1;
            $supplier_transaction_info2 = array(
                'shop_id' => $shop_id,
                'supplier_id' => $data['reference_id'],
                'created_on' => $current_time,
                'lot_no' => '',
                'name' => '',
                'quantity' => '',
                'unit_price' => '',
                'sub_total' => $current_due,
                'payment_status' => 'Total due'
            );
            $supplier_transaction_info_array[] = $supplier_transaction_info2;
            $this->db->insert_batch($this->tables['supplier_transaction_info'], $supplier_transaction_info_array);
        }        
        $this->set_message('add_expense_success');
        $this->trigger_events('post_add_expense');
        $this->db->trans_commit();
        return (isset($id)) ? $id : FALSE;
    }
    
    /*
     * This method will return expense info
     * @param $expense_id, expense id
     * @Author Nazmul on 17th January 2015
     */
    public function get_expense_info($expense_id)
    {
        $this->db->where('id', $expense_id);
        return $this->db->get($this->tables['expense_info'])->result_array();
    }
    
    /*
     * This method will return all expenses of a shop
     * @param $expense_type_id, expense type id
     * @param $reference_id, reference id
     * @param $$start_time, time
     * @param $end_time, time
     * @param $shop_id, shop id
     * @Author Nazmul on 17th January 2015
     */
    public function get_all_expenses($expense_type_id = 0, $reference_id= 0, $start_time = 0, $end_time = 0, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id', $shop_id);
        if($expense_type_id > 0)
        {
            $this->db->where('expense_type_id', $expense_type_id);
        }
        if($reference_id > 0)
        {
            $this->db->where('reference_id', $reference_id);
        }
        if($start_time > 0)
        {
            $this->db->where('expense_date >=', $start_time);
        }
        if($end_time > 0)
        {
            $this->db->where('expense_date <=', $end_time);
        }
        $this->response = $this->db->get($this->tables['expense_info']);
        return $this;
    }
    
    /*
     * This method will delete an expense
     * @param $expense_id, expense id
     * @Author Nazmul on 17th January 2015
     */
    public function delete_expense($expense_id)
    {
        $this->db->trans_begin();
        
        $current_time = now();
        $shop_id = $this->session->userdata('shop_id');
        $expense_info = array();
        $expense_info_array = $this->get_expense_info($expense_id);
        if(!empty($expense_info_array))
        {
            $expense_info = $expense_info_array[0];
        }
        $this->db->delete($this->tables['expense_info'], array('id' => $expense_id));
        if(!empty($expense_info) && $expense_info['expense_type_id'] == EXPENSE_SUPPLIER_TYPE_ID )
        {
            $this->db->delete($this->tables['supplier_payment_info'], array('payment_category_id' => PAYMENT_EXPENSE_PAYMENT, 'reference_id' => $expense_id));
            if ($this->db->affected_rows() == 0) {
                return FALSE;
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->set_error('delete_expense_unsuccessful');
                return FALSE;
            }
            $supplier_transaction_info_array = array();
            $current_due = $this->payments->get_supplier_current_due($expense_info['reference_id']);
            $supplier_transaction_info1 = array(
                'shop_id' => $shop_id,
                'supplier_id' => $expense_info['reference_id'],
                'created_on' => $current_time,
                'lot_no' => '',
                'name' => '',
                'quantity' => '',
                'unit_price' => '',
                'sub_total' => $expense_info['expense_amount'],
                'payment_status' => 'Supplier expense deleted'
            );
            $supplier_transaction_info_array[] = $supplier_transaction_info1;
            $supplier_transaction_info2 = array(
                'shop_id' => $shop_id,
                'supplier_id' => $expense_info['reference_id'],
                'created_on' => $current_time,
                'lot_no' => '',
                'name' => '',
                'quantity' => '',
                'unit_price' => '',
                'sub_total' => $current_due,
                'payment_status' => 'Total due'
            );
            $supplier_transaction_info_array[] = $supplier_transaction_info2;
            $this->db->insert_batch($this->tables['supplier_transaction_info'], $supplier_transaction_info_array);
        }        
        $this->db->trans_commit();
        $this->set_message('delete_expense_successful');
        return TRUE;
    }
    
    public function get_all_expenses_today($time, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id', $shop_id);
        $this->db->where('created_on >=', $time);
        $this->response = $this->db->get($this->tables['expense_info']);
        return $this;
    }
    
    public function get_shop_total_expenses($shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id', $shop_id);
        $this->response = $this->db->select('sum(expense_amount) as total_expense')
                               ->from($this->tables['expense_info'])
                               ->get();
        return $this;
    }
    
    public function get_shop_total_expenses_today($time, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id', $shop_id);
        $this->db->where('created_on >=', $time);
        $this->response = $this->db->select('sum(expense_amount) as total_expense')
                               ->from($this->tables['expense_info'])
                               ->get();
        return $this;
    }
}
