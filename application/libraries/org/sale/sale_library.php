<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Sale Library
 * @Author Nazmul on 26th January 2015
 * Requirements: PHP5 or above
 *
 */
class Sale_library {

    /**
     * account status ('not_activated', etc ...)
     *
     * @var string
     * */
    protected $status;

    /**
     * extra where
     *
     * @var array
     * */
    public $_extra_where = array();

    /**
     * extra set
     *
     * @var array
     * */
    public $_extra_set = array();

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
        $this->load->model('org/sale/sale_model');

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

        $this->sale_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->sale_model, $method)) {
            throw new Exception('Undefined method Sale_library::' . $method . '() called');
        }

        return call_user_func_array(array($this->sale_model, $method), $arguments);
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
     * This method will return customer list based on total purchase
     * @param $total_purchase, total purchase
     * @Author Nazmul on 26th January 2015
     */
    public function get_customer_list_by_total_purchased($total_purchased)
    {
        $customer_list = array();
        $customer_id_list = array();
        $customer_id_total_products_map = array();
        $sale_list_array = $this->sale_model->get_all_sales()->result_array();
        foreach($sale_list_array as $sale_info)
        {
            if(!array_key_exists($sale_info['customer_id'], $customer_id_total_products_map))
            {
                $customer_id_total_products_map[$sale_info['customer_id']] = $sale_info['total_sale'];
            }
            else
            {
                $customer_id_total_products_map[$sale_info['customer_id']] = $customer_id_total_products_map[$sale_info['customer_id']] + $sale_info['total_sale'];
            }
        }
        foreach($customer_id_total_products_map as $customer_id => $total_products)
        {
            if($total_products == $total_purchased)
            {
                $customer_id_list[] = $customer_id;
            }
        }
        if(!empty($customer_id_list))
        {
            $shop_info = array();
            $shop_info_array = $this->shop_library->get_shop()->result_array();
            if(!empty($shop_info_array))
            {
                $shop_info = $shop_info_array[0];
                $customer_list = $this->ion_auth->get_customer_list($customer_id_list, $shop_info['shop_id'], $shop_info['shop_type_id'])->result_array(); 
            }            
        }
        return $customer_list;
    }
    
    //not reusable yet
    function sale_pdf_generation($sale_array = NULL) {

        $pdf = new Risk_register_pdf('L');

        $style_xml = simplexml_load_file(base_url().'resources/pdf/xml/sale_pdf_style/sale_pdf_style.xml');
        $arr = json_decode(json_encode($style_xml), TRUE);
        $style_array = $arr['document'];
        
        $xml = simplexml_load_file(base_url().'resources/pdf/xml/sale_data_xml.xml');
        $arr = json_decode(json_encode($xml), TRUE);
//        foreach ($arr as $key => $value) {
//            var_dump($key);
//            var_dump($value);
//        }
//        var_dump($arr['risk-register']['report-request']['risk-register-rows']);exit;
        $pdf->load_data($arr, $style_array);
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->generate_pdf();
        $file_path = '././assets/receipt/';
        
        $file_name = uniqid(date("d-m-yy")).'.pdf';
        $pdf->Output($file_path.'pdf_sample', 'F');
        
        echo "Your generated pdf is : ".$file_path.$file_name;
       
    }
}
