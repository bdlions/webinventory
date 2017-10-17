<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Requirements: PHP5 or above
 *
 */
class Ecommerce_library {
    public function __construct() {
        $this->load->config('ion_auth', TRUE);
        //$this->load->library('email');
        //$this->load->library('org/common/sms_configuration');
        $this->load->library('org/product/product_library');
        $this->load->library('org/stock/stock_library');
        $this->lang->load('ion_auth');
        $this->load->helper('cookie');

        // Load the session, CI2 as a library, CI3 uses it as a driver
        if (substr(CI_VERSION, 0, 1) == '2') {
            $this->load->library('session');
        } else {
            $this->load->driver('session');
        }
        
        require_once(str_replace("\\","/",APPPATH).'libraries/nusoaplib/nusoap'.EXT); //If we are executing this script on a Windows server
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        throw new Exception('Undefined method Ecommerce_library::' . $method . '() called');
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
    
    public function update_ecommerce_stock($ec_product_info_list = array())
    {
        /*$product_list_array = $this->product_library->get_all_products()->result_array();
        $stock_list_array = $this->stock_library->search_stocks()->result_array();
        $product_id_name_map = array();
        $product_stock_map = array();
        foreach($product_list_array as $temp_product_info)
        {
            $product_id_name_map[$temp_product_info['product_id']] = $temp_product_info['name'];
        }
        //print_r($product_id_name_map);
        foreach($stock_list_array as $temp_stock)
        {
            $product_stock_map[$temp_stock['product_name'].'-'.$temp_stock['purchase_order_no'].'-'.$temp_stock['product_category1'].'-'.$temp_stock['product_size']] = $temp_stock['current_stock'];
        }
        //print_r($product_stock_map);
        foreach($ec_product_info_list as $ec_product_info)
        {
            $product_identity = $product_id_name_map[$ec_product_info['product_id']].'-'.$ec_product_info['purchase_order_no'].'-'.$ec_product_info['product_category1'].'-'.$ec_product_info['product_size'];
            $stock = 0;
            if(array_key_exists($product_identity, $product_stock_map))
            {
                $stock = $product_stock_map[$product_identity];
            }
            //print_r($product_identity.":".$stock);
            $this->curl->create("http://localhost/ecommercestocksync/stocksync");
            $this->curl->post(array("product_identifier" => $product_identity, "stock" => $stock));
            $this->curl->execute();
            //$result_event = json_decode($this->curl->execute());
            //print_r('webservice response:'.$this->curl->execute());
        }*/
    }
}
