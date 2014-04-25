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
class Expense_model extends Ion_auth_model {
    protected $expense_type_list = array();
    public function __construct() {
        parent::__construct();
        $this->load->library('org/common/payments');
        $this->expense_type_list = $this->config->item('expense_type', 'ion_auth');
    }
    public function get_all_expense_types()
    {
        $this->response = $this->db->get($this->tables['expense_type']);
        return $this;
    }
    /**
     * Checks shop id
     *
     * @return bool
     * @author Nazmul
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
    public function supplier_id_check($supplier_id = '') {
        $this->trigger_events('supplier_id_check');

        if (empty($supplier_id)) {
            return FALSE;
        }

        $this->trigger_events('extra_where');

        return $this->db->where('id', $supplier_id)
                        ->count_all_results($this->tables['suppliers']) > 0;
    }
    public function add_expense($data)
    {
        $current_time = now();
        $shop_id = $this->session->userdata('shop_id');
        if($data['expense_type_id'] === $this->expense_type_list['shop'])
        {
            //checking whether shop exists or not
            if ( !isset($data['reference_id']) || !$this->shop_id_check($data['reference_id']) ) {
                $this->set_error('add_expense_invalid_shop');
                return FALSE;
            }
        }
        if($data['expense_type_id'] === $this->expense_type_list['supplier'])
        {
            //checking whether shop exists or not
            if ( !isset($data['reference_id']) || !$this->supplier_id_check($data['reference_id']) ) {
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
        
        if($id > 0 && $data['expense_type_id'] === $this->expense_type_list['supplier'])
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
    
    public function get_expense_info($expense_id)
    {
        $this->db->where('id', $expense_id);
        return $this->db->get($this->tables['expense_info'])->result_array();
    }
    
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
        if(!empty($expense_info) && $expense_info['expense_type_id'] == $this->expense_type_list['supplier'] )
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
    
    public function get_expenses($expense_type_id, $reference_id, $start_time, $end_time, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        if($reference_id != 0)
        {
            $this->db->where('reference_id', $reference_id);
        }
        $this->db->where('shop_id', $shop_id);
        $this->db->where('expense_date >=', $start_time);
        $this->db->where('expense_date <=', $end_time);
        $this->db->where('expense_type_id', $expense_type_id);
        $this->response = $this->db->get($this->tables['expense_info']);
        return $this;
    }
    
    public function get_all_expenses($start_time, $end_time, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id', $shop_id);
        $this->db->where('expense_date >=', $start_time);
        $this->db->where('expense_date <=', $end_time);
        $this->response = $this->db->get($this->tables['expense_info']);
        return $this;
    }
    
    /*
     * This method will return all expenses before current_date
     */
    public function get_previous_expenses($current_date, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id', $shop_id);
        $this->db->where('expense_date <', $current_date);
        $this->response = $this->db->select('sum(expense_amount) as total_expense')
                               ->from($this->tables['expense_info'])
                               ->get();
        return $this;
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
