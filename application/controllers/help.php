<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Help extends CI_Controller {
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
        
        if(!$this->ion_auth->logged_in())
        {
            redirect("user/login","refresh");
        }
    }
    
    public function add_help_info()
    {
        $this->data['message'] = '';
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('help_phone', 'Help Phone', 'xss_clean|required');
        $this->form_validation->set_rules('help_skype_id', 'Help Skype', 'xss_clean');
       
        if ($this->input->post('submit_add_help')) 
        {
            if ($this->form_validation->run() == true) 
            {
                $additional_data = array(
                    'phone_no' => $this->input->post('help_phone'),
                    'skype_id' => $this->input->post('help_skype_id'),
                   
                );
                $help_id = $this->help_model->add_help_info($additional_data);;
                if( $help_id !== FALSE)
                {
                    $this->data['message'] ="Help Information Added Successfully";
              
                }
                else
                {
                    $this->data['message'] = $this->help_library->errors();
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
    
        $this->data['help_phone'] = array(
            'name' => 'help_phone',
            'id' => 'help_phone',
            'type' => 'text',
            'value' => $this->form_validation->set_value('help_phone'),
        );
        $this->data['help_skype_id'] = array(
            'name' => 'help_skype_id',
            'id' => 'help_skype_id',
            'type' => 'text',
            'value' => $this->form_validation->set_value('help_skype_id'),
        );
        $this->data['submit_add_help'] = array(
            'name' => 'submit_add_help',
            'id' => 'submit_add_help',
            'type' => 'submit',
            'value' => 'Add',
        );
      
            $this->template-> load(null,'help/add_help',$this->data);
    }
// function add_help_info_test(){
//        
//        $additional_data =array(
//            'phone_no' =>'01723598606',
//            'skype_id' =>'rashida_cse'
//            
//        );
//        var_dump($additional_data);
//       $help_id = $this->help_model->add_help_info($additional_data); 
//    }
   function get_help_info(){
       
//       $help_info_array = $this->help_model->get_help_info()->result_array();
//        if( !empty($help_info_array) )
//        {
//            $this->data['help_info'] = $help_info_array;
//        }
       $this->template-> load(null,'help/show_help');
   }
   
}
