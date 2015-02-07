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
        
        if(!$this->ion_auth->logged_in())
        {
            redirect("user/login","refresh");
        }
    }
    
    function index()
    {
        
    }
    /*
     * This method will update custom message
     * @Author Nazmul on 17th May 2014
     */
    public function update_custom_message($message_id=0)
    {
        $this->data['message'] = '';
        
        $this->form_validation->set_rules('editor1', 'Message description', 'xss_clean|required');
        
        if ($this->input->post('submit_update_message')) 
        {
            if ($this->form_validation->run() == true) 
            {
                $id = $this->input->post('message_id');
                
                //echo trim(htmlentities($this->input->post('editortext')));
                
                if($id ==''){
                    $this->data['message'] = 'To update at first you have to search and select a message';
                    
                    redirect("message/update_custom_message","refresh");
                }
                $data = array(
                    'message_id' =>  $id,
                    'message' => trim(htmlentities($this->input->post('editortext'))),
                    'modified_on' => now()
                );
                //echo '<pre/>';print_r($data);exit;
                $this->messages->update_message_info($id,$data);
                redirect("message/update_custom_message","refresh");
            }
            else
            {
                $this->data['message'] = validation_errors();
            }
        }
        else if ($this->input->post('submit_create_message')) 
        {
            if ($this->form_validation->run() == true) 
            {
                // after chnaging the test using javascript value is pick in hidden field editortext
                $editor_value = trim(htmlentities($this->input->post('editortext')));
                $data = array(
                    'shop_id' => $this->session->userdata('shop_id'),
                    'message' => $editor_value,
                    'created_on' => now(),
                );
               
                $id = $this->messages->create_message($data);
                if( $id !== FALSE )
                {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect("message/update_custom_message","refresh");
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
        
        $message_info_array = $this->messages->get_messages()->result_array();
        
        $sup_info = array();        
        if ($message_id != 0)
        {
            $sup_info['id'] = $message_id;
            $sup_info['message'] = '';
            foreach ($message_info_array as $msg_data)
            {
                if($msg_data['id'] == $message_id)
                {
                    $sup_info['message'] = $msg_data['message'];
                    break;
                }
            }
            $this->data['sup_info'] = $sup_info;
        }

        $this->data['message_info_array'] = $message_info_array;
        
        $this->data['editor1'] = array(
            'name'  => 'editor1',
            'id'    => 'editor1',
            'value' => isset($sup_info['message'])?html_entity_decode(html_entity_decode($sup_info['message'])):'',
            'rows'  => '10',
            'cols'  => '80'
        );
        
        $this->data['submit_update_message'] = array(
            'name' => 'submit_update_message',
            'type' => 'submit',
            'value' => 'Update',
        );
        
        $this->data['submit_create_message'] = array(
            'name' => 'submit_create_message',
            'type' => 'submit',
            'value' => 'Create',
        );
        $this->data['custom_messages'] = $this->get_custom_message();
        
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
            $shop_id = $this->session->userdata('shop_id');
        }
        $messages = $this->messages->get_all_custom_message_for_typeahed($shop_id)->result();
        $temp_messages = array();
        foreach ($messages as  $message){
            $message -> message = nl2br(strip_tags(html_entity_decode(html_entity_decode($message -> message))));
            $message -> value = substr(strip_tags(html_entity_decode(html_entity_decode($message -> message))), 0, 20);
            
            array_push($temp_messages, $message);
        }

        return json_encode($temp_messages);
    }
    
    public function view_custom_messages()
    {
        $shop_id = $this->session->userdata('shop_id');
        
        $result = $this->messages->get_messages(array(),$shop_id)->result_array();
        $this->data['all_messages'] = $result;
        $this->data['shop_id'] = $shop_id;
                
        $this->template->load(null, 'message/view_custom_messages',$this->data);
    }
    public function show_message($message_id)
    {
        $shop_id = $this->session->userdata('shop_id');
        $this->data['message_id'] = $message_id;
        $result = array();
        $result = $this->messages->get_message_info($message_id)->result_array();
        //echo '<pre>'; print_r($result); exit();
        if(count($result)>0)
        {
            $result = $result[0];
        }
        $this->data['message_info'] = $result;
        $this->data['shop_id'] = $shop_id;
        $this->data['editor1'] = array(
            'name'  => 'editor1',
            'id'    => 'editor1',
            'value' => html_entity_decode(html_entity_decode($result['message'])),
            'rows'  => '4',
            'cols'  => '10'
        );
        
                
        $this->template->load(null, 'message/show_message_view',$this->data);
    }
    
    public function delete_custom_message()
    {
        $result = array();
        $id = $this->input->post('id');
        if($this->messages->delete_message($id))
        {
            $result['message'] = $this->messages->messages_alert();
        }
        else
        {
            $result['message'] = $this->messages->errors_alert();
        }
        echo json_encode($result);
    }
    
            
}
