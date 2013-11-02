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
    }
    
    function index()
    {
        
    }
    
    public function create_shop()
    {
        $this->data['message'] = '';
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('shop_no', 'Shop No', 'xss_clean');
        $this->form_validation->set_rules('shop_name', 'Shop Name', 'xss_clean|required');
        $this->form_validation->set_rules('shop_phone', 'Shop Phone', 'xss_clean');
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
                    'created_date' => date('Y-m-d H:i:s')
                );
                $this->shop_library->create_shop($additional_data);
                redirect('shop/show_all_shops','refresh');
            }
            else
            {
                $this->data['message'] = validation_errors();
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
            'value' => 'Add',
        );
        $this->template->load(null, 'shop/create_shop',$this->data);
    }
    
    public function show_all_shops()
    {
        $this->data['shop_list'] = array();
        $shop_list = $this->shop_library->get_all_shops()->result_array();
        if( count($shop_list) > 0)
        {
            $this->data['shop_list'] = $shop_list;
        }
        $this->template->load(null, 'shop/show_all_shops', $this->data);
    }
    
    public function update_shop($shop_id)
    {
        $shop_info = array();
        $shop_info_array = $this->shop_library->get_shop($shop_id)->result_array();
        if( count($shop_info_array) > 0 )
        {
            $shop_info = $shop_info_array[0];
        }
        else
        {
            //go to a page to display that the given shop id is invalid
        }
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
                $this->shop_library->update_shop($shop_id, $data);
                $this->data['message'] = 'Shop is updated successsfully.';
            }
            else
            {
                $this->data['message'] = validation_errors();
            }
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
}
