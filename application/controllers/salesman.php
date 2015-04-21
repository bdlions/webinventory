<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include APPPATH.'controllers/user.php';
class Salesman extends User {
    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
        
        if(!$this->ion_auth->logged_in())
        {
            redirect("user/login","refresh");
        }
    }
    
    function index()
    {
        //write your code if required
    } 
    /*
     * This method will create a salesman
     * @Author nazmul on 16th January 2015
     */
    public function create_salesman() {
        $this->data['message'] = '';
        $this->form_validation->set_rules('phone', 'Phone', 'xss_clean|required');
        $this->form_validation->set_rules('username', 'User Name', 'xss_clean|required');
        $this->form_validation->set_rules('email', 'Email', 'xss_clean');
        $this->form_validation->set_rules('country_code', 'Country Code', 'xss_clean|required');
        $this->form_validation->set_rules('phone', 'Phone', 'xss_clean|required');
        $this->form_validation->set_rules('first_name', 'First Name', 'xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'xss_clean');
        $this->form_validation->set_rules('address', 'Address', 'xss_clean');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->input->post('submit_create_salesman')) {
            if ($this->form_validation->run() == true) {
                $user_name = $this->input->post('username');
                $password = $this->input->post('password');
                $email = $this->input->post('email');
                $phone_no =$this->input->post('country_code').$this->input->post('phone');
                $additional_data = array(
                    'account_status_id' => ACCOUNT_STATUS_ACTIVE,
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'phone' => $phone_no,
                    'address' => $this->input->post('address'),
                    'created_on' => now()
                );
                $groups = array('id' => USER_GROUP_SALESMAN);
                $user_id = $this->ion_auth->register($user_name, $password, $email, $additional_data, $groups);
                if ($user_id !== FALSE) {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect("salesman/create_salesman", "refresh");
                } else {
                    $this->data['message'] = $this->ion_auth->errors();
                }
            } else {
                $this->data['message'] = validation_errors();
            }
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }

        $this->data['country_code'] = array(
            'name' => 'country_code',
            'id' => 'country_code',
            'type' => 'text',
            'value' => $this->form_validation->set_value('country_code'),
        );
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'value' => $this->form_validation->set_value('phone'),
        );
        $this->data['username'] = array(
            'name' => 'username',
            'id' => 'username',
            'type' => 'text',
            'value' => $this->form_validation->set_value('username'),
        );
        $this->data['email'] = array(
            'name' => 'email',
            'id' => 'email',
            'type' => 'text',
            'value' => $this->form_validation->set_value('email'),
        );
        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('first_name'),
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('last_name'),
        );
        $this->data['address'] = array(
            'name' => 'address',
            'id' => 'address',
            'type' => 'textarea',
            'value' => $this->form_validation->set_value('address'),
        );
        $this->data['password'] = array(
            'name' => 'password',
            'id' => 'password',
            'type' => 'password',
            'value' => $this->form_validation->set_value('password'),
        );
        $this->data['password_confirm'] = array(
            'name' => 'password_confirm',
            'id' => 'password_confirm',
            'type' => 'password',
            'value' => $this->form_validation->set_value('password_confirm'),
        );
        $this->data['submit_create_salesman'] = array(
            'name' => 'submit_create_salesman',
            'id' => 'submit_create_salesman',
            'type' => 'submit',
            'value' => 'Create',
        );
        $this->template->load(null, 'salesman/create_salesman', $this->data);
    }
    /*
     * This method will show all salesmen
     * @Author nazmul on 16th January 2015
     */
    public function show_all_salesmen() {
        $this->data['salesman_list'] = array();
        $salesman_list_array = $this->ion_auth->get_all_salesmen()->result_array();
        if (!empty($salesman_list_array)) {
            $this->data['salesman_list'] = $salesman_list_array;
        }
        $this->template->load(null, 'salesman/show_all_salesmen', $this->data);
    }
    /*
     * This method will update a salesman
     * @param $user_id, user id
     * @Author nazmul on 16th January 2015
     */
    public function update_salesman($user_id = 0) {
        if ($user_id == 0) {
            redirect("salesman/show_all_salesmen", "refresh");
        }
        //validate if current user has permission to update the staff
        $this->data['message'] = '';
        $this->form_validation->set_rules('phone', 'Phone', 'xss_clean|required');
        $this->form_validation->set_rules('first_name', 'First Name', 'xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'xss_clean');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
        $this->form_validation->set_rules('address', 'Address', 'xss_clean');

        $user_info = array();
        $user_info_array = $this->ion_auth->get_user_info($user_id)->result_array();
        if (empty($user_info_array)) {
            redirect("salesman/show_all_salesmen", "refresh");
        } else {
            $user_info = $user_info_array[0];
        }
        $this->data['user_info'] = $user_info;
        if ($this->input->post('submit_update_salesman')) {
            if ($this->form_validation->run() == true) {
                $additional_data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'phone' => $this->input->post('phone'),
                    'address' => $this->input->post('address'),
                    'modified_on' => now()
                );
                if ($this->input->post('password') !== PSD_DUMMY) {
                    $additional_data['password'] = $this->input->post('password');
                }
                if ($this->ion_auth->update($user_id, $additional_data)) {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect("salesman/update_salesman/" . $user_info['user_id'], "refresh");
                } else {
                    $this->data['message'] = $this->ion_auth->errors();
                }
            } else {
                $this->data['message'] = validation_errors();
            }
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }

        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $user_info['phone'],
        );
        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $user_info['first_name'],
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $user_info['last_name'],
        );
        $this->data['password'] = array(
            'name' => 'password',
            'id' => 'password',
            'type' => 'password',
            'value' => PSD_DUMMY,
        );
        $this->data['password_confirm'] = array(
            'name' => 'password_confirm',
            'id' => 'password_confirm',
            'type' => 'password',
            'value' => PSD_DUMMY,
        );
        $this->data['address'] = array(
            'name' => 'address',
            'id' => 'address',
            'type' => 'textarea',
            'value' => $user_info['address'],
        );
        $this->data['submit_update_salesman'] = array(
            'name' => 'submit_update_salesman',
            'id' => 'submit_update_salesman',
            'type' => 'submit',
            'value' => 'Update',
        );
        $this->template->load(null, 'salesman/update_salesman', $this->data);
    }
}
