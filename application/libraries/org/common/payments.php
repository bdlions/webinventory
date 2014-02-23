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
        $this->load->library('org/purchase/purchase_library');
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
        $total_purchase_price_array = $this->purchase_library->get_total_purchase_price($supplier_id)->result_array();
        if( !empty($total_purchase_price_array) )
        {
            $total_purchase_price = $total_purchase_price_array[0]['total_purchase_price'];
        }
        $total_payment_array = $this->payments_model->get_supplier_total_payment($supplier_id)->result_array();
        if( !empty($total_payment_array) )
        {
            $total_payment = $total_payment_array[0]['total_payment'];
        }
        return $total_purchase_price - $total_payment;
    }
    
    public function get_customer_current_due($customer_id)
    {
        $total_sale_price = 0;
        $total_payment = 0;
        $total_sale_price_array = $this->sale_library->get_total_sale_price($customer_id)->result_array();
        if( !empty($total_sale_price_array) )
        {
            $total_sale_price = $total_sale_price_array[0]['total_sale_price'];
        }
        $total_payment_array = $this->payments_model->get_customer_total_payment($customer_id)->result_array();
        if( !empty($total_payment_array) )
        {
            $total_payment = $total_payment_array[0]['total_payment'];
        }
        return $total_sale_price - $total_payment;
    }
}
