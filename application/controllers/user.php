<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    /*
     * Holds account status list
     * 
     * $var array
     */

    protected $user_group;
    protected $account_status_list;
    public $user_type;
    public $login_uri;
    public $login_success_uri;
    public $login_template;
    public $login_view;

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('sms_library');
        $this->load->library('org/shop/shop_library');
        $this->load->library('org/common/messages');
        $this->load->helper('url');

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');

        //$this->user_type = CUSTOMER;
        $this->user_group = $this->config->item('user_group', 'ion_auth');
        $this->account_status_list = $this->config->item('account_status', 'ion_auth');
        
        
    }

    function manager_login() {

        $this->user_type = MANAGER;

        $this->login_success_uri = MANAGER_LOGIN_SUCCESS_URI;
        $this->login_uri = MANAGER_LOGIN_URI;
        $this->login_template = MANAGER_LOGIN_TEMPLATE;
        $this->login_view = MANAGER_LOGIN_VIEW;

        if (!$this->ion_auth->logged_in()) {
            $this->login();
        } else {
            //set the
            //set flash data error message if there is one
            $user_info_array = $this->ion_auth->get_user_info()->result_array();
            $user_info = $user_info_array[0];
            $shop_info = $this->ion_auth->get_user_shop_info($user_info['id'])->result_array();
            if (empty($shop_info)) {
                redirect('shop/create_shop', 'refresh');
            }
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->template->load(MANAGER_LOGIN_SUCCESS_TEMPLATE, MANAGER_LOGIN_SUCCESS_VIEW, $this->data);
        }
    }

    function salesman_login() {

        $this->user_type = SALESMAN;

        $this->login_success_uri = SALESMAN_LOGIN_SUCCESS_URI;
        $this->login_uri = SALESMAN_LOGIN_URI;
        $this->login_template = SALESMAN_LOGIN_TEMPLATE;
        $this->login_view = SALESMAN_LOGIN_VIEW;

        if (!$this->ion_auth->logged_in()) {
            $this->login();
        } else {
            //set the
            //set flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->template->load(SALESMAN_LOGIN_SUCCESS_TEMPLATE, SALESMAN_LOGIN_SUCCESS_VIEW, $this->data);
        }
    }

    function customer_login() {

        $this->user_type = CUSTOMER;

        $this->login_success_uri = CUSTOMER_LOGIN_SUCCESS_URI;
        $this->login_uri = CUSTOMER_LOGIN_URI;
        $this->login_template = CUSTOMER_LOGIN_TEMPLATE;
        $this->login_view = CUSTOMER_LOGIN_VIEW;

        if (!$this->ion_auth->logged_in()) {
            $this->login();
        } else {
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->template->load(CUSTOMER_LOGIN_SUCCESS_TEMPLATE, CUSTOMER_LOGIN_SUCCESS_VIEW, $this->data);
        }
    }

    public function login() {
        $this->data['message1'] = '';
        $this->data['message2'] = '';

        if ($this->input->post('login_submit_btn')) {
            //validate form input
            $this->form_validation->set_rules('identity', 'Identity', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if ($this->form_validation->run() == true) {
                //check to see if the user is logging in
                //check for "remember me"
                $remember = (bool) $this->input->post('remember');
                if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                    //if the login is successful
                    //redirect them back to the home page
                    $this->session->set_flashdata('message1', $this->ion_auth->messages());
                    $this->user_type = $this->ion_auth->get_current_user_type();
                    if ($this->user_type == SALESMAN) {
                        $this->login_success_uri = SALESMAN_LOGIN_SUCCESS_URI;
                    } else if ($this->user_type == MANAGER) {
                        $this->login_success_uri = MANAGER_LOGIN_SUCCESS_URI;
                        $user_info_array = $this->ion_auth->get_user_info()->result_array();
                        $user_info = $user_info_array[0];
                        if ($user_info['sms_code'] != 0) {
                            redirect('user/account_validation_sms', 'refresh');
                        }
                        $shop_info = $this->ion_auth->get_user_shop_info($user_info['id'])->result_array();

                        if (empty($shop_info)) {
                            redirect('shop/create_shop', 'refresh');
                        }
                    }
                    $shop_info_array = $this->shop_library->get_shop()->result_array();
                    $shop_info = $shop_info_array[0];
                    $logoaddress = base_url() . '/assets/images/' . $shop_info['picture'];
                    $this->session->set_userdata(array('logoaddress' => $logoaddress));
                    redirect($this->login_success_uri, 'refresh');
                } else {
                    $this->session->set_flashdata('message1', $this->ion_auth->errors());
                    redirect(LOGIN_URI, 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
                }
            } else {
                $this->data['message1'] = validation_errors();
            }
        } else if ($this->input->post('submit_create_manager')) {
            $this->data['message2'] = '';
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('phone', 'Phone Number', 'required');
            $this->form_validation->set_rules('username', 'User Name', 'required');
            $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
            $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

            $privatekey = "6LctLfISAAAAAP_6q1pftugclrynNTLprwXFIXOD"; //bdlions@gmail.com
            $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

            if ($resp->is_valid) {
                if ($this->form_validation->run() == true) {
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
                        $this->session->set_flashdata('message2', $this->ion_auth->messages());
                        $this->ion_auth->login($user_name, $password);
                        redirect("user/account_validation_sms", "refresh");
                        
                    } else {
                        $this->data['message2'] = $this->ion_auth->errors();
                    }
                } else {
                    $this->data['message2'] = validation_errors();
                }
            } else {
                $this->data['message2'] = 'Invalid captcha.';
            }
        } else {            
            $this->data['message1'] = $this->session->flashdata('message1');
            $this->data['message2'] = $this->session->flashdata('message2');                        
        }
        $this->data['identity'] = array('name' => 'identity',
            'id' => 'identity',
            'type' => 'text',
            'value' => $this->form_validation->set_value('identity'),
        );
        $this->data['password'] = array('name' => 'password',
            'id' => 'password',
            'type' => 'password'
        );

        $this->data['first_name'] = array('type' => 'text', 'name' => 'first_name', 'id' => 'first_name', 'value' => $this->input->post('first_name'));
        $this->data['last_name'] = array('type' => 'text', 'name' => 'last_name', 'id' => 'last_name', 'value' => $this->input->post('last_name'));
        $this->data['email'] = array('type' => 'email', 'name' => 'email', 'id' => 'email', 'value' => $this->input->post('email'));
        $this->data['phone'] = array('type' => 'text', 'name' => 'phone', 'id' => 'phone', 'value' => $this->input->post('phone'));
        $this->data['username'] = array('type' => 'text', 'name' => 'username', 'id' => 'username', 'value' => $this->input->post('username'));
        $this->data['new_password'] = array('type' => 'new_password', 'name' => 'new_password', 'id' => 'new_password');
        $this->data['password_confirm'] = array('type' => 'password', 'name' => 'password_confirm', 'id' => 'password_confirm');
        $this->data['submit_create_manager'] = array('type' => 'submit', 'name' => 'submit_create_manager', 'id' => 'submit_create_manager', 'value' => 'Register');

        $this->template->load(LOGIN_TEMPLATE, LOGIN_VIEW, $this->data);
    }
    
    /*
     * Ajax Call
     * This method will update user account status to active
     * @Author Nazmul on 16th January 2015
     */
    public function active_user_account_status()
    {
        $result = array();
        $user_id = $this->input->post('user_id');
        $additional_data = array(
            'account_status_id' => ACCOUNT_STATUS_ACTIVE,
            'modified_on' => now()
        );
        if($this->ion_auth->update($user_id, $additional_data))
        {
            $result['message'] = $this->ion_auth->messages_alert();
        }
        else
        {
            $result['message'] = $this->ion_auth->errors_alert();
        }
        echo json_encode($result);
    }
    
    /*
     * Ajax Call
     * This method will update user account status to inactive
     * @Author Nazmul on 16th January 2015
     */
    public function inactive_user_account_status()
    {
        $result = array();
        $user_id = $this->input->post('user_id');
        $additional_data = array(
            'account_status_id' => ACCOUNT_STATUS_INACTIVE,
            'modified_on' => now()
        );
        if($this->ion_auth->update($user_id, $additional_data))
        {
            $result['message'] = $this->ion_auth->messages_alert();
        }
        else
        {
            $result['message'] = $this->ion_auth->errors_alert();
        }
        echo json_encode($result);
    }
    
    public function activate_users_account_status()
    {
        
    }
    
    public function inactivate_users_account_status()
    {
        
    }
    
    function account_validation_sms() {
        //$this->data['title'] = "sms_check";
        //validate form input
        $user_info = array();
        $this->data['message'] = "";
        $this->form_validation->set_rules('code', 'Code', 'required');

        if ($this->input->post('submit_sms_code')) {
            if ($this->form_validation->run() == true) {
                $code = $this->input->post('code');
                $user_info_array = $this->ion_auth->get_user_info()->result_array();
                
                if(!empty($user_info_array)){
                    $user_info = $user_info_array[0];
                
                    if ($code == $user_info['sms_code']) {
                        $additional_data = array(
                            'sms_code' => ''
                        );
                        if ($this->ion_auth->update($user_info['id'], $additional_data)) {
                            $shop_info = $this->ion_auth->get_user_shop_info($user_info['id'])->result_array();
                            if (empty($shop_info)) {
                                redirect('shop/create_shop', 'refresh');
                            }
                        }
                    } else {
                        $this->data['message'] = 'Incorrect sms code.';
                    }
                }
            } else {
                $this->data['message'] = validation_errors();
            }
        }
        $this->data['code'] = array(
            'name' => 'code',
            'id' => 'code',
            'type' => 'text',
            'value' => $this->form_validation->set_value('code'),
        );

        $this->data['submit_sms_code'] = array(
            'name' => 'submit_sms_code',
            'id' => 'submit_sms_code',
            'type' => 'submit',
            'value' => 'Submit',
        );
        $this->template->load(ACCOUNT_VALIDATION_SMS_TEMPLATE, ACCOUNT_VALIDATION_SMS_VIEW, $this->data);
    }

    //log the user out
    function logout() {
        $this->data['title'] = "Logout";

        //log the user out
        $this->ion_auth->logout();

        //redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        //$logoaddress = base_url() . '/assets/images/logo.png';
        //$this->session->set_userdata(array('logoaddress' => $logoaddress));
        redirect('user/login', 'refresh');
    }

    //create a new user
    function signup() {
        $this->data['title'] = "Create User";

        //validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'required|xss_clean');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'required|xss_clean');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true) {
            $username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company'),
                'phone' => $this->input->post('phone'),
            );
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data)) {
            //check to see if we are creating the user
            //redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("nonmember", 'refresh');
        } else {
            //display the create user form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

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
            $this->data['email'] = array(
                'name' => 'email',
                'id' => 'email',
                'type' => 'text',
                'value' => $this->form_validation->set_value('email'),
            );
            $this->data['company'] = array(
                'name' => 'company',
                'id' => 'company',
                'type' => 'text',
                'value' => $this->form_validation->set_value('company'),
            );
            $this->data['phone'] = array(
                'name' => 'phone',
                'id' => 'phone',
                'type' => 'text',
                'value' => $this->form_validation->set_value('phone'),
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

            $this->template->load(null, 'create_user', $this->data);
        }
    }

    //edit a user
    function update_profile($id = null) {
        $this->data['title'] = "Update Profile";

        if (!$this->ion_auth->logged_in()) {
            redirect('nonmember', 'refresh');
        }

        if (!$this->ion_auth->is_admin()) {
            $id = $this->ion_auth->get_user_id();
        }

        $user = $this->ion_auth->user($id)->row();
        $groups = $this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();

        //validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required|xss_clean');
        $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required|xss_clean');
        $this->form_validation->set_rules('groups', $this->lang->line('edit_user_validation_groups_label'), 'xss_clean');

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                show_error($this->lang->line('error_csrf'));
            }

            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company'),
                'phone' => $this->input->post('phone'),
            );

            //Update the groups user belongs to
            $groupData = $this->input->post('groups');

            if (isset($groupData) && !empty($groupData)) {

                $this->ion_auth->remove_from_group('', $id);

                foreach ($groupData as $grp) {
                    $this->ion_auth->add_to_group($grp, $id);
                }
            }

            //update the password if it was posted
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');

                $data['password'] = $this->input->post('password');
            }

            if ($this->form_validation->run() === TRUE) {
                $this->ion_auth->update($user->id, $data);

                //check to see if we are creating the user
                //redirect them back to the admin page
                $this->session->set_flashdata('message', "User Saved");
                redirect("nonmember", 'refresh');
            }
        }

        //display the edit user form
        $this->data['csrf'] = $this->_get_csrf_nonce();

        //set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        //pass the user to the view
        $this->data['user'] = $user;
        $this->data['groups'] = $groups;
        $this->data['currentGroups'] = $currentGroups;

        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('first_name', $user->first_name),
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('last_name', $user->last_name),
        );
        $this->data['company'] = array(
            'name' => 'company',
            'id' => 'company',
            'type' => 'text',
            'value' => $this->form_validation->set_value('company', $user->company),
        );
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'value' => $this->form_validation->set_value('phone', $user->phone),
        );
        $this->data['password'] = array(
            'name' => 'password',
            'id' => 'password',
            'type' => 'password'
        );
        $this->data['password_confirm'] = array(
            'name' => 'password_confirm',
            'id' => 'password_confirm',
            'type' => 'password'
        );

        $this->template->load(null, 'edit_user', $this->data);
    }

    //change password
    function change_password() {
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

        if (!$this->ion_auth->logged_in()) {
            redirect('nonmember', 'refresh');
        }

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() == false) {
            //display the form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = array(
                'name' => 'old',
                'id' => 'old',
                'type' => 'password',
            );
            $this->data['new_password'] = array(
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            );
            $this->data['new_password_confirm'] = array(
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            );
            $this->data['user_id'] = array(
                'name' => 'user_id',
                'id' => 'user_id',
                'type' => 'hidden',
                'value' => $user->id,
            );

            //render
            $this->template->load(null, 'change_password', $this->data);
        } else {
            $identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change) {
                //if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $this->logout();
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('user/change_password', 'refresh');
            }
        }
    }

    // create a new group
    function create_group() {
        $this->data['title'] = $this->lang->line('create_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        //validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash|xss_clean');
        $this->form_validation->set_rules('description', $this->lang->line('create_group_validation_desc_label'), 'xss_clean');

        if ($this->form_validation->run() == TRUE) {
            $new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
            if ($new_group_id) {
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth", 'refresh');
            }
        } else {
            //display the create group form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['group_name'] = array(
                'name' => 'group_name',
                'id' => 'group_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('group_name'),
            );
            $this->data['description'] = array(
                'name' => 'description',
                'id' => 'description',
                'type' => 'text',
                'value' => $this->form_validation->set_value('description'),
            );

            $this->_render_page('auth/create_group', $this->data);
        }
    }

    //forgot password
    function forgot_password() {
        $this->form_validation->set_rules('email', $this->lang->line('forgot_password_validation_email_label'), 'required');
        if ($this->form_validation->run() == false) {
            //setup the input
            $this->data['email'] = array('name' => 'email',
                'id' => 'email',
            );

            if ($this->config->item('identity', 'ion_auth') == 'username') {
                $this->data['identity_label'] = $this->lang->line('forgot_password_username_identity_label');
            } else {
                $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
            }

            //set any errors and display the form
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->template->load(null, 'forgot_password', $this->data);
        } else {
            // get identity for that email
            $config_tables = $this->config->item('tables', 'ion_auth');
            $identity = $this->db->where('email', $this->input->post('email'))->limit('1')->get($config_tables['users'])->row();

            //run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

            if ($forgotten) {
                //if there were no errors
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("user/login", 'refresh'); //we should display a confirmation page here instead of the login page
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("user/forgot_password", 'refresh');
            }
        }
    }

    //reset password - final step for forgotten password
    public function reset_password($code = NULL) {
        if (!$code) {
            show_404();
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user) {
            //if the code is valid then display the password reset form

            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

            if ($this->form_validation->run() == false) {
                //display the form
                //set the flash data error message if there is one
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = array(
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['new_password_confirm'] = array(
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['user_id'] = array(
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
                );
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;

                //render
                $this->_render_page('auth/reset_password', $this->data);
            } else {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

                    //something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($code);

                    show_error($this->lang->line('error_csrf'));
                } else {
                    // finally change the password
                    $identity = $user->{$this->config->item('identity', 'ion_auth')};

                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                    if ($change) {
                        //if the password was successfully changed
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        $this->logout();
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect('auth/reset_password/' . $code, 'refresh');
                    }
                }
            }
        } else {
            //if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    //activate the user
    function activate($id, $code = false) {
        if ($code !== false) {
            $activation = $this->ion_auth->activate($id, $code);
        } else if ($this->ion_auth->is_admin()) {
            $activation = $this->ion_auth->activate($id);
        }

        if ($activation) {
            //redirect them to the auth page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("auth", 'refresh');
        } else {
            //redirect them to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    //deactivate the user
    function deactivate($id = NULL) {
        $id = $this->config->item('use_mongodb', 'ion_auth') ? (string) $id : (int) $id;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
        $this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

        if ($this->form_validation->run() == FALSE) {
            // insert csrf check
            $this->data['csrf'] = $this->_get_csrf_nonce();
            $this->data['user'] = $this->ion_auth->user($id)->row();

            $this->_render_page('auth/deactivate_user', $this->data);
        } else {
            // do we really want to deactivate?
            if ($this->input->post('confirm') == 'yes') {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                    show_error($this->lang->line('error_csrf'));
                }

                // do we have the right userlevel?
                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
                    $this->ion_auth->deactivate($id);
                }
            }

            //redirect them back to the auth page
            redirect('auth', 'refresh');
        }
    }

    //edit a group
    function edit_group($id) {
        // bail if no group id given
        if (!$id || empty($id)) {
            redirect('auth', 'refresh');
        }

        $this->data['title'] = $this->lang->line('edit_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        $group = $this->ion_auth->group($id)->row();

        //validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash|xss_clean');
        $this->form_validation->set_rules('group_description', $this->lang->line('edit_group_validation_desc_label'), 'xss_clean');

        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() === TRUE) {
                $group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

                if ($group_update) {
                    $this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
                } else {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                }
                redirect("auth", 'refresh');
            }
        }

        //set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        //pass the user to the view
        $this->data['group'] = $group;

        $this->data['group_name'] = array(
            'name' => 'group_name',
            'id' => 'group_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_name', $group->name),
        );
        $this->data['group_description'] = array(
            'name' => 'group_description',
            'id' => 'group_description',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_description', $group->description),
        );

        $this->_render_page('auth/edit_group', $this->data);
    }

    function _get_csrf_nonce() {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    function _valid_csrf_nonce() {
        if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
                $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*
     * ---------------------------------- Customer Module -----------------------------------------------
     */

    public function download_search_customer() {
        $content = '';
        $customer_list_array = $this->ion_auth->get_all_customers()->result_array();
        $select_value = $this->input->post('select_option_for_download');
        foreach ($customer_list_array as $customer_info) {
            if ($select_value == 'mobile_no') {
                $content = $content . $customer_info['phone'] . "\r\n";
            } else if ($select_value == 'name') {
                $content = $content . $customer_info['first_name'] . ' ' . $customer_info['last_name'] . "\r\n";
            } else {
                $content = $content . $customer_info['phone'] . '-' . $customer_info['first_name'] . ' ' . $customer_info['last_name'] . "\r\n";
            }
        }

        $file_name = now();
        header("Content-Type:text/plain");
        header("Content-Disposition: 'attachment'; filename=" . $file_name . ".txt");
        echo $content;
    }

    // ----------------------------------- Manager Module -------------------------------------------
    public function create_manager() {
        
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
        }
        
        if($user_group['id'] == USER_GROUP_SALESMAN){
            redirect("user/login","refresh");
        }
        
        $this->data['message'] = '';
        $this->form_validation->set_rules('phone', 'Phone', 'xss_clean|required');
        $this->form_validation->set_rules('username', 'User Name', 'xss_clean|required');
        $this->form_validation->set_rules('email', 'Email', 'xss_clean');
        $this->form_validation->set_rules('first_name', 'First Name', 'xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'xss_clean');
        $this->form_validation->set_rules('address', 'Address', 'xss_clean');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');


        if ($this->input->post('submit_create_manager')) {
            if ($this->form_validation->run() == true) {
                //$user_name = $this->input->post('phone');
                $user_name = $this->input->post('username');
                $password = $this->input->post('password');
                $email = $this->input->post('email');
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
                    //$this->sms_library->send_sms($this->input->post('phone'), $additional_data['sms_code']);
                    $this->session->set_flashdata('message', 'sms sent to your mobile');

                    redirect("user/create_manager", "refresh");
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
        $this->data['submit_create_manager'] = array(
            'name' => 'submit_create_manager',
            'id' => 'submit_create_manager',
            'type' => 'submit',
            'value' => 'Create',
        );
        $this->template->load(null, 'manager/create_manager', $this->data);
    }

    public function show_all_managers() {
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
        
            if($user_group['id'] == USER_GROUP_SALESMAN){
                $this->template->load(null, 'user/login', $this->data);
            }
        }
        
        
        
        $this->data['manager_list'] = array();
        $manager_list_array = $this->ion_auth->get_all_managers()->result_array();
        if (!empty($manager_list_array)) {
            $this->data['manager_list'] = $manager_list_array;
        }
        $this->template->load(null, 'manager/show_all_managers', $this->data);
    }

    public function update_manager($user_id = '') {
        if (empty($user_id)) {
            redirect("user/show_all_managers", "refresh");
        }
        $this->data['message'] = '';
        $this->form_validation->set_rules('phone', 'Phone', 'xss_clean|required');
        $this->form_validation->set_rules('first_name', 'First Name', 'xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'xss_clean');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
        $this->form_validation->set_rules('address', 'Address', 'xss_clean');

        $manager_info = array();
        $manager_info_array = $this->ion_auth->get_manager($user_id)->result_array();
        if (empty($manager_info_array)) {
            redirect("user/show_all_managers", "refresh");
        } else {
            $manager_info = $manager_info_array[0];
        }
        $this->data['manager_info'] = $manager_info;
        if ($this->input->post('submit_update_manager')) {
            if ($this->form_validation->run() == true) {
                $additional_data = array(
                    'user_group_id' => $this->user_group['manager_id'],
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'phone' => $this->input->post('phone'),
                    'address' => $this->input->post('address'),
                    'modified_date' => date('Y-m-d H:i:s')
                );
                if ($this->input->post('password') !== PSD_DUMMY) {
                    $additional_data['password'] = $this->input->post('password');
                }
                if ($this->ion_auth->update($user_id, $additional_data)) {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect("user/update_manager/" . $manager_info['id'], "refresh");
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
            'value' => $manager_info['phone'],
        );
        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $manager_info['first_name'],
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $manager_info['last_name'],
        );
        $this->data['old_password'] = array(
            'name' => 'old_password',
            'id' => 'old_password',
            'type' => 'password',
            'value' => PSD_DUMMY,
        );
        $this->data['new_password'] = array(
            'name' => 'new_password',
            'id' => 'new_password',
            'type' => 'password',
        );
        $this->data['password_confirm'] = array(
            'name' => 'password_confirm',
            'id' => 'password_confirm',
            'type' => 'password',
        );
        $this->data['address'] = array(
            'name' => 'address',
            'id' => 'address',
            'type' => 'textarea',
            'value' => $manager_info['address'],
        );
        $this->data['submit_update_manager'] = array(
            'name' => 'submit_update_manager',
            'id' => 'submit_update_manager',
            'type' => 'submit',
            'value' => 'Update',
        );
        $this->template->load(null, 'manager/update_manager', $this->data);
    }

    public function test() {
        $this->sms_library->send_sms('12345', 'hello');
    }

    public function manager_signup() {
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
        $this->form_validation->set_rules('username', 'User Name', 'required');
        $this->form_validation->set_rules('new_password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->input->post('submit_create_manager')) {
            //$privatekey = "6Lf8YfESAAAAAHAsDzHvv0ESHdrFIe0k0pIDa542";
            $privatekey = "6LctLfISAAAAAP_6q1pftugclrynNTLprwXFIXOD"; //bdlions@gmail.com
            $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

            if ($resp->is_valid) {
                if ($this->form_validation->run() == true) {
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
                } else {
                    $this->data['message'] = validation_errors();
                }
            } else {
                $this->data['message'] = 'Invalid captcha.';
            }
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }
    }

    public function admin_signup() {
        $this->data['message'] = '';
// <editor-fold defaultstate="collapsed">
//        $this->form_validation->set_rules('phone', 'Phone', 'xss_clean|required');
//        $this->form_validation->set_rules('username', 'User Name', 'xss_clean|required');
//        $this->form_validation->set_rules('email', 'Email', 'xss_clean');
//        $this->form_validation->set_rules('first_name', 'First Name', 'xss_clean');
//        $this->form_validation->set_rules('last_name', 'Last Name', 'xss_clean');
//        $this->form_validation->set_rules('address', 'Address', 'xss_clean');
//        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
//        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
//        
        // </editor-fold>
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
        $this->form_validation->set_rules('username', 'User Name', 'required');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->input->post('submit_create_manager')) {
            //$privatekey = "6Lf8YfESAAAAAHAsDzHvv0ESHdrFIe0k0pIDa542";
            $privatekey = "6LctLfISAAAAAP_6q1pftugclrynNTLprwXFIXOD"; //bdlions@gmail.com
            $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

            if ($resp->is_valid) {
                if ($this->form_validation->run() == true) {
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
                } else {
                    $this->data['message'] = validation_errors();
                }
            } else {
                $this->data['message'] = 'Invalid captcha.';
            }
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }
        $this->data['first_name'] = array('type' => 'text', 'name' => 'first_name', 'id' => 'first_name', 'value' => $this->input->post('first_name'));
        $this->data['last_name'] = array('type' => 'text', 'name' => 'last_name', 'id' => 'last_name', 'value' => $this->input->post('last_name'));
        $this->data['email'] = array('type' => 'email', 'name' => 'email', 'id' => 'email', 'value' => $this->input->post('email'));
        $this->data['phone'] = array('type' => 'text', 'name' => 'phone', 'id' => 'phone', 'value' => $this->input->post('phone'));
        $this->data['username'] = array('type' => 'text', 'name' => 'username', 'id' => 'username', 'value' => $this->input->post('username'));
        $this->data['password'] = array('type' => 'password', 'name' => 'password', 'id' => 'password');
        $this->data['password_confirm'] = array('type' => 'password', 'name' => 'password_confirm', 'id' => 'password_confirm');
        $this->data['submit_create_manager'] = array('type' => 'submit', 'name' => 'submit_create_manager', 'id' => 'submit_create_manager', 'value' => 'Register');
// <editor-fold defaultstate="collapsed">
//        $this->data['phone'] = array(
//            'name' => 'phone',
//            'id' => 'phone',
//            'type' => 'text',
//            'value' => $this->form_validation->set_value('phone'),
//        );
//        $this->data['username'] = array(
//            'name' => 'username',
//            'id' => 'username',
//            'type' => 'text',
//            'value' => $this->form_validation->set_value('username'),
//        );
//        $this->data['email'] = array(
//            'name' => 'email',
//            'id' => 'email',
//            'type' => 'text',
//            'value' => $this->form_validation->set_value('email'),
//        );
//        $this->data['first_name'] = array(
//            'name' => 'first_name',
//            'id' => 'first_name',
//            'type' => 'text',
//            'value' => $this->form_validation->set_value('first_name'),
//        );
//        $this->data['last_name'] = array(
//            'name' => 'last_name',
//            'id' => 'last_name',
//            'type' => 'text',
//            'value' => $this->form_validation->set_value('last_name'),
//        );
//        $this->data['address'] = array(
//            'name' => 'address',
//            'id' => 'address',
//            'type' => 'textarea',
//            'value' => $this->form_validation->set_value('address'),
//        );
//        $this->data['password'] = array(
//            'name' => 'password',
//            'id' => 'password',
//            'type' => 'password',
//            'value' => $this->form_validation->set_value('password'),
//        );
//        $this->data['password_confirm'] = array(
//            'name' => 'password_confirm',
//            'id' => 'password_confirm',
//            'type' => 'password',
//            'value' => $this->form_validation->set_value('password_confirm'),
//        );
//        $this->data['submit_create_manager'] = array(
//            'name' => 'submit_create_manager',
//            'id' => 'submit_create_manager',
//            'type' => 'submit',
//            'value' => 'Create',
//        );
//        $this->template->load(null,'manager/create_admin',$this->data);
// </editor-fold>
        $this->template->load(NULL, "manager/create_admin", $this->data);
    }

}
