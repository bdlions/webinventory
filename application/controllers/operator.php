<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Operator extends CI_Controller {
    /*
     * Holds account status list
     * 
     * $var array
     */

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('org/common/operators');
        $this->load->helper('url');
        $this->load->helper('file');

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
        
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
            $this->session->set_flashdata('message',"You have no permission to view that page");
            if($user_group['id'] == USER_GROUP_MANAGER)
            {
                redirect('user/manager_login',"refresh");
            }
            else if($user_group['id'] == USER_GROUP_SALESMAN)
            {
                redirect('user/salesman_login',"refresh");
            }
        }
    }
    
    function index()
    {
        
    }
    
    public function create_operator()
    {
        
        $this->data['message'] = '';
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('operator_prefix', 'Operator Prefix', 'xss_clean|required');
        $this->form_validation->set_rules('operator_name', 'Operator Name', 'xss_clean|required');
        $this->form_validation->set_rules('description', 'Description', 'xss_clean');
        if ($this->input->post('submit_create_operator')) 
        {
            if ($this->form_validation->run() == true) 
            {
                $additional_data = array(
                    'operator_prefix' => $this->input->post('operator_prefix'),
                    'operator_name' => $this->input->post('operator_name'),
                    'description' => $this->input->post('description'),
                    'created_on' => now()
                );
                if( $this->operators->create_operator($additional_data) !== FALSE)
                {
                    $this->session->set_flashdata('message', $this->operators->messages());
                    redirect('operator/create_operator','refresh');
                }
                else
                {
                    $this->data['message'] = $this->operators->errors();
                }
            }
            else
            {
                $this->data['message'] = validation_errors();
            }
        }
        else
        {
            $this->data['message'] = $this->session->flashdata('message'); 
        }
        
        $this->data['operator_prefix'] = array(
            'name' => 'operator_prefix',
            'id' => 'operator_prefix',
            'type' => 'text',
            'value' => $this->form_validation->set_value('operator_prefix'),
        );
        $this->data['operator_name'] = array(
            'name' => 'operator_name',
            'id' => 'operator_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('operator_name'),
        );
        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text',
            'value' => $this->form_validation->set_value('description'),
        );
        $this->data['submit_create_operator'] = array(
            'name' => 'submit_create_operator',
            'id' => 'submit_create_operator',
            'type' => 'submit',
            'value' => 'Create',
        );
        $this->template->load(null, 'sms/create_operator',$this->data);
    }
    public function show_all_operators()
    {
        
        $this->data['operator_list'] = array();
        $operator_list_array = $this->operators->get_all_operators()->result_array();
        if( !empty($operator_list_array) )
        {
            $this->data['operator_list'] = $operator_list_array;
        }
        $this->template->load(null, 'sms/show_all_operators', $this->data);
    }
}
