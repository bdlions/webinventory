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
        $this->load->library('org/purchase/purchase_library');
        $this->load->library('org/sale/sale_library');
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
        //$start_time = $this->utils->get_current_date_start_time();
        //$end_time = $start_time + 86400;
        //$this->expenses->get_all_expenses($start_time, $end_time);
        print_r($this->sale_library->test(9)->result_array());
        /*$gmt_unix_current_time = now();
        $local_unix_current_time = ($gmt_unix_current_time + 21600);
        $local_human_current_time = unix_to_human($local_unix_current_time);
        $local_human_current_time_array= explode(" ", $local_human_current_time);
        $local_human_current_date = $local_human_current_time_array[0];
        $local_human_current_date_start_time = $local_human_current_date.' 00:00 AM';
        $unix_local_current_date_start_time = human_to_unix($local_human_current_date_start_time);
        $unix_gmt_current_date_start_time = ($unix_local_current_date_start_time - 21600);*/
        
        
        
        
        /*$now = now();
        //$now = time();
        //print_r($now);
        $human = unix_to_human($now);
        print_r($human);
        //$unix = human_to_unix($human);
        //print_r($unix);
        
        //$unix2 = human_to_unix('2014-02-22 00:00 AM');
        //print_r($unix2);*/
    }
    
}
