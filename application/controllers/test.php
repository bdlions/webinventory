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
        $this->load->helper('recaptchalib_helper');

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
    }

    function index() {
        print_r($this->purchase_library->get_total_purchase_price(1)->result_array());
    }

    public function test1() {
        /* $counter = 0;
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
          } */
        print_r($this->payments->get_daily_sale_due_list());
    }

    public function smsVerification() {
        $verification_code = $this->input->post("verification_code");
        $realcode = 'asd';
        $this->data['message'] = "ok";

        if ($verification_code == $realcode) {
            $this->template->load(NULL, "admin/admin_login", $this->data);
        } else {
            $this->data['message'] = "notok";
            $this->template->load(NULL, "sms/smsVerification", $this->data);
        }
    }

    public function create_admin() {
        
        $this->data['message'] = '';
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
        $this->form_validation->set_rules('username', 'User Name', 'required');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
        
        
        
        //$this->template->load(NULL, "manager/crate_admin_temp");\
        $this->data['message'] = '';
        $this->data['first_name'] = array('type' => 'text', 'name' => 'first_name', 'id' => 'first_name', 'value' => $this->input->post('first_name'));
        $this->data['last_name'] = array('type' => 'text', 'name' => 'last_name', 'id' => 'last_name', 'value' => $this->input->post('last_name'));
        $this->data['email'] = array('type' => 'text', 'name' => 'email', 'id' => 'email', 'value' => $this->input->post('email'));
        $this->data['phone'] = array('type' => 'text', 'name' => 'phone', 'id' => 'phone', 'value' => $this->input->post('phone'));
        $this->data['username'] = array('type' => 'text', 'name' => 'username', 'id' => 'username', 'value' => $this->input->post('username'));
        $this->data['password'] = array('type' => 'text', 'name' => 'password', 'id' => 'password');
        $this->data['password_confirm'] = array('type' => 'text', 'name' => 'password_confirm', 'id' => 'password_confirm');
        $this->data['submit_create_admin'] = array('type' => 'submit', 'name' => 'submit_create_admin', 'id' => 'submit_create_admin', 'value' => 'Register');
        $this->template->load(NULL, "manager/create_admin", $this->data);

        if($this->input->post('submit_create_admin')) 
        {
            //echo '<pre/ >'; print_r($_POST); exit('mkl');
            
            $privatekey = "6Lf8YfESAAAAAHAsDzHvv0ESHdrFIe0k0pIDa542";
            $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

            if (!$resp->is_valid) {
                // What happens when the CAPTCHA was entered incorrectly
                echo("The reCAPTCHA wasn't entered correctly. Go back and try it again." . "(reCAPTCHA said: " . $resp->error . ")");
                echo '<button type="button" onclick="window.history.back()">Back</button>';
                die();
            }
            else {
                // call functions when verification is successfull
                //$this->template->load(NULL, "manager/create_admin", $this->data);
                echo 'Signup successful';
                $this->template->load(NULL, "user/admin_signup", $this->data);
                
            }
        }

}


public function upload_cover()
    {
        $this->data['message'] = ''; 
        if($this->input->post('submit_upload_cover'))
        {
            $config['upload_path'] = '././assets/images/cover/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '0';
            $config['max_width'] = '0';
            $config['overwrite'] = TRUE;
            $config['max_height'] = '0';
            $config['file_name'] = 'cover.png';
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload()) {
                $this->data['message'] = $this->upload->display_errors();
            } 
            else {

                redirect('test/upload_cover','refresh');
            }
        }
        $this->data['submit_upload_cover'] = array(
            'name' => 'submit_upload_cover',
            'id' => 'submit_upload_cover',
            'type' => 'submit',
            'value' => 'Upload',
        );
        $this->template->load(null, 'upload/upload_cover', $this->data);
    }


}
