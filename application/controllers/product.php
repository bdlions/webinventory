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
        $message_data = '';
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('name', 'Product Name', 'xss_clean|required');
        $this->form_validation->set_rules('code', 'Product Code', 'xss_clean|required');
        $this->form_validation->set_rules('size', 'Product Size', 'xss_clean');
        $this->form_validation->set_rules('weight', 'Product Weight', 'xss_clean');
        $this->form_validation->set_rules('warranty', 'Product Warranty', 'xss_clean');
        $this->form_validation->set_rules('quality', 'Product Quality', 'xss_clean');
        $this->form_validation->set_rules('brand_name', 'Brand Name', 'xss_clean');
        $this->form_validation->set_rules('unit_price', 'Unit Price', 'xss_clean|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'xss_clean');
        
        if ($this->input->post('submit_create_product')) 
        {            
            if($this->form_validation->run() == true)
            {
                $additional_data = array(
                    'size' => $this->input->post('size'),
                    'weight' => $this->input->post('weight'),
                    'warranty' => $this->input->post('warranty'),
                    'quality' => $this->input->post('quality'),
                    'brand_name' => $this->input->post('brand_name'),
                    'remarks' => $this->input->post('remarks'),
                    'unit_price' => $this->input->post('unit_price')
                );
                $product_name = $this->input->post('name');
                $product_code = $this->input->post('code');
                $product_id = $this->product_library->create_product($product_name, $product_code, $additional_data);
                if( $product_id !== FALSE )
                {
                    $this->session->set_flashdata('message', $this->product_library->messages());
                    redirect('product/create_product','refresh');
                }
                else
                {
                    $this->data['message'] = $this->product_library->errors();
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
        
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'class' => 'span2',
            'value' => $this->form_validation->set_value('name'),
        );
        $this->data['code'] = array(
            'name' => 'code',
            'id' => 'code',
            'type' => 'text',
            'class' => 'span2',
            'value' => $this->form_validation->set_value('code'),
        );
        $this->data['size'] = array(
            'name' => 'size',
            'id' => 'size',
            'type' => 'text',
            'class' => 'span2',
            'value' => $this->form_validation->set_value('size'),
        );
        $this->data['weight'] = array(
            'name' => 'weight',
            'id' => 'weight',
            'type' => 'text',
            'class' => 'span2',
            'value' => $this->form_validation->set_value('weight'),
        );
        $this->data['warranty'] = array(
            'name' => 'warranty',
            'id' => 'warranty',
            'type' => 'text',
            'class' => 'span2',
            'value' => $this->form_validation->set_value('warranty'),
        );
        $this->data['quality'] = array(
            'name' => 'quality',
            'id' => 'quality',
            'type' => 'text',
            'class' => 'span2',
            'value' => $this->form_validation->set_value('quality'),
        );
        $this->data['unit_price'] = array(
            'name' => 'unit_price',
            'id' => 'unit_price',
            'type' => 'text',
            'class' => 'span2',
            'value' => $this->form_validation->set_value('unit_price'),
        );
        $this->data['brand_name'] = array(
            'name' => 'brand_name',
            'id' => 'brand_name',
            'type' => 'text',
            'class' => 'span2',
            'value' => $this->form_validation->set_value('brand_name'),
        );
        $this->data['remarks'] = array(
            'name' => 'remarks',
            'id' => 'remarks',
            'type' => 'text',
            'class' => 'span2',
            'value' => $this->form_validation->set_value('remarks'),
        );
        $this->data['submit_create_product'] = array(
            'name' => 'submit_create_product',
            'id' => 'submit_create_product',
            'type' => 'submit',
            'value' => 'Add',
        );
        $this->template->load(null, 'product/create_product', $this->data);
    }
    
    public function show_all_products()
    {
        $this->data['product_list'] = array();
        $product_list_array = $this->product_library->get_all_products()->result_array();
        if( !empty($product_list_array) )
        {
            $this->data['product_list'] = $product_list_array;
        }
        $this->template->load(null, 'product/show_all_products', $this->data);
    }
    
    public function update_product($product_id = '')
    {
        if(empty($product_id))
        {
            redirect("product/show_all_products","refresh");
        }
        $this->data['message'] = '';
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('size', 'Product Size', 'xss_clean');
        $this->form_validation->set_rules('weight', 'Product Weight', 'xss_clean');
        $this->form_validation->set_rules('warranty', 'Product Warranty', 'xss_clean');
        $this->form_validation->set_rules('quality', 'Product Quality', 'xss_clean');
        $this->form_validation->set_rules('brand_name', 'Brand Name', 'xss_clean');
        $this->form_validation->set_rules('unit_price', 'Unit Price', 'xss_clean|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'xss_clean');
        
        $product_info = array();
        $product_info_array = $this->product_library->get_product($product_id)->result_array();
        if(empty($product_info_array))
        {
            redirect("product/show_all_products","refresh");
        }
        else
        {
            $product_info = $product_info_array[0];
        }
        $this->data['product_info'] = $product_info;
        if ($this->input->post('submit_update_product')) 
        {            
            if($this->form_validation->run() == true)
            {
                $additional_data = array(
                    'size' => $this->input->post('size'),
                    'weight' => $this->input->post('weight'),
                    'warranty' => $this->input->post('warranty'),
                    'quality' => $this->input->post('quality'),
                    'brand_name' => $this->input->post('brand_name'),
                    'remarks' => $this->input->post('remarks'),
                    'unit_price' => $this->input->post('unit_price')
                );
                if( $this->product_library->update_product($product_id, $additional_data) )
                {
                    $this->session->set_flashdata('message', $this->product_library->messages());
                    redirect('product/update_product/'.$product_info['id'],'refresh');
                }
                else
                {
                    $this->data['message'] = $this->product_library->errors();
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
        
        $this->data['size'] = array(
            'name' => 'size',
            'id' => 'size',
            'type' => 'text',
            'class' => 'span2',
            'value' => $product_info['size']
        );
        $this->data['weight'] = array(
            'name' => 'weight',
            'id' => 'weight',
            'type' => 'text',
            'class' => 'span2',
            'value' => $product_info['weight']
        );
        $this->data['warranty'] = array(
            'name' => 'warranty',
            'id' => 'warranty',
            'type' => 'text',
            'class' => 'span2',
            'value' => $product_info['warranty']
        );
        $this->data['quality'] = array(
            'name' => 'quality',
            'id' => 'quality',
            'type' => 'text',
            'class' => 'span2',
            'value' => $product_info['quality']
        );
        $this->data['unit_price'] = array(
            'name' => 'unit_price',
            'id' => 'unit_price',
            'type' => 'text',
            'class' => 'span2',
            'value' => $product_info['unit_price']
        );
        $this->data['brand_name'] = array(
            'name' => 'brand_name',
            'id' => 'brand_name',
            'type' => 'text',
            'class' => 'span2',
            'value' => $product_info['brand_name']
        );
        $this->data['remarks'] = array(
            'name' => 'remarks',
            'id' => 'remarks',
            'type' => 'text',
            'class' => 'span2',
            'value' => $product_info['remarks']
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
    
    /*
     * This method will create a new product into the system
     * @return status, 0 for error and 1 for success
     * @return message, if there is any error
     * @return product_info, newly created product
     * @author Nazmul
     */
    public function create_product_sale_order()
    {
        $response = array();
        $product_name = $_POST['product_name'];
        $product_code = $_POST['product_code'];
        $unit_price = $_POST['unit_price'];
        $additional_data = array(
            'unit_price' => $unit_price
        );
        $product_id = $this->product_library->create_product($product_name, $product_code, $additional_data);
        if( $product_id !== FALSE )
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
           $response['message'] = $this->product_library->errors_alert();
        }
        echo json_encode($response);
    }
}
