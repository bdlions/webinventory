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
        $this->load->library('org/purchase/purchase_library');
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
        $now = time();
        print_r($now);
        $human = unix_to_human($now);
        print_r($human);
        $unix = human_to_unix($human);
        //print_r($unix);
        
        $unix2 = human_to_unix('2014-02-22 00:00 AM');
        print_r($unix2);
    }
    
}
