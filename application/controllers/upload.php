<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {
    /*
     * Holds account status list
     * 
     * $var array
     */

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('org/shop/shop_library');
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
    
    public function upload_logo()
    {
        $this->data['message'] = ''; 
        if($this->input->post('submit_upload_logo'))
        {
            $config['upload_path'] = '././assets/images/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '0';
            $config['max_width'] = '0';
            $config['overwrite'] = TRUE;
            $config['max_height'] = '0';
            $num = rand(1,999999999);
            $config['file_name'] = 'logo.png';
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload()) {
                $this->data['message'] = $this->upload->display_errors();
            } 
            else
            {
                redirect('upload/upload_logo','refresh');
                                
            }
        }
        $this->data['submit_upload_logo'] = array(
            'name' => 'submit_upload_logo',
            'id' => 'submit_upload_logo',
            'type' => 'submit',
            'value' => 'Upload',
        );
        $this->template->load(null, 'upload/upload_logo', $this->data);
    }
    
    public function upload_cover()
    {
        $this->data['message'] = ''; 
        if($this->input->post('submit_upload_cover'))
        {
            $config['upload_path'] = '././assets/images/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '0';
            $config['max_width'] = '0';
            $config['overwrite'] = TRUE;
            $config['max_height'] = '0';
            $num = rand(1,999999999);
            $config['file_name'] = $num.'.png';
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload()) {
                $this->data['message'] = $this->upload->display_errors();
            } 
            else
            {
                $logoaddress = base_url().'/assets/images/'.$num.'.png';
            
                // inserting $logoaddress into session
                $this->session->set_userdata(array('logoaddress' => $logoaddress));
                
                
                //redwan
                $additional_data = array('picture' => $num);
                //echo '<pre>';
                //print_r($additional_data);
                //exit('Hi');
                $shop_id = $this->session->userdata('shop_id');
                
                if($this->shop_library->update_shop($shop_id, $additional_data))
                {
                    redirect('upload/upload_logo','refresh');
                    echo 'doneasdasdasdhasdbcsHBDZcbnozhxoiuvzxhfovbhpofhxzxdfnvzipdohnjf';
                }
                else
                {
                    $this->data['message'] = 'logo is not uploaded.. update_shop  Try again';
                }
                //redirect('upload/upload_logo','refresh');
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
