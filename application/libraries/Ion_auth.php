<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Ion Auth
 *
 * Author: Ben Edmunds
 * 		  ben.edmunds@gmail.com
 *         @benedmunds
 *
 * Added Awesomeness: Phil Sturgeon
 *
 * Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
 *
 * Created:  10.01.2009
 *
 * Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
 * Original Author name has been kept but that does not mean that the method has not been modified.
 *
 * Requirements: PHP5 or above
 *
 */
class Ion_auth {

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
     * caching of users and their groups
     *
     * @var array
     * */
    public $_cache_user_in_group;

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

        $this->_cache_user_in_group = & $this->ion_auth_model->_cache_user_in_group;

        //auto-login the user if they are remembered
        if (!$this->logged_in() && get_cookie('identity') && get_cookie('remember_code')) {
            $this->ion_auth_model->login_remembered_user();
        }

        $email_config = $this->config->item('email_config', 'ion_auth');

        if ($this->config->item('use_ci_email', 'ion_auth') && isset($email_config) && is_array($email_config)) {
            $this->email->initialize($email_config);
        }

        $this->ion_auth_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->ion_auth_model, $method)) {
            throw new Exception('Undefined method Ion_auth::' . $method . '() called');
        }

        return call_user_func_array(array($this->ion_auth_model, $method), $arguments);
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

    /**
     * forgotten password feature
     *
     * @return mixed  boolian / array
     * @author Mathew
     * */
    public function forgotten_password($identity) {    //changed $email to $identity
        if ($this->ion_auth_model->forgotten_password($identity)) {   //changed
            // Get user information
            $user = $this->where($this->config->item('identity', 'ion_auth'), $identity)->users()->row();  //changed to get_user_by_identity from email

            if ($user) {
                $data = array(
                    'identity' => $user->{$this->config->item('identity', 'ion_auth')},
                    'forgotten_password_code' => $user->forgotten_password_code
                );

                if (!$this->config->item('use_ci_email', 'ion_auth')) {
                    $this->set_message('forgot_password_successful');
                    return $data;
                } else {
                    $message = $this->load->view($this->config->item('email_templates', 'ion_auth') . $this->config->item('email_forgot_password', 'ion_auth'), $data, true);
                    $this->email->clear();
                    $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                    $this->email->to($user->email);
                    $this->email->subject($this->config->item('site_title', 'ion_auth') . ' - ' . $this->lang->line('email_forgotten_password_subject'));
                    $this->email->message($message);

                    if ($this->email->send()) {
                        $this->set_message('forgot_password_successful');
                        return TRUE;
                    } else {
                        $this->set_error('forgot_password_unsuccessful');
                        return FALSE;
                    }
                }
            } else {
                $this->set_error('forgot_password_unsuccessful');
                return FALSE;
            }
        } else {
            $this->set_error('forgot_password_unsuccessful');
            return FALSE;
        }
    }

    /**
     * forgotten_password_complete
     *
     * @return void
     * @author Mathew
     * */
    public function forgotten_password_complete($code) {
        $this->ion_auth_model->trigger_events('pre_password_change');

        $identity = $this->config->item('identity', 'ion_auth');
        $profile = $this->where('forgotten_password_code', $code)->users()->row(); //pass the code to profile

        if (!$profile) {
            $this->ion_auth_model->trigger_events(array('post_password_change', 'password_change_unsuccessful'));
            $this->set_error('password_change_unsuccessful');
            return FALSE;
        }

        $new_password = $this->ion_auth_model->forgotten_password_complete($code, $profile->salt);

        if ($new_password) {
            $data = array(
                'identity' => $profile->{$identity},
                'new_password' => $new_password
            );
            if (!$this->config->item('use_ci_email', 'ion_auth')) {
                $this->set_message('password_change_successful');
                $this->ion_auth_model->trigger_events(array('post_password_change', 'password_change_successful'));
                return $data;
            } else {
                $message = $this->load->view($this->config->item('email_templates', 'ion_auth') . $this->config->item('email_forgot_password_complete', 'ion_auth'), $data, true);

                $this->email->clear();
                $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                $this->email->to($profile->email);
                $this->email->subject($this->config->item('site_title', 'ion_auth') . ' - ' . $this->lang->line('email_new_password_subject'));
                $this->email->message($message);

                if ($this->email->send()) {
                    $this->set_message('password_change_successful');
                    $this->ion_auth_model->trigger_events(array('post_password_change', 'password_change_successful'));
                    return TRUE;
                } else {
                    $this->set_error('password_change_unsuccessful');
                    $this->ion_auth_model->trigger_events(array('post_password_change', 'password_change_unsuccessful'));
                    return FALSE;
                }
            }
        }

        $this->ion_auth_model->trigger_events(array('post_password_change', 'password_change_unsuccessful'));
        return FALSE;
    }

    /**
     * forgotten_password_check
     *
     * @return void
     * @author Michael
     * */
    public function forgotten_password_check($code) {
        $profile = $this->where('forgotten_password_code', $code)->users()->row(); //pass the code to profile

        if (!is_object($profile)) {
            $this->set_error('password_change_unsuccessful');
            return FALSE;
        } else {
            if ($this->config->item('forgot_password_expiration', 'ion_auth') > 0) {
                //Make sure it isn't expired
                $expiration = $this->config->item('forgot_password_expiration', 'ion_auth');
                if (time() - $profile->forgotten_password_time > $expiration) {
                    //it has expired
                    $this->clear_forgotten_password_code($code);
                    $this->set_error('password_change_unsuccessful');
                    return FALSE;
                }
            }
            return $profile;
        }
    }

    /**
     * register
     *
     * @return void
     * @author Mathew
     * */
    public function register($username, $password, $email, $additional_data = array(), $group_ids = array()) { //need to test email activation
        $this->ion_auth_model->trigger_events('pre_account_creation');

        $email_activation = $this->config->item('email_activation', 'ion_auth');

        if (!$email_activation) {
            $id = $this->ion_auth_model->register($username, $password, $email, $additional_data, $group_ids);
            if ($id !== FALSE) {
                $this->set_message('account_creation_successful');
                $this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_successful'));
                return $id;
            } else {
                $this->set_error('account_creation_unsuccessful');
                $this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_unsuccessful'));
                return FALSE;
            }
        } else {
            $id = $this->ion_auth_model->register($username, $password, $email, $additional_data, $group_ids);
            //echo '<pre>';print_r($additional_data);
            //echo $username,$email,$password;exit('HI');
            if (!$id) {
                $this->set_error('account_creation_unsuccessful');
                return FALSE;
            }

            $deactivate = $this->ion_auth_model->deactivate($id);

            if (!$deactivate) {
                $this->set_error('deactivate_unsuccessful');
                $this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_unsuccessful'));
                return FALSE;
            }

            $activation_code = $this->ion_auth_model->activation_code;
            $identity = $this->config->item('identity', 'ion_auth');
            $user = $this->ion_auth_model->user($id)->row();

            $data = array(
                'identity' => $user->{$identity},
                'id' => $user->id,
                'email' => $email,
                'activation' => $activation_code,
            );
            if (!$this->config->item('use_ci_email', 'ion_auth')) {
                $this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_successful', 'activation_email_successful'));
                $this->set_message('activation_email_successful');
                return $data;
            } else {
                $message = $this->load->view($this->config->item('email_templates', 'ion_auth') . $this->config->item('email_activate', 'ion_auth'), $data, true);

                $this->email->clear();
                $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                $this->email->to($email);
                $this->email->subject($this->config->item('site_title', 'ion_auth') . ' - ' . $this->lang->line('email_activation_subject'));
                $this->email->message($message);

                if ($this->email->send() == TRUE) {
                    $this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_successful', 'activation_email_successful'));
                    $this->set_message('activation_email_successful');
                    return $id;
                }
            }

            $this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_unsuccessful', 'activation_email_unsuccessful'));
            $this->set_error('activation_email_unsuccessful');
            return FALSE;
        }
    }
    
    public function admin_registration_email($data, $email)
    {
        if ($this->config->item('send_admin_email', 'ion_auth')) 
        {
            $message = $this->load->view($this->config->item('admin_email_templates', 'ion_auth') . $this->config->item('admin_email_registration_success', 'ion_auth'), $data, true);
            $this->email->clear();
            $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
            $this->email->to($email);
            $this->email->subject($this->config->item('site_title', 'ion_auth') . ' - ' . $this->lang->line('email_registration_success_subject'));
            $this->email->message($message);

            if ($this->email->send() == TRUE) {
                //
            }
        }
    }

    public function login($identity, $password, $remember = FALSE){
        $user = $this->ion_auth_model->login($identity, $password);
        if($user != FALSE){
            if($this->in_group(ADMIN, $user->id))
            {
                $user->user_type = ADMIN;
            }
            if($this->in_group(MANAGER, $user->id))
            {
                $user->user_type = MANAGER;
            }
            if($this->in_group(SALESMAN, $user->id))
            {
                $user->user_type = SALESMAN;
            }
            if($this->in_group(STAFF, $user->id))
            {
                $user->user_type = STAFF;
            }
            if($this->in_group(CUSTOMER, $user->id))
            {
                $user->user_type = CUSTOMER;
            }
            if($this->in_group(SUPPLIER, $user->id))
            {
                $user->user_type = SUPPLIER;
            }
            
            $this->ion_auth_model->set_session($user);

            $this->ion_auth_model->update_last_login($user->id);

            $this->ion_auth_model->clear_login_attempts($identity);

            if ($remember && $this->config->item('remember_users', 'ion_auth')) {
                $this->ion_auth_model->remember_user($user->id);
            }

            $this->trigger_events(array('post_login', 'post_login_successful'));
            $this->set_message('login_successful');
            return TRUE;
        }
        return FALSE;
        
    }
    /**
     * logout
     *
     * @return void
     * @author Mathew
     * */
    public function logout() {
        $this->ion_auth_model->trigger_events('logout');

        $identity = $this->config->item('identity', 'ion_auth');
        $this->session->unset_userdata(array($identity => '', 'id' => '', 'user_id' => ''));

        //delete the remember me cookies if they exist
        if (get_cookie('identity')) {
            delete_cookie('identity');
        }
        if (get_cookie('remember_code')) {
            delete_cookie('remember_code');
        }

        //Destroy the session
        $this->session->sess_destroy();

        //Recreate the session
        if (substr(CI_VERSION, 0, 1) == '2') {
            $this->session->sess_create();
        }

        $this->set_message('logout_successful');
        return TRUE;
    }

    /**
     * logged_in
     *
     * @return bool
     * @author Mathew
     * */
    public function logged_in() {
        $this->ion_auth_model->trigger_events('logged_in');

        return (bool) $this->session->userdata('identity');
    }

    /**
     * logged_in
     *
     * @return integer
     * @author jrmadsen67
     * */
    public function get_user_id() {
        $user_id = $this->session->userdata('user_id');
        if (!empty($user_id)) {
            return $user_id;
        }
        return null;
    }

    /**
     * is_admin
     *
     * @return bool
     * @author Ben Edmunds
     * */
    public function is_admin($id = false) {
        $this->ion_auth_model->trigger_events('is_admin');

        $admin_group = $this->config->item('admin_group', 'ion_auth');

        return $this->in_group($admin_group, $id);
    }
    
    public function is_manager($id = false) {
        $this->ion_auth_model->trigger_events('is_manager');
        return $this->in_group(MANAGER, $id);
    }
    public function is_staff($id = false) {
        $this->ion_auth_model->trigger_events('is_staff');
        return $this->in_group(STAFF, $id);
    }

    public function get_current_user_type(){
        return $this->session->userdata('user_type');
    }
    
    public function get_current_shop_type()
    {
       $shop_type_id = 0;
       $shop_info_array = $this->ion_auth_model->get_shop_info()->result_array();
       if(!empty($shop_info_array))
       {
           $shop_info = $shop_info_array[0];
           $shop_type_id = $shop_info['shop_type_id'];
       }
       return $shop_type_id;
    }

    /**
     * in_group
     *
     * @param mixed group(s) to check
     * @param bool user id
     * @param bool check if all groups is present, or any of the groups
     *
     * @return bool
     * @author Phil Sturgeon
     * */
    public function in_group($check_group, $id = false, $check_all = false) {
        $this->ion_auth_model->trigger_events('in_group');

        $id || $id = $this->session->userdata('user_id');

        if (!is_array($check_group)) {
            $check_group = array($check_group);
        }

        if (isset($this->_cache_user_in_group[$id])) {
            $groups_array = $this->_cache_user_in_group[$id];
        } else {
            $users_groups = $this->ion_auth_model->get_users_groups($id)->result();
            $groups_array = array();
            foreach ($users_groups as $group) {
                $groups_array[$group->id] = $group->name;
            }
            $this->_cache_user_in_group[$id] = $groups_array;
        }
        foreach ($check_group as $key => $value) {
            $groups = (is_string($value)) ? $groups_array : array_keys($groups_array);

            /**
             * if !all (default), in_array
             * if all, !in_array
             */
            if (in_array($value, $groups) xor $check_all) {
                /**
                 * if !all (default), true
                 * if all, false
                 */
                return !$check_all;
            }
        }

        /**
         * if !all (default), false
         * if all, true
         */
        return $check_all;
    }

}
