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
            $config['file_name'] = 'logo.png';
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload()) {
                $this->data['message'] = $this->upload->display_errors();
            } 
            else {

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
}
