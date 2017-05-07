<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Stock Library
 * @Autor Nazmul on 27th January 2015
 * Requirements: PHP5 or above
 *
 */
class Stock_library {
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
        $this->load->model('org/stock/stock_model');

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

        $this->stock_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->stock_model, $method)) {
            throw new Exception('Undefined method Stock_library::' . $method . '() called');
        }

        return call_user_func_array(array($this->stock_model, $method), $arguments);
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
     * This method will retunr showroom purchase list
     * @param $purchase_order_no, purchase order no
     * @param $shop_id, shop id
     * @Author Nazmul on 27th January 2015
     */
    public function get_showroom_purchase_transactions($purchase_order_no, $shop_id = 0, $product_category1 = '', $product_size = '')
    {
        $transaction_list = array();
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $transactions_array = $this->stock_model->get_showroom_purchase_transactions($purchase_order_no, $shop_id, $product_category1, $product_size)->result_array();
        foreach($transactions_array as $transactions_info)
        {
            $transactions_info['created_on'] = $this->utils->process_time($transactions_info['created_on']);
            $transactions_info['quantity'] = 0;
            if($transactions_info['transaction_category_id'] == STOCK_PURCHASE_PARTIAL_IN || $transactions_info['transaction_category_id'] == STOCK_PURCHASE_IN)
            {
                $transactions_info['quantity'] = $transactions_info['stock_in'];
            }
            else if($transactions_info['transaction_category_id'] == STOCK_PURCHASE_PARTIAL_OUT)
            {
                $transactions_info['quantity'] = $transactions_info['stock_out'];
            }
            $transaction_list[] = $transactions_info;
        }
        return $transaction_list;
    }
    
    /*
     * This method will retunr warehouse purchase list
     * @param $purchase_order_no, purchase order no
     * @param $shop_id, shop id
     * @Author Nazmul on 27th January 2015
     */
    public function get_warehouse_purchase_transactions($purchase_order_no, $shop_id = 0, $product_category1 = '', $product_size = '')
    {
        $transaction_list = array();
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $transactions_array = $this->stock_model->get_warehouse_purchase_transactions($purchase_order_no, $shop_id, $product_category1, $product_size)->result_array();
        foreach($transactions_array as $transactions_info)
        {
            $transactions_info['created_on'] = $this->utils->process_time($transactions_info['created_on']);
            $transactions_info['quantity'] = 0;
            if($transactions_info['transaction_category_id'] == STOCK_PURCHASE_PARTIAL_IN || $transactions_info['transaction_category_id'] == STOCK_PURCHASE_IN)
            {
                $transactions_info['quantity'] = $transactions_info['stock_in'];
            }
            else if($transactions_info['transaction_category_id'] == STOCK_PURCHASE_PARTIAL_OUT)
            {
                $transactions_info['quantity'] = $transactions_info['stock_out'];
            }
            $transaction_list[] = $transactions_info;
        }
        return $transaction_list;
    }
}
