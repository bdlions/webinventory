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
        
        if(!$this->ion_auth->logged_in())
        {
            redirect("user/login","refresh");
        }
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
        /*$this->data['message'] = ''; 
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
                    redirect('upload/upload_cover','refresh');
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
         * */
        
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
            
            if($user_group['id'] == USER_GROUP_SALESMAN)
            {
                $this->session->set_flashdata('message',"You have no permission to view that page");
                redirect('user/salesman_login',"refresh");
            }
        }
        
        $shop_id = $this->session->userdata('shop_id');
        $shop_info = array();
        $shop_info_array = $this->shop_library->get_shop($shop_id)->result_array();
        if(!empty($shop_info_array))
        {
            $shop_info = $shop_info_array[0];
            $this->data['shop_cover_photo'] = base_url().'assets/images/'.$shop_info['picture'];
        }
        if ($this->input->post('submit_shop_cover_photo')) {
            $shop_cover_photo_name = random_string('unique').".jpg";
            $config['upload_path'] = '././assets/images/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '0';
            $config['max_width'] = '0';
            $config['overwrite'] = TRUE;
            $config['max_height'] = '0';
            $config['file_name'] = $shop_cover_photo_name;

            $this->load->library('upload', $config);
			
            if (!$this->upload->do_upload()) {
                $this->data['message'] = $this->upload->display_errors();
            } else {
                $this->data['shop_cover_photo'] = base_url().'assets/images/'.$shop_cover_photo_name."?a=1";                
            }
        }
        $this->data['submit_shop_cover_photo'] = array(
            'name' => 'submit_shop_cover_photo',
            'id' => 'submit_shop_cover_photo',
            'type' => 'submit',
            'value' => 'Upload',
        );
        $this->template->load(null, 'upload/upload_cover', $this->data); 
    }
    
    function save_cover_photo() 
    {
        $shop_cover_photo_name = random_string('unique').".jpg";
        $shop_cover_photo_path = '././assets/images/'.$shop_cover_photo_name;
        $image_data = $_POST['image_data'];
        $filteredData=substr($image_data, strpos($image_data, ",")+1);
        $unencodedData=base64_decode($filteredData);
        //write_file(FCPATH.$profile_pic_path, $unencodedData);    
        if ( ! write_file(FCPATH.$shop_cover_photo_path, $unencodedData) )
        {
            echo 0;
        }
        else
        {
            $additional_data = array('picture' => $shop_cover_photo_name);
            $shop_id = $this->session->userdata('shop_id');
            if(!$this->shop_library->update_shop($shop_id, $additional_data))
            {
                echo 0;
            }
            $logoaddress = base_url().'/assets/images/'.$shop_cover_photo_name;
            $this->session->set_userdata(array('logoaddress' => $logoaddress));
            echo 1;
        }
    }
}
