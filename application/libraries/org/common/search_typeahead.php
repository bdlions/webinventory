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
class Search_typeahead {
    /**
     * __construct
     *
     * @return void
     * @author Ben
     * */
    public function __construct() {
        $this->load->config('ion_auth', TRUE);
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
                        $this->load->model('org/common/search_typeahead_model');

        $this->search_typeahead_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->search_typeahead_model, $method)) {
            throw new Exception('Undefined method search_typeahead_model::' . $method . '() called');
        }

        return call_user_func_array(array($this->search_typeahead_model, $method), $arguments);
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
     * This method will return customer list adding value field appending first_name, last_name, phone and card_no
     * @param $search_value, value to be searched in first_name/last_name/phone/card_no
     * @param $shop_id, shop id
     * @author Nazmul on 19th June 2014
     */
    public function get_customers($search_value, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $customer_list = array();
        $customers = $this->search_typeahead_model->get_customers($search_value, $shop_id);
        foreach ($customers as  $customer) {
            $customer->value = $customer -> first_name . " ". $customer -> last_name . " ". $customer -> phone ." ". $customer->card_no ;
            array_push($customer_list, $customer);
        }
        return $customer_list;
    }
    
    /*
     * This method will return supplier list adding value field appending first_name, last_name, phone and company
     * @param $search_value, value to be searched in first_name/last_name/phone/company
     * @param $shop_id, shop id
     * @author Nazmul on 19th June 2014
     */
    public function get_suppliers($search_value, $shop_id = 0) {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $supplier_list = array();
        $suppliers = $this->search_typeahead_model->get_suppliers($search_value, $shop_id);
        foreach ($suppliers as  $supplier) {
            $supplier -> value = $supplier -> first_name . " ". $supplier -> last_name . " ". $supplier -> phone . " " . $supplier -> company;
            array_push($supplier_list, $supplier);
        }
        return $supplier_list;
    }
}
