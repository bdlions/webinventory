<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
    /*
     * Holds account status list
     * 
     * $var array
     */

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('org/product/product_library');
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
    
    public function create_product()
    {
        $this->data['message'] = '';
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('product_name', 'Product Name', 'xss_clean|required');
        $this->form_validation->set_rules('product_code', 'Product Code', 'xss_clean|required');
        $this->form_validation->set_rules('product_size', 'Product Size', 'xss_clean');
        $this->form_validation->set_rules('product_weight', 'Product Weight', 'xss_clean');
        $this->form_validation->set_rules('product_warranty', 'Product Warranty', 'xss_clean');
        $this->form_validation->set_rules('brand_name', 'Brand Name', 'xss_clean');
        $this->form_validation->set_rules('unit_price', 'Unit Price', 'xss_clean|required');
        
        if ($this->input->post('submit_create_product')) 
        {
            if ($this->form_validation->run() == true) 
            {
                $additional_data = array(
                    'name' => $this->input->post('product_name'),
                    'code' => $this->input->post('product_code'),
                    'unit_price' => $this->input->post('unit_price'),
                    'created_date' => date('Y-m-d H:i:s')
                );
                $this->product_library->create_product($additional_data);
                redirect('product/show_all_products','refresh');
            }
            else
            {
                $this->data['message'] = validation_errors();
            }
        }
        
        $this->data['product_name'] = array(
            'name' => 'product_name',
            'id' => 'product_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('product_name'),
        );
        $this->data['product_code'] = array(
            'name' => 'product_code',
            'id' => 'product_code',
            'type' => 'text',
            'value' => $this->form_validation->set_value('product_code'),
        );
        $this->data['unit_price'] = array(
            'name' => 'unit_price',
            'id' => 'unit_price',
            'type' => 'text',
            'value' => $this->form_validation->set_value('unit_price'),
        );
        $this->data['submit_create_product'] = array(
            'name' => 'submit_create_product',
            'id' => 'submit_create_product',
            'type' => 'submit',
            'value' => 'Add',
        );
        $this->template->load(null, 'product/create_product', $this->data);
    }
    
    public function update_product($product_id)
    {
        //check whether product id valid or not
        $this->data['message'] = '';
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('product_name', 'Product Name', 'xss_clean|required');
        $this->form_validation->set_rules('product_code', 'Product Code', 'xss_clean|required');
        if ($this->input->post('submit_update_product')) 
        {
            if ($this->form_validation->run() == true) 
            {
                $data = array(
                    'name' => $this->input->post('product_name'),
                    'code' => $this->input->post('product_code'),
                    'unit_price' => $this->input->post('unit_price'),
                    'modified_date' => date('Y-m-d H:i:s')
                );
                $this->product_library->update_product($product_id, $data);
                $this->data['message'] = 'Product is updated successsfully.';
            }
            else
            {
                $this->data['message'] = validation_errors();
            }
        }
        $product_info = array();
        $product_info_array = $this->product_library->get_product($product_id)->result_array();
        if( count($product_info_array) > 0 )
        {
            $product_info = $product_info_array[0];
        }
        $this->data['product_info'] = $product_info;
        $this->data['product_name'] = array(
            'name' => 'product_name',
            'id' => 'product_name',
            'type' => 'text',
            'value' => $product_info['name'],
        );
        $this->data['product_code'] = array(
            'name' => 'product_code',
            'id' => 'product_code',
            'type' => 'text',
            'value' => $product_info['code'],
        );
        $this->data['unit_price'] = array(
            'name' => 'unit_price',
            'id' => 'unit_price',
            'type' => 'text',
            'value' => $product_info['unit_price'],
        );
        $this->data['submit_update_product'] = array(
            'name' => 'submit_update_product',
            'id' => 'submit_update_product',
            'type' => 'submit',
            'value' => 'Update',
        );
        $this->template->load(null, 'product/update_product', $this->data);
    }
    
    public function show_product($product_id)
    {
        $product_info = array();
        $product_info_array = $this->product_library->get_product($product_id)->result_array();
        if(count($product_info_array))
        {
            $product_info = $product_info_array[0];
        }
        print_r($product_info);
    }
    
    public function show_all_products()
    {
        $this->data['product_list'] = array();
        $product_list = $this->product_library->get_all_products()->result_array();
        if( count($product_list) > 0)
        {
            $this->data['product_list'] = $product_list;
        }
        $this->template->load(null, 'product/show_all_products', $this->data);
    }
    
    public function create_product_sale_order()
    {
        $response = array();
        $product_name = $_POST['product_name'];
        $product_code = $_POST['product_code'];
        $unit_price = $_POST['unit_price'];
        $additional_data = array(
            'name' => $product_name,
            'code' => $product_code,
            'unit_price' => $unit_price,
            'created_date' => date('Y-m-d H:i:s')
        );
        $product_id = $this->product_library->create_product($additional_data);
        if( $product_id >= 0 )
        {
            $product_info_array = $this->product_library->get_product($product_id)->result_array();
            $product_info = array();
            if( count($product_info_array) > 0 )
            {
                $product_info = $product_info_array[0];
            }
            $response['status'] = '1';
            $response['product_info'] = $product_info;            
        }  
        else
        {
           $response['status'] = '0';
        }
        echo json_encode($response);
    }
}
