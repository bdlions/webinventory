<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {
    /*
     * Holds account status list
     * 
     * $var array
     */

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('org/common/utils');
        $this->load->library('org/product/product_library');
        $this->load->helper('url');

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
        $this->load->library('org/stock/stock_library');
        
        if(!$this->ion_auth->logged_in())
        {
            redirect("user/login","refresh");
        }
    }
    
    function index()
    {
        
    }
    
    /*function show_all_stocks()
    {
        $product_list = array();
        $product_list_array = $this->product_library->get_all_products()->result_array();
        foreach($product_list_array as $product_info)
        {
            $product_list[$product_info['id']] = $product_info['name'];
        }
        $this->data['product_list'] = $product_list;
        
        $total_quantity = 0;
        $total_stock_value = 0;
        $this->data['stock_list'] = array();
        $stock_list = array();
        $stock_list_array = $this->stock_library->get_all_stocks()->result_array();
        if( !empty($stock_list_array) )
        {
            foreach($stock_list_array as $stock_info)
            {
                $total_quantity = $total_quantity + $stock_info['stock_amount'];
                $total_stock_value = $total_stock_value + $stock_info['stock_amount']*$stock_info['purchase_unit_price'];
                $stock_info['created_on'] = $this->utils->process_time($stock_info['created_on']);
                $stock_list[] = $stock_info;
            }
        }
        $this->data['stock_list'] = $stock_list;
        $this->data['total_quantity'] = $total_quantity;
        $this->data['total_stock_value'] = $total_stock_value;
        $this->template->load(null, 'stock/show_all_stocks', $this->data);
    }*/
    
    function show_all_stocks()
    {
        $product_list = array();
        $product_list_array = $this->product_library->get_all_products()->result_array();
        foreach($product_list_array as $product_info)
        {
            $product_list[$product_info['id']] = $product_info['name'];
        }
        $this->data['product_list'] = $product_list;
        $total_quantity = 0;
        $total_stock_value = 0;
        $stock_list_array = $this->stock_library->search_stocks()->result_array();
        if( !empty($stock_list_array) )
        {
            foreach($stock_list_array as $stock_info)
            {
                $total_quantity = $total_quantity + $stock_info['current_stock'];
                $total_stock_value = $total_stock_value + $stock_info['current_stock']*$stock_info['unit_price'];                
            }
        }
        $this->data['stock_list'] = $stock_list_array;
        $this->data['total_quantity'] = $total_quantity;
        $this->data['total_stock_value'] = $total_stock_value;
        $this->template->load(null, 'stock/show_all_stocks', $this->data);
    }
    
    /*function search_stock()
    {
        $total_quantity = 0;
        $total_stock_value = 0;
        $stock_list = array();
        $shop_id = $this->session->userdata('shop_id');
        $product_id             = $_POST['product_id'];
        $purchase_order_no      = $_POST['purchase_order_no'];
        $stock_list_array = $this->stock_library->get_all_stocks($shop_id, $product_id, $purchase_order_no)->result_array();
        foreach($stock_list_array as $stock_info)
        {
            $total_quantity = $total_quantity + $stock_info['stock_amount'];
            $total_stock_value = $total_stock_value + $stock_info['stock_amount']*$stock_info['purchase_unit_price'];
            $stock_info['created_on'] = $this->utils->process_time($stock_info['created_on']);
            $stock_list[] = $stock_info;
        }
        $result = array(
            'stock_list' => $stock_list,
            'total_quantity' => $total_quantity,
            'total_stock_value' => $total_stock_value
        );
        echo json_encode($result);
    }*/
    
    function search_stock()
    {
        $product_id             = $_POST['product_id'];
        $purchase_order_no      = $_POST['purchase_order_no'];
        $total_quantity = 0;
        $total_stock_value = 0;
        $stock_list_array = $this->stock_library->search_stocks($product_id, $purchase_order_no)->result_array();
        if( !empty($stock_list_array) )
        {
            foreach($stock_list_array as $stock_info)
            {
                $total_quantity = $total_quantity + $stock_info['current_stock'];
                $total_stock_value = $total_stock_value + $stock_info['current_stock']*$stock_info['unit_price'];                
            }
        }
        $result = array(
            'stock_list' => $stock_list_array,
            'total_quantity' => $total_quantity,
            'total_stock_value' => $total_stock_value
        );
        echo json_encode($result);
    }
    
    public function update_stock()
    {
        $this->data['message'] = '';
        $this->template->load(null, 'stock/update_stock', $this->data);
    }
}
