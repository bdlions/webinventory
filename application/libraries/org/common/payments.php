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
class Payments {
    /**
     * __construct
     *
     * @return void
     * @author Ben
     * */
    public function __construct() {
        $this->load->config('ion_auth', TRUE);
        $this->load->library('org/common/utils');
        $this->load->library('org/purchase/purchase_library');
        $this->load->library('org/stock/stock_library');
        $this->load->model('org/common/payments_model');

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

        $this->payments_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->payments_model, $method)) {
            throw new Exception('Undefined method Payments::' . $method . '() called');
        }

        return call_user_func_array(array($this->payments_model, $method), $arguments);
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
    
    public function get_supplier_current_due($supplier_id)
    {
        $total_purchase_price = 0;
        $total_payment = 0;
        $total_returned_payment = 0;
        $supplier_purchased_product_list_array = $this->stock_library->get_supplier_purchase_list($supplier_id)->result_array();
        foreach($supplier_purchased_product_list_array as $product_info)
        {
            $total_purchase_price = $total_purchase_price + ($product_info['total_purchased']*$product_info['unit_price']);
        }
        $total_payment_array = $this->payments_model->get_supplier_total_payment($supplier_id)->result_array();
        if( !empty($total_payment_array) )
        {
            $total_payment = $total_payment_array[0]['total_payment'];
        }
        $total_returned_payment_array = $this->payments_model->get_supplier_total_returned_payment($supplier_id)->result_array();
        if( !empty($total_returned_payment_array) )
        {
            $total_returned_payment = $total_returned_payment_array[0]['total_returned_payment'];
        }
        return $total_purchase_price - $total_payment + $total_returned_payment;
    }
    
    public function get_customer_current_due($customer_id)
    {
        $total_sale_price = 0;
        $total_payment = 0;
        $total_returned_payment = 0;
        $customer_sale_product_list_array = $this->stock_library->get_customer_purchase_list($customer_id)->result_array();
        foreach($customer_sale_product_list_array as $product_info)
        {
            $total_sale_price = $total_sale_price + ($product_info['total_sale']*$product_info['unit_price']);
        }
        $total_payment_array = $this->payments_model->get_customer_total_payment($customer_id)->result_array();
        if( !empty($total_payment_array) )
        {
            $total_payment = $total_payment_array[0]['total_payment'];
        }
        $total_returned_payment_array = $this->payments_model->get_customer_total_returned_payment($customer_id)->result_array();
        if( !empty($total_returned_payment_array) )
        {
            $total_returned_payment = $total_returned_payment_array[0]['total_returned_payment'];
        }
        return $total_sale_price - $total_payment + $total_returned_payment;
    }
    
    public function get_daily_sale_due_list()
    {
        $sale_due_list = array();
        $sale_order_no_customer_info_map = array();
        $sale_order_no_sale_info_map = array();
        $sale_order_no_payment_info_map = array();
        $time = $this->utils->get_current_date_start_time();
        $sale_list_array = $this->sale_library->get_daily_sales($time)->result_array();
        foreach($sale_list_array as $sale_info)
        {
            if(!array_key_exists($sale_info['sale_order_no'], $sale_order_no_sale_info_map))
            {
                $sale_order_no_sale_info_map[$sale_info['sale_order_no']] = $sale_info['sale_unit_price']*$sale_info['total_sale'];
                $sale_order_no_customer_info_map[$sale_info['sale_order_no']] = array(
                    'first_name' => $sale_info['customer_first_name'],
                    'last_name' => $sale_info['customer_last_name'],
                    'card_no' => $sale_info['card_no']
                );
                $sale_order_no_payment_info_map[$sale_info['sale_order_no']] = '';
            }
            else
            {
                $sale_order_no_sale_info_map[$sale_info['sale_order_no']] = $sale_order_no_sale_info_map[$sale_info['sale_order_no']] + $sale_info['sale_unit_price']*$sale_info['total_sale'];
            }
        }
        $customer_payment_list_array = $this->payments_model->get_customer_payment_list_today($time)->result_array();
        foreach($customer_payment_list_array as $customer_payment_info)
        {
            $sale_order_no_payment_info_map[$customer_payment_info['sale_order_no']] = $customer_payment_info['total_payment'];
        }
        foreach($sale_order_no_sale_info_map as $key => $value)
        {
            if( $value > $sale_order_no_payment_info_map[$key])
            {
                $sale_due_info = array(
                    'first_name' => $sale_order_no_customer_info_map[$key]['first_name'],
                    'last_name' => $sale_order_no_customer_info_map[$key]['last_name'],
                    'card_no' => $sale_order_no_customer_info_map[$key]['card_no'],
                    'amount' => $value - $sale_order_no_payment_info_map[$key]
                );
                $sale_due_list[] = $sale_due_info;
            }
        }
        return $sale_due_list;
    }
}
