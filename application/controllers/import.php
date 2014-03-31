<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends CI_Controller {
    /*
     * Holds account status list
     * 
     * $var array
     */

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
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
        
    }
    
    public function import_customer()
    {
        $lines = file('resources/customer_info.txt');
        $counter = 0;
        $total_duplicate = 0;
        $card_no_array = array();
        foreach ($lines as $line) 
        {            
            $splited_content = explode("|", $line);
            $card_no = $splited_content[1];
            if(!in_array($card_no,$card_no_array))
            {
                if($card_no >= 8001 && $card_no <= 100000)
                {
                    $card_no_array[] = $card_no;
                    $additional_data = array(
                        'card_no' => $splited_content[1],
                        'account_status_id' => ACCOUNT_STATUS_ACTIVE,
                        'first_name' => $splited_content[2],
                        'phone' => '88'.$splited_content[3],
                        'profession_id' => $splited_content[4],
                        'institution_id' => $splited_content[5],
                        'created_date' => now()
                    );
                    $groups = array('id' => USER_GROUP_CUSTOMER);
                    $user_name = '';
                    $password = "password";
                    $email = "dummy@dummy.com";
                    $user_id = $this->ion_auth->register($user_name, $password, $email, $additional_data, $groups); 
                    if( $user_id !== FALSE )
                    {
                        //print_r('user_id:'.$user_id);
                    }
                    else
                    {
                        print_r($this->ion_auth->errors_alert());
                        print_r($additional_data);
                        break;
                    }
                    $counter++;
                }
            }
            else
            {
                $total_duplicate++;
            }                      
        }
        print_r('Total duplicate entries:'.$total_duplicate);
        print_r('Total entry stored:'.$counter);
    }
    
    public function import_supplier()
    {
        $lines = file('resources/supplier_info.txt');
        $counter = 0;
        foreach ($lines as $line) 
        {            
            $splited_content = explode("|", $line);
            $additional_data = array(
                'account_status_id' => ACCOUNT_STATUS_ACTIVE,
                'first_name' => $splited_content[1],
                'phone' => '88'.$splited_content[2],
                'address' => $splited_content[3],
                'company' => '',
                'created_date' => now()
            );
            $groups = array('id' => USER_GROUP_SUPPLIER);
            $user_name = '';
            $password = "password";
            $email = "dummy@dummy.com";
            $user_id = $this->ion_auth->register($user_name, $password, $email, $additional_data, $groups); 
            if( $user_id !== FALSE )
            {
                //print_r('user_id:'.$user_id);
            }
            else
            {
                print_r($this->ion_auth->errors_alert());
                print_r($additional_data);
                break;
            }
            $counter++;                      
        }
        print_r('Total entry stored:'.$counter);
    }
}
