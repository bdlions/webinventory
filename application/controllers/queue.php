<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Queue extends CI_Controller {

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
        $this->load->library('org/manage_queue/manage_queue_library');

        $this->user_type = CUSTOMER;
        $this->user_group = $this->config->item('user_group', 'ion_auth');
        $this->account_status_list = $this->config->item('account_status', 'ion_auth');
        
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
        }
        
        if($user_group['id'] != USER_GROUP_ADMIN){
            redirect("user/login","refresh");
        }
        
        if(!$this->ion_auth->logged_in())
        {
            redirect("user/login","refresh");
        }
    }
    
    public function index()
    {
        $this->data['message'] = '';
        $file_content = '';
        if($this->input->post('submit_upload_file'))
        {
            //$file_content = $this->input->post('submit_upload_file');
            $config['upload_path'] = './upload/';
            $config['allowed_types'] = 'txt';
            $config['max_size'] = '5000';
            $config['file_name'] = 'queue_'.$this->session->userdata('user_id').".txt";
            $config['overwrite'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) 
            {
                $file_content = $this->upload->display_errors();
            }
            else 
            {
                
                $string = read_file('./upload/'.'queue_'.$this->session->userdata('user_id').'.txt');
                $file_content = $string;
            }
        }
        if($this->input->post('submit_process_file'))
        {
            $content = trim($this->input->post('textarea_details'));
            $path = './upload/'.'queue_'.$this->session->userdata('user_id').'.txt';
            
            if ( write_file($path, $content) )
            {
                redirect('queue/process_file');
            }
            
        }
        $this->data['textarea_details'] = array(
            'name'  => 'textarea_details',
            'id'    => 'textarea_details',
            'value' => $file_content,
            'rows'  => '20',
            'cols'  => '100'
        );
        $this->data['submit_upload_file'] = array(
            'name' => 'submit_upload_file',
            'id' => 'submit_upload_file',
            'type' => 'submit',
            'value' => 'Upload',
        );
        $this->data['submit_process_file'] = array(
            'name' => 'submit_process_file',
            'id' => 'submit_process_file',
            'type' => 'submit',
            'value' => 'Process',
        );
        $this->template->load(null, 'queue/upload_file', $this->data);
    }
    
    public function process_file()
    {
        $name_map = array();
        $number_list = array();
        $this->data['message'] = '';
        $file_content = read_file('./upload/'.'queue_'.$this->session->userdata('user_id').'.txt');
        
        $file_content_array = explode("\n", $file_content);
        //echo count($file_content_array);
        //echo '<pre/>' ; print_r($file_content_array);exit;
        $counter = 0;
        $list = array();
        $extra_array = array();
        foreach($file_content_array as $line)
        {
            if( $line != '' )
            {
                $line_array = explode("~", $line);
                
                if(count($line_array)> 1)
                {
                    $data = array(
                        'name' => $line_array[0],
                        'phone_number' => trim($line_array[1]),
                        'created_on' => now()
                    );
                    
                    $flag = $this->manage_queue_library->insert_phone_numbers($data);

                    if($flag !== FALSE) {
                        $phone_list = new stdClass();
                        $phone_list->id = $flag;
                        $phone_list->number = $line_array[1];
                        array_push($list,$phone_list);
                        array_push($extra_array,$line_array[1]);
                        $counter++;
                    }
                }
            }
        }
        
        if($counter > 0) {
            //$new_list = json_encode(array_unique($list));
            //echo count($new_list);exit;
            $new_list = json_encode($list);
            $additional_data = array(
                            'number_list' => $new_list,
                            'created_on' => now()
                            );
            $id = $this->manage_queue_library->create_phone_list($additional_data);
            if($id !== FALSE) {
                redirect('queue/config_queue/'. $id.'/'.$counter);
            } else {
                redirect('queue/index');
            }
        }
    }
            
    function config_queue($id, $total_number = 0) {
        
        $this->data['message'] = '';
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('total_number', 'Total Number', 'xss_clean|required');
        $this->form_validation->set_rules('total_no_of_queue', 'Total number of queue', 'xss_clean|required');
        $this->data['phone_upload_list_id'] = $id;
        
        $phone_upload_list = $this->manage_queue_library->get_phone_upload_list($id)->result_array();
        
        $this->data['uploaded_phone_list_id'] = $id;
        if ($this->input->post('submit_ok')) 
        {
            //echo '<pre>';print_r($_POST);exit('here');
            if ($this->form_validation->run() == true) 
            {
                $total_no = $this->input->post('total_number');
                $no_of_queue = $this->input->post('total_no_of_queue');
                $eaqually_distribute = $this->input->post('eaqually_distribute');
                $global_message_chcecked = $this->input->post('global_message_chcecked');
                $global_message = $this->input->post('global_message');
                
                $ed = 0;
                $gb_msg = 0;
                
                if((int) $eaqually_distribute == 1){
                    $ed = 1;
                }

                if((int) $global_message_chcecked == 1) {
                    //echo $global_message; exit('gg');
                    $gb_msg = 1;
                    $data = array(
                        'global_msg' => $global_message,
                        'modified_on' => now()
                    );

                    $flag = $this->manage_queue_library->update_phone_upload_list_for_global_msg($id, $data);
                }

                $this->session->set_flashdata('message', 'Manage queue is set for this list of number');
                redirect('queue/manage_queue/'.$id .'/' .$total_no.'/'.$no_of_queue.'/'.$ed.'/'.$gb_msg,'refresh');
                               
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
        
        //$this->data['total_number'] = $total_number;
        
        $this->data['total_number'] = array(
            'name' => 'total_number',
            'id' => 'total_number',
            'type' => 'text',
            'readonly' => 'true',
            'onkeydown' =>'validateNumberAllowDecimal(event, false)',
            //'value' => $this->form_validation->set_value('total_number'),
            'value' => $total_number,
        );
        
        $this->data['total_no_of_queue'] = array(
            'name' => 'total_no_of_queue',
            'id' => 'total_no_of_queue',
            'type' => 'text',
             'onkeydown' =>'validateNumberAllowDecimal(event, false)',
            'value' => $this->form_validation->set_value('total_no_of_queue'),
        );
        
        $this->data['eaqually_distribute'] = array(
            'name'        => 'eaqually_distribute',
            'id'          => 'eaqually_distribute',
            'value'       => '1',
            );
        
        $this->data['global_message_chcecked'] = array(
            'name'        => 'global_message_chcecked',
            'id'          => 'global_message_chcecked',
            'value'       => '1',
            );
        
         $this->data['global_message'] = array(
            'name' => 'global_message',
            'id' => 'global_message',
            'type' => 'text',
            'value' => $this->form_validation->set_value('global_message'),
        );
        
        
        $this->data['submit_ok'] = array(
            'name' => 'submit_ok',
            'id' => 'submit_ok',
            'type' => 'submit',
            'value' => 'OK',
        );
        
        $this->template->load(null, 'queue/config_queue', $this->data);
    }
    
    public function manage_queue($id, $total_no, $no_of_queue ,$euqally = 0, $global_msg = 0)
    {
        $this->data['message'] = '';
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('name_of_queue', 'Name', 'xss_clean|required');
        $this->form_validation->set_rules('no_of_msg', 'Number of message', 'xss_clean|required');
        $this->data['uploaded_phone_list_id'] = $id;
        $global_message ='';
        $number_list = NULL;
        $phone_upload_list = $this->manage_queue_library->get_phone_upload_list($id)->result_array();
        //echo '<pre>';print_r($phone_upload_list[0]['number_list']);exit('here');
        
        if(count($phone_upload_list) > 0) {
           $phone_upload_list = $phone_upload_list[0];
           if(!empty($phone_upload_list['global_msg'])) {
               $global_message = $phone_upload_list['global_msg'];
           }
         $number_list = $phone_upload_list['number_list'];
         //echo '<pre>';print_r(json_decode($number_list));exit('here');  
        }
        $this->data['all_phone_record'] = json_decode($number_list);
        $this->data['global_message'] = $global_message;

        
        $msg_in_each_queue = 0;
        $this->data['no_of_queue'] = $no_of_queue;
        $this->data['euqally'] = $euqally;
        if(($euqally == 1) && ($no_of_queue != 0) && ($total_no >= 2*$no_of_queue)){
            $msg_in_each_queue = $total_no/$no_of_queue;
        } else {
            
        }
        
        $this->data['msg_in_each_queue'] = $msg_in_each_queue;
        
        $this->data['total_no'] = $total_no;
        
        $this->data['global_msg'] = $global_msg;
        
        $this->data['name_of_queue'] = array(
            'name' => 'name_of_queue',
            'id' => 'name_of_queue',
            'type' => 'text',
            'value' => $this->form_validation->set_value('name_of_queue'),
        );
        
        $this->data['no_of_msg'] = array(
            'name' => 'no_of_msg',
            'id' => 'no_of_msg',
            'type' => 'text',
             'onkeydown' =>'validateNumberAllowDecimal(event, false)',
            'value' => $this->form_validation->set_value('no_of_msg'),
        );
        
        $this->template->load(null, 'queue/manage_queue', $this->data);
    }
    
    public function create_queue()
    {
        $response = array();
        $uploaded_phone_list_id = $this->input->post('uploaded_phone_list_id');
        $queue_name = $this->input->post('queue_name');
        $unprocess_phone_list = $this->input->post('unprocess_phone_list');
        $msg_for_queue = $this->input->post('msg_for_queue');

        //echo $msg_for_queue;
        for($i=0;$i<count($unprocess_phone_list);$i++){
           $unprocess_phone_list[$i]['message'] = $msg_for_queue;
        }
        
        $additional_data = array(
            'phone_upload_list_id' => $uploaded_phone_list_id,
            'name' => $queue_name,
            'unprocess_list' => json_encode($unprocess_phone_list),
            'created_on' => now()
        );
        
        $id = $this->manage_queue_library->create_queue($additional_data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Queue is added successfully.';
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_news->errors_alert();
        }
        echo json_encode($response);
    }
    
    public function test_q_provider() {
        
        $list = array();
        $results = $this->manage_queue_library->getAllUnprocessedQlist()->result_array();
        //echo '<pre/>';print_r($results);exit('here');
         
        foreach ($results as $key => $value) {
            $queue_list = new stdClass();
            $queue_list->id = $value['id'];
            $queue_list->name = $value['name'];
            $queue_list->noOfMsgs = count(json_decode($value['unprocess_list']));
            array_push($list,$queue_list);
        }
        
        $queues = new stdClass();
        $queues->id = 1;
        $queues->queues = $list;
       
        $data = array('json_data' => json_encode($queues));
        echo '<pre/>'; print_r($data);exit('i m here');
        //return json_encode($queues);
        $this->manage_queue_library->test_queue_insert($data);
        
        //echo '<pre/>'; print_r($queues);exit('i m here');
    }
    
    public function get_queue_by_id($id = 6) {
       $results = $this->manage_queue_library->get_queue_info_by_id($id);
       echo '<pre/>'; print_r($results);exit('i m here');
    }
}
