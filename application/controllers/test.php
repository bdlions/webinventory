<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
    /*
     * Holds account status list
     * 
     * $var array
     */

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('sms_library');
        $this->load->library('org/common/utils');
        $this->load->library('org/common/expenses');
        $this->load->library('org/common/payments');
        $this->load->library('org/purchase/purchase_library');
        $this->load->library('org/sale/sale_library');
        $this->load->library('org/stock/stock_library');
        $this->load->library('org/product/product_library');
        $this->load->helper('url');
        $this->load->helper('file');

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
    }
    
    function index()
    {
        print_r($this->purchase_library->get_total_purchase_price(1)->result_array());
    }
    
    public function test1()
    {
        /*$counter = 0;
        for($counter = 0 ; $counter < 1000 ; $counter++)
        {
            $first_name = 'Nazmul'.$counter;
            $last_name = 'Hasan'.$counter;
            $phone_no = $counter;
            $card_no = $counter;
            $user_name = '';
            $password = "password";
            $email = "dummy@dummy.com";
            $additional_data = array(
                'card_no' => $card_no,
                'account_status_id' => 1,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'phone' => $phone_no,
                'created_date' => date('Y-m-d H:i:s')
            );
            $groups = array('id' => 5);
            $user_id = $this->ion_auth->register($user_name, $password, $email, $additional_data, $groups);
        }*/
        print_r($this->payments->get_daily_sale_due_list());
    }
    
}
