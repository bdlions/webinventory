<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {
    /*
     * Holds account status list
     * 
     * $var array
     */

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('org/common/messages');
        $this->load->helper('url');

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
    /*
     * This method will create new custom message
     * @Author Nazmul on 17th May 2014
     */
    public function create_custom_message()
    {
        $this->data['message'] = '';
        $this->form_validation->set_rules('editor1', 'Message description', 'xss_clean|required');
        
        if ($this->input->post('submit_create_message')) 
        {
            if ($this->form_validation->run() == true) 
            {
                // after chnaging the test using javascript value is pick in hidden field editortext
                $editor_value = trim(htmlentities($this->input->post('editortext')));
                $shop_id = 
                $data = array(
                    'shop_id' => $this->session->userdata('shop_id'),
                    'message' => $editor_value,
                    'created_on' => now(),
                );
               
                $id = $this->messages->create_message($data);
                if( $id !== FALSE )
                {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect("message/create_custom_message","refresh");
                }
                else
                {
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
            $this->data['message'] = $this->session->flashdata('message');
        }
        $this->data['editor1'] = array(
            'name'  => 'editor1',
            'id'    => 'editor1',
            'value' => $this->form_validation->set_value('editor1'),
            'rows'  => '10',
            'cols'  => '80'
        );
        $this->data['submit_create_message'] = array(
            'name' => 'submit_create_message',
            'id' => 'submit_create_message',
            'type' => 'submit',
            'value' => 'Create',
        );
        $this->template->load(null, 'message/create_custom_message',$this->data);
    }
    /*
     * This method will update custom message
     * @Author Nazmul on 17th May 2014
     */
    public function update_custom_message()
    {
        $this->data['message'] = '';
        
        $this->form_validation->set_rules('editor1', 'Message description', 'xss_clean|required');
        
        if ($this->input->post('submit_update_message')) 
        {
            if ($this->form_validation->run() == true) 
            {
                $id = $this->input->post('message_id');
                $data = array(
                    'message_id' =>  $id,
                    'message' => trim(htmlentities($this->input->post('editortext'))),
                    'modified_on' => now()
                );
                //echo '<pre/>';print_r($data);exit;
                $this->messages->update_message_info($id,$data);
                redirect("message/update_custom_message", "refresh");
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
        
        $message_info_array = $this->messages->get_messages()->result_array();

        $this->data['message_info_array'] = $message_info_array;
        
        $this->data['editor1'] = array(
            'name'  => 'editor1',
            'id'    => 'editor1',
            'value' => '',
            'rows'  => '10',
            'cols'  => '80'
        );
        
        $this->data['submit_update_message'] = array(
            'name' => 'submit_update_message',
            'id' => 'submit_update_message',
            'type' => 'submit',
            'value' => 'Update',
        );
        
        $this->template->load(null, 'message/update_custom_message',$this->data);
    }
    
    /*
     * This method will search custom message
     * @Author Nazmul on 17th May 2014
     */
    public function search_custom_messages()
    {
        
    }
    
    public function get_custom_message($shop_id=0)
    {
        if($shop_id==0)
        {
            $shop_id = $this->session->userdate('shop_id');
        }
        $messages = $this->messages->get_all_custom_message_for_typeahed()->result();
        $temp_messages = array();
        foreach ($messages as  $message) {
            $message -> message = strip_tags(html_entity_decode(html_entity_decode($message -> message)));
            $message -> value = strip_tags(html_entity_decode(html_entity_decode($message -> message)));
            
            array_push($temp_messages, $message);
        }
        echo json_encode($temp_messages);
    }
}
