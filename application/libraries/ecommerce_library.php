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
        
    }
}
