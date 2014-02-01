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
        $this->load->library('org/common/sms_configuration');
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
        redirect("shop/show_all_shops","refresh");
    }
    /*
     * This method will update currently logged in shop of a user
     * @author Nazmul on 23rd January 2014
     */
    public function sms_configuration_shop()
    {
        $this->data['message'] = '';
        $shop_id = $this->session->userdata('shop_id');
        $sms_configuration_shop_status = false;
        $sms_configuration_shop_array = $this->sms_configuration->get_sms_configuration_shop()->result_array();
        if(!empty($sms_configuration_shop_array))
        {
            $sms_configuration_shop_status = $sms_configuration_shop_array[0]['status'];
        }
        $this->data['select_shop_id'] = $this->session->userdata('shop_id');
        $shop_list_array = $this->shop_library->get_all_shops()->result_array();
        $this->data['shop_list'] = array();
        if( !empty($shop_list_array) )
        {
            foreach ($shop_list_array as $key => $shop_info) {
                $this->data['shop_list'][$shop_info['id']] = $shop_info['name'];
            }
        }
        $this->data['select_shop_id'] = $shop_id;
        if ($this->input->post('submit_sms_configuration_shop')) 
        {
            $shop_id = $this->input->post('shop_list');
            if($this->input->post('sms_configuration_status'))
            {
                print_r("clicked");
            }
            else
            {
                print_r("not clicked");
            }
            print_r($this->input->post());
            return;
        }
        else
        {
            $this->data['message'] = $this->session->flashdata('message'); 
        }
        $this->data['sms_configuration_shop_status'] = array(
            'name' => 'sms_configuration_shop_status',
            'id' => 'sms_configuration_shop_status',
            'checked' => ''
        );
        $this->data['submit_sms_configuration_shop'] = array(
            'name' => 'submit_sms_configuration_shop',
            'id' => 'submit_sms_configuration_shop',
            'type' => 'submit',
            'value' => 'Update',
        );        
        $this->template->load(null, 'sms/sms_configuration_shop', $this->data);
    }
    
    public function process_file()
    {
        $this->data['message'] = '';
        $this->template->load(null, 'sms/process_file', $this->data);
    }
}
