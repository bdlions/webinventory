<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Ion Auth
 *
 * Author: Ben Edmunds
 * 		  ben.edmunds@gmail.com
 *         @benedmunds
 *
 * Added Awesomeness: Phil Sturgeon
 *
 * Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
 *
 * Created:  10.01.2009
 *
 * Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
 * Original Author name has been kept but that does not mean that the method has not been modified.
 *
 * Requirements: PHP5 or above
 *
 */
class Expenses {
    /**
     * __construct
     *
     * @return void
     * @author Ben
     * */
    protected $expense_type_list = array();
    public function __construct() {
        $this->load->config('ion_auth', TRUE);
        $this->load->library('org/common/utils');
        $this->load->model('org/common/expense_model');
        $this->load->library('org/shop/shop_library');

        // Load the session, CI2 as a library, CI3 uses it as a driver
        if (substr(CI_VERSION, 0, 1) == '2') {
            $this->load->library('session');
        } else {
            $this->load->driver('session');
        }
        $this->expense_type_list = $this->config->item('expense_type', 'ion_auth');
        // Load IonAuth MongoDB model if it's set to use MongoDB,
        // We assign the model object to "ion_auth_model" variable.
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->model('ion_auth_mongodb_model', 'ion_auth_model') :
                        $this->load->model('ion_auth_model');

        $this->expense_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->expense_model, $method)) {
            throw new Exception('Undefined method Expense::' . $method . '() called');
        }

        return call_user_func_array(array($this->expense_model, $method), $arguments);
    }

    /**
     * __get
     *
     * Enables the use of CI super-global without having to define an extra variable.
     *
     * I can't remember where I first saw this, so thank you if you are the original author. -Militis
     *
     * @access	public
     * @param	$var
     * @return	mixed
     */
    public function __get($var) {
        return get_instance()->$var;
    }
    
    public function get_expenses($expense_type_id, $reference_id, $start_time, $end_time)
    {
        $expense_list = array();
        $expense_list_array = $this->expense_model->get_expenses($expense_type_id, $reference_id, $start_time, $end_time)->result_array();
        foreach($expense_list_array as $expense_info)
        {
            $expense_info['expense_date'] = $this->utils->process_time($expense_info['expense_date']);
            $expense_info['category_title'] = '';
            $expense_info['category_description'] = '';
            $expense_list[] = $expense_info;
        }
        return $expense_list;
    }
    
    public function get_all_expenses($start_time, $end_time)
    {
        $shop_id = 0;
        $shop_name = '';
        $expensed_supplier_id_list_array = array();
        $expensed_salesman_id_list_array = array();
        $supplier_id_info_map = array();
        $salesman_id_info_map = array();
        
        $expense_list = array();
        $expense_list_array = $this->expense_model->get_all_expenses($start_time, $end_time)->result_array();
        //print_r($expense_list_array);
        foreach($expense_list_array as $expense_info)
        {
            if($expense_info['expense_type_id'] == $this->expense_type_list['shop'])
            {
                $shop_id = $expense_info['reference_id'];                
            }
            else if($expense_info['expense_type_id'] == $this->expense_type_list['supplier'])
            {
                if( !in_array($expense_info['reference_id'], $expensed_supplier_id_list_array) )
                {
                    $expensed_supplier_id_list_array[] = $expense_info['reference_id'];
                }
            }
            else if($expense_info['expense_type_id'] == $this->expense_type_list['user'])
            {
                if( !in_array($expense_info['reference_id'], $expensed_salesman_id_list_array) )
                {
                    $expensed_salesman_id_list_array[] = $expense_info['reference_id'];
                }
            }
        }
        $supplier_list_array = $this->ion_auth->get_all_suppliers(0, $expensed_supplier_id_list_array)->result_array();
        foreach($supplier_list_array as $supplier_info)
        {
            $supplier_id_info_map[$supplier_info['supplier_id']] = $supplier_info;
        }
        $salesman_list_array = $this->ion_auth->get_all_salesman(0, $expensed_salesman_id_list_array)->result_array();
        foreach($salesman_list_array as $salesman_info)
        {
            $salesman_id_info_map[$salesman_info['user_id']] = $salesman_info;
        }
        $shop_info_array = $this->shop_library->get_shop($shop_id)->result_array();
        if(!empty($shop_info_array))
        {
            $shop_name = $shop_info_array[0]['name'];
        }
        foreach($expense_list_array as $expense_info)
        {
            if($expense_info['expense_type_id'] == $this->expense_type_list['shop'])
            {
                  $expense_info['category_title'] = 'Shop';
                  $expense_info['category_description'] = $shop_name;
            }
            else if($expense_info['expense_type_id'] == $this->expense_type_list['supplier'])
            {
                  $expense_info['category_title'] = 'Supplier';
                  $expense_info['category_description'] = $supplier_id_info_map[$expense_info['reference_id']]['first_name'].' '.$supplier_id_info_map[$expense_info['reference_id']]['last_name'];
            }
            else if($expense_info['expense_type_id'] == $this->expense_type_list['user'])
            {
                  $expense_info['category_title'] = 'Staff';
                  $expense_info['category_description'] = $salesman_id_info_map[$expense_info['reference_id']]['first_name'].' '.$salesman_id_info_map[$expense_info['reference_id']]['last_name'];
            }
            if($expense_info['expense_type_id'] == $this->expense_type_list['other'])
            {
                  $expense_info['category_title'] = 'Other';
                  $expense_info['category_description'] = '';
            }
            $expense_info['expense_date'] = $this->utils->process_time($expense_info['expense_date']);
            $expense_list[] = $expense_info;
        }
        return $expense_list;
    }
}
