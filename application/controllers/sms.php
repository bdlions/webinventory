<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sms extends CI_Controller {
    /*
     * Holds account status list
     * 
     * $var array
     */

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('org/common/operators');
        $this->load->library('org/common/sms_configuration');
        $this->load->library('org/shop/shop_library');
        $this->load->library('sms_library');
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
        redirect("shop/show_all_shops","refresh");
    }
    /*
     * This method will update currently logged in shop of a user
     * @author Nazmul on 23rd January 2014
     */
    public function sms_configuration_shop($shop_id = 0)
    {
        $this->data['message'] = '';
        if( $shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }        
        $sms_configuration_shop_status = 0;
        $sms_configuration_shop_array = $this->sms_configuration->get_sms_configuration_shop($shop_id)->result_array();
        if(!empty($sms_configuration_shop_array))
        {
            $sms_configuration_shop_status = $sms_configuration_shop_array[0]['status'];
        }
        $shop_list_array = $this->shop_library->get_all_shops()->result_array();
        $this->data['shop_list'] = array();
        if( !empty($shop_list_array) )
        {
            foreach ($shop_list_array as $key => $shop_info) {
                $this->data['shop_list'][$shop_info['id']] = $shop_info['name'];
            }
        }
        if($this->input->post('shop_list'))
        {
            $shop_id = $this->input->post('shop_list');
        }
        $this->data['selected_shop_id'] = $shop_id;
        if ($this->input->post('submit_sms_configuration_shop')) 
        {
            $status = 0;
            if($this->input->post('sms_configuration_shop_status') !== FALSE)
            {
                $status = 1;
            }            
            $data = array(
                'shop_id' => $shop_id,
                'status' => $status
            );
            $this->sms_configuration->store_sms_configuration_shop($data);
            $this->session->set_flashdata('message', $this->sms_configuration->messages());
            redirect('sms/sms_configuration_shop/'.$shop_id, 'refresh');
        }
        else
        {
            $this->data['message'] = $this->session->flashdata('message'); 
        }
        $this->data['sms_configuration_shop_status'] = array(
            'name' => 'sms_configuration_shop_status',
            'id' => 'sms_configuration_shop_status',
            'checked' => $sms_configuration_shop_status
        );
        $this->data['submit_sms_configuration_shop'] = array(
            'name' => 'submit_sms_configuration_shop',
            'id' => 'submit_sms_configuration_shop',
            'type' => 'submit',
            'value' => 'Update',
        );        
        $this->template->load(null, 'sms/sms_configuration_shop', $this->data);
    }
    
    public function upload_file()
    {
        $this->data['message'] = '';
        $file_content = '';
        if($this->input->post('submit_upload_file'))
        {
            //$file_content = $this->input->post('submit_upload_file');
            $config['upload_path'] = './upload/';
            $config['allowed_types'] = 'txt';
            $config['max_size'] = '5000';
            $config['file_name'] = $this->session->userdata('user_id').".txt";
            $config['overwrite'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) 
            {
                $file_content = $this->upload->display_errors();
            } 
            else 
            {
                $string = read_file('./upload/'.$this->session->userdata('user_id').'.txt');
                $file_content = $string;
            }
        }
        if($this->input->post('submit_process_file'))
        {
            $content = trim($this->input->post('textarea_details'));
            $path = './upload/'.$this->session->userdata('user_id').'.txt';
            if ( write_file($path, $content) )
            {
                 redirect('sms/process_file/');
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
        $this->template->load(null, 'sms/upload_file', $this->data);
    }
    
    public function process_file()
    {
        $number_name_map = array();
        $number_list = array();
        $this->data['message'] = '';
        $file_content = read_file('./upload/'.$this->session->userdata('user_id').'.txt');
        $file_content_array = explode("\n", $file_content);
        foreach($file_content_array as $line)
        {
            if( $line != '' )
            {
                $line_array = explode("-", $line);
                if(count($line_array)> 1)
                {
                    $number_name_map[$line_array[0]] = $line_array[1];                              
                }  
                else
                {
                    $number_name_map[$line_array[0]] = '';
                }
                $number_list[] = $line_array[0];
            }               
        }
        $result = array_count_values($number_list);
        arsort($result);
        $this->data['number_list'] = $result;
        $this->data['number_name_map'] = $number_name_map;
        
        $this->data['operator_list'] = array();
        $operator_list_array = $this->operators->get_all_operators()->result_array();        
        foreach ($operator_list_array as $operator_info) {
            $this->data['operator_list'][$operator_info['operator_prefix']] = $operator_info['operator_name'];
        }  
        $this->data['color_list']['1'] = 'Green';
        $this->data['color_list']['2'] = 'Blue';
        $this->data['color_list']['3'] = 'Red';
        $this->template->load(null, 'sms/process_file', $this->data);
    }
    
    public function generate_number_file()
    {
        $selected_operator_length = 0;
        $selected_operator = $this->input->post('operator_list');
        $selected_color = $this->input->post('color_list');
        if( $selected_operator != "" )
        {
            $selected_operator_length = strlen($selected_operator);
        }
        $number_list = array();
        
        $content = "";
        $file_content = read_file('./upload/'.$this->session->userdata('user_id').'.txt');
        $file_content_array = explode("\n", $file_content);
        foreach($file_content_array as $line)
        {
            if( $line != '' )
            {
                $line_array = explode("-", $line);
                $number_list[] = $line_array[0];
            }               
        }
        $result = array_count_values($number_list);
        arsort($result);
        $filtered_number_list = array();
        foreach($result as $number => $frequency)
        {
            if($frequency == 1 )
            {
                if( $selected_color == 1 || $selected_color == "" )
                {                    
                    $filtered_number_list[] = $number;
                }
            }
            else
            {
                for($counter = 0; $counter < $frequency; $counter++)
                {
                    if($counter == 0 )
                    {
                        if( $selected_color == 2 || $selected_color == "" )
                        {                    
                            $filtered_number_list[] = $number;
                        }
                    }   
                    else
                    {
                        if( $selected_color == 3 || $selected_color == "" )
                        {
                            $filtered_number_list[] = $number;
                        }
                    }
                }
            }
        }
        $processed_number_list = array();
        foreach($filtered_number_list as $filtered_number)
        {
            if(!in_array($filtered_number, $processed_number_list))
            {
                if( $selected_operator == "")
                {
                    $processed_number_list[] = $filtered_number;
                }
                else if( substr($filtered_number, 0,$selected_operator_length) == $selected_operator  )
                {
                    $processed_number_list[] = $filtered_number;
                } 
            }                      
        }
        foreach($processed_number_list as $number)
        {
            $content = $content . $number . "\n"; 
        }
        $file_name = now();
        header("Content-Type:text/plain");
        header("Content-Disposition: 'attachment'; filename=".$file_name.".txt");
        echo $content;
    }
}
