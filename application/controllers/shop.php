<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends CI_Controller {
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

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        
        if(!$this->ion_auth->logged_in())
        {
            redirect("user/login","refresh");
        }
        
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
    }
    
    function index()
    {
        redirect("shop/show_all_shops","refresh");
    }
    
    public function create_shop()
    {
        $shop_info = array();
        $user_info_array = $this->ion_auth->get_user_info()->result_array();
        if(!empty($user_info))
        {
            $user_info = $user_info_array[0];
            $shop_info = $this->ion_auth->get_user_shop_info($user_info['id'])->result_array();
        }
        
        if (!empty($shop_info)) {
            redirect('user/manager_login',"refresh");
        }
        
        $this->data['message'] = '';
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('shop_no', 'Shop No', 'xss_clean');
        $this->form_validation->set_rules('shop_name', 'Shop Name', 'xss_clean|required');
        $this->form_validation->set_rules('shop_phone', 'Shop Phone', 'xss_clean');
        $this->form_validation->set_rules('shop_type','Shop Type','xss_clean|required');
        $this->form_validation->set_rules('shop_address', 'Shop Address', 'xss_clean|required');
        if ($this->input->post('submit_create_shop')) 
        {
            if ($this->form_validation->run() == true) 
            {
                $additional_data = array(
                    'shop_no' => $this->input->post('shop_no'),
                    'name' => $this->input->post('shop_name'),
                    'address' => $this->input->post('shop_address'),
                    'shop_phone' => $this->input->post('shop_phone'),
                    'shop_type_id' => $this->input->post('shop_type'),
                    'created_on' => now()
                );
                $shop_id = $this->shop_library->create_shop($additional_data);
                if( $shop_id !== FALSE)
                {
                    
                    if($this->ion_auth->is_admin())
                     {
                         $this->session->set_flashdata('message', $this->shop_library->messages());
                         redirect('shop/create_shop','refresh');
                     }
                     else{
                         
                         $shop_info_array = $this->shop_library->get_shop($shop_id)->result_array();
                         $shop_info = $shop_info_array[0];
                         $logoaddress = base_url().'/assets/images/'.$shop_info['picture'];
                         $this->session->set_userdata(array('logoaddress' => $logoaddress, 'shop_id' => $shop_id));
                         $user_info_array = $this->ion_auth->get_user_info()->result_array();
                         $user_info = $user_info_array[0];
                         if($this->ion_auth->add_to_shop($user_info['id'],$shop_id))
                         {
                             redirect('user/manager_login','refresh');
                         }
                         
                     }
                    
                }
                else
                {
                    $this->data['message'] = $this->shop_library->errors();
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
        
        $shop_type_array = $this->shop_library->get_all_shop_type()->result_array();
        
        $this->data['shop_type'] = array();
        if( !empty($shop_type_array) )
        {
            foreach ($shop_type_array as $key => $shop_type) {
                $this->data['shop_type'][$shop_type['id']] = $shop_type['type'];
            }
        }
        $this->data['shop_no'] = array(
            'name' => 'shop_no',
            'id' => 'shop_no',
            'type' => 'text',
            'value' => $this->form_validation->set_value('shop_no'),
        );
        $this->data['shop_name'] = array(
            'name' => 'shop_name',
            'id' => 'shop_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('shop_name'),
        );
        $this->data['shop_phone'] = array(
            'name' => 'shop_phone',
            'id' => 'shop_phone',
            'type' => 'text',
            'value' => $this->form_validation->set_value('shop_phone'),
        );
        $this->data['shop_address'] = array(
            'name' => 'shop_address',
            'id' => 'shop_address',
            'type' => 'text',
            'value' => $this->form_validation->set_value('shop_address'),
        );
        $this->data['submit_create_shop'] = array(
            'name' => 'submit_create_shop',
            'id' => 'submit_create_shop',
            'type' => 'submit',
            'value' => 'Create',
        );
        if($this->ion_auth->is_admin())
        {
             $this->template->load(null, 'shop/create_shop',$this->data);   
        }
        else
        {
            $this->template-> load(ACCOUNT_VALIDATION_SMS_TEMPLATE,'shop/create_shop',$this->data);
        }
    }   
    
    public function show_all_shops()
    {
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
            
            if($user_group['id'] == USER_GROUP_MANAGER)
            {
                $this->session->set_flashdata('message',"You have no permission to view that page");
                redirect('user/manager_login',"refresh");
            }
            
        }
        
        
        
        $this->data['shop_list'] = array();
        $shop_list = $this->shop_library->get_all_shops()->result_array();
        if( !empty($shop_list) )
        {
            $this->data['shop_list'] = $shop_list;
        }
        $this->template->load(null, 'shop/show_all_shops', $this->data);
    }
    
   public function update_shop($shop_id)
    {
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
            
            if($user_group['id'] == USER_GROUP_MANAGER)
            {
                $this->session->set_flashdata('message',"You have no permission to view that page");
                redirect('user/manager_login',"refresh");
            }
        }
        
        
        //check whether shop id valid or not
        $this->data['message'] = '';
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('shop_no', 'Shop No', 'xss_clean');
        $this->form_validation->set_rules('shop_name', 'Shop Name', 'xss_clean|required');
        $this->form_validation->set_rules('shop_phone', 'Shop Phone', 'xss_clean');
        $this->form_validation->set_rules('shop_address', 'Shop Address', 'xss_clean|required');
        
        if ($this->input->post('submit_update_shop')) 
        {
            if ($this->form_validation->run() == true) 
            {
                $data = array(
                    'shop_no' => $this->input->post('shop_no'),
                    'name' => $this->input->post('shop_name'),
                    'address' => $this->input->post('shop_address'),
                    'shop_phone' => $this->input->post('shop_phone'),
                    'modified_date' => date('Y-m-d H:i:s')
                );
                if( $this->shop_library->update_shop($shop_id, $data) !== FALSE)
                {
                    $this->session->set_flashdata('message', $this->shop_library->messages());
                    redirect("shop/update_shop/".$shop_id,"refresh");
                }
                else
                {
                    $this->data['message'] = $this->shop_library->errors();
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
        $shop_info = array();
        $shop_info_array = $this->shop_library->get_shop($shop_id)->result_array();
        if( !empty($shop_info_array) )
        {
            $shop_info = $shop_info_array[0];
        }
        $this->data['shop_info'] = $shop_info;
        $this->data['shop_no'] = array(
            'name' => 'shop_no',
            'id' => 'shop_no',
            'type' => 'text',
            'value' => $shop_info['shop_no'],
        );
        $this->data['shop_name'] = array(
            'name' => 'shop_name',
            'id' => 'shop_name',
            'type' => 'text',
            'value' => $shop_info['name'],
        );
        $this->data['shop_phone'] = array(
            'name' => 'shop_phone',
            'id' => 'shop_phone',
            'type' => 'text',
            'value' => $shop_info['shop_phone'],
        );
        $this->data['shop_address'] = array(
            'name' => 'shop_address',
            'id' => 'shop_address',
            'type' => 'text',
            'value' => $shop_info['address'],
        );
        
        $this->data['submit_update_shop'] = array(
            'name' => 'submit_update_shop',
            'id' => 'submit_update_shop',
            'type' => 'submit',
            'value' => 'Update',
        );
        $this->template->load(null, 'shop/update_shop',$this->data);
    }
    /*
     * This method will update currently logged in shop of a user
     * @author Nazmul on 23rd January 2014
     */
    public function set_shop()
    {
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
            
            if($user_group['id'] == USER_GROUP_MANAGER)
            {
                $this->session->set_flashdata('message',"You have no permission to view that page");
                redirect('user/manager_login',"refresh");
            }
        }
        

        
        $this->data['message'] = '';
        $shop_list_array = $this->shop_library->get_all_shops()->result_array();
        $this->data['shop_list'] = array();
        if( !empty($shop_list_array) )
        {
            foreach ($shop_list_array as $key => $shop_info) {
                $this->data['shop_list'][$shop_info['id']] = $shop_info['name'];
            }
        }
        if ($this->input->post('submit_set_shop')) 
        {
            $shop_id = $this->input->post('shop_list');
            $session_data['shop_id'] = $shop_id;
            $this->session->set_userdata($session_data);
            $this->session->set_flashdata('message', 'You have logged into the shop named '.$this->data['shop_list'][$shop_id]);
            redirect("shop/set_shop","refresh");
        }
        else
        {
            $this->data['message'] = $this->session->flashdata('message'); 
        }
        $this->data['submit_set_shop'] = array(
            'name' => 'submit_set_shop',
            'id' => 'submit_set_shop',
            'type' => 'submit',
            'value' => 'Update',
        );
        $this->data['select_shop_id'] = $this->session->userdata('shop_id');
        $this->template->load(null, 'shop/set_shop', $this->data);
    }
}
