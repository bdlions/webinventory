<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Transaction Library
 * Added in Class Diagram
 * Requirements: PHP5 or above
 *
 */
class Transaction_library extends Ion_auth{
    /**
     * __construct
     *
     * @return void
     * @author Ben
     * */
    public function __construct() {
        $this->load->config('ion_auth', TRUE);
        $this->load->library('email');
        $this->lang->load('ion_auth');
        $this->load->helper('cookie');
        $this->load->library('org/common/utils');
        $this->load->model('org/transaction/transaction_model');

        // Load the session, CI2 as a library, CI3 uses it as a driver
        if (substr(CI_VERSION, 0, 1) == '2') {
            $this->load->library('session');
        } else {
            $this->load->driver('session');
        }

        // Load IonAuth MongoDB model if it's set to use MongoDB,
        // We assign the model object to "ion_auth_model" variable.
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->model('ion_auth_mongodb_model', 'ion_auth_model') :
                        $this->load->model('ion_auth_model');

        $email_config = $this->config->item('email_config', 'ion_auth');

        if ($this->config->item('use_ci_email', 'ion_auth') && isset($email_config) && is_array($email_config)) {
            $this->email->initialize($email_config);
        }

        $this->transaction_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->transaction_model, $method)) {
            throw new Exception('Undefined method transaction_model::' . $method . '() called');
        }

        return call_user_func_array(array($this->transaction_model, $method), $arguments);
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
    
    /*
     * This method will return supplier transactions handling time synchronization
     * @param $supplier_id, supplier id
     * @Author Nazmul on 15th January 2015
     */
    public function get_supplier_transactions($supplier_id)
    {
        $supplier_transaction_list = array();
        $supplier_transactions_array = $this->transaction_model->get_supplier_transactions($supplier_id)->result_array();
        //handle time synchronization
        if(!empty($supplier_transactions_array))
        {
            foreach($supplier_transactions_array as $supplier_transaction)
            {
                $supplier_transaction['created_on'] = $this->utils->process_time($supplier_transaction['created_on']);
                $supplier_transaction_list[] = $supplier_transaction;
            }
        }
        return $supplier_transaction_list;
    }
    /*
     * This method will return customer transactions handling time synchronization
     * @param $customer_id, customer id
     * @Author Nazmul on 15th January 2015
     */
    public function get_customer_transactions($customer_id)
    {
        $customer_transaction_list = array();
        $customer_transactions_array = $this->transaction_model->get_customer_transactions($customer_id)->result_array();
        //handle time synchronization
        if(!empty($customer_transactions_array))
        {
            foreach($customer_transactions_array as $customer_transaction)
            {
                $customer_transaction['created_on'] = $this->utils->process_time($customer_transaction['created_on']);
                $customer_transaction_list[] = $customer_transaction;
            }
        }
        return $customer_transaction_list;
    }
}
