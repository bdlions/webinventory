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
    
//    public function loogin()
//    {
//        //bad
//        $this->template->load(null, "loogin");
//    }
    public function signup()
    {
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
        $this->form_validation->set_rules('username', 'User Name', 'required');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->input->post('submit_create_manager')) {
            //$privatekey = "6Lf8YfESAAAAAHAsDzHvv0ESHdrFIe0k0pIDa542";
            $privatekey = "6LctLfISAAAAAP_6q1pftugclrynNTLprwXFIXOD";//bdlions@gmail.com
            $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

            if ($resp->is_valid) 
            {
                if ($this->form_validation->run() == true) 
                {
                    // call functions when verification is successfull
                    //$this->template->load(NULL, "manager/create_admin", $this->data);
                    $user_name = $this->input->post('username');
                    $email = $this->input->post('email');
                    $password = $this->input->post('password');
                    $additional_data = array(
                        'account_status_id' => $this->account_status_list['active_id'],
                        'first_name' => $this->input->post('first_name'),
                        'last_name' => $this->input->post('last_name'),
                        'phone' => $this->input->post('phone'),
                        'address' => $this->input->post('address'),
                        'created_date' => date('Y-m-d H:i:s'),
                        'sms_code' => rand(1, 999999999)
                    );
                    $groups = array('id' => $this->user_group['manager_id']);
                    $user_id = $this->ion_auth->register($user_name, $password, $email, $additional_data, $groups);
                    if ($user_id !== FALSE) {
                        $this->ion_auth->admin_registration_email(array(), $email);
                        $this->sms_library->send_sms($this->input->post('phone'), $additional_data['sms_code'], false);
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect("user/manager_login", "refresh");

                        echo 'Signup successful';
                        $this->template->load(NULL, "user/manager_login", 'refresh');
                    } else {
                        $this->data['message'] = $this->ion_auth->errors();
                    }
                } 
                else 
                {
                    $this->data['message'] = validation_errors();
                }
            } 
            else 
            {
                $this->data['message'] = 'Invalid captcha.';
            }
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }
    }
    public function login()
    {
        
        $this->template->load(null, "liggin");
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
