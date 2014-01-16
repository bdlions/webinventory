<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends CI_Controller {
    /*
     * Holds account status list
     * 
     * $var array
     */

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('ion_auth');
        $this->load->library('org/product/product_library');
        $this->load->library('org/sale/sale_library');
        $this->load->library('org/stock/stock_library');
        $this->load->library('org/purchase/purchase_library');
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
    
    function sale_order()
    {
        $this->data['customer_list_array'] = array();
        $customer_list_array = $this->ion_auth->get_all_customers()->result_array();
        if( count($customer_list_array) > 0)
        {
            $this->data['customer_list_array'] = $customer_list_array;
        }  
        $this->data['product_list_array'] = array();
        $product_list_array = $this->product_library->get_all_products()->result_array();
        if( count($product_list_array) > 0)
        {
            $this->data['product_list_array'] = $product_list_array;
        }
        $this->data['customer_search_category'] = array();
        $this->data['customer_search_category'][0] = "Select an item";
        $this->data['customer_search_category']['phone'] = "Phone";
        $this->data['customer_search_category']['card_no'] = "Card No";
        
        $this->data['product_search_category'] = array();
        $this->data['product_search_category'][0] = "Select an item";
        $this->data['product_search_category']['name'] = "Product Name";
        $this->data['product_search_category']['code'] = "Product Code";
        
        $this->template->load(SALESMAN_LOGIN_SUCCESS_TEMPLATE, 'sales/sales_order',$this->data);
    }
    
    function add_sale()
    {
        $shop_id = $this->session->userdata('shop_id');
        $selected_product_list = $_POST['product_list'];
        $sale_product_list = array();
        $sale_info = $_POST['sale_info'];
        
        $product_quantity_map = array();        
        $stock_list_array = $this->stock_library->get_all_stocks($shop_id)->result_array();
        foreach($stock_list_array as $key => $stock_info)
        {
            $product_quantity_map[$stock_info['product_id'].'_'.$stock_info['purchase_order_no']] = $stock_info['stock_amount'];
        }
        foreach($selected_product_list as $key => $prod_info)
        {
            $product_info = array(
                'product_id' => $prod_info['product_id'],
                'quantity' => $prod_info['quantity'],
                'unit_price' => $prod_info['unit_price'],
                'purchase_order_no' => $prod_info['purchase_order_no'],
                'discount' => $prod_info['discount'],
                'sub_total' => $prod_info['sub_total']
            );
            $sale_product_list[] = $product_info;
            if ( array_key_exists($product_info['product_id'].'_'.$product_info['purchase_order_no'], $product_quantity_map) && ( $product_quantity_map[$stock_info['product_id'].'_'.$stock_info['purchase_order_no']] >= $prod_info['quantity'] ) ) {
                $update_stock_info = array(
                    'product_id' => $prod_info['product_id'],
                    'purchase_order_no' => $prod_info['purchase_order_no'],
                    'shop_id' => $shop_id,
                    'stock_amount' => ( $product_quantity_map[$stock_info['product_id'].'_'.$stock_info['purchase_order_no']] - $prod_info['quantity'] )
                );
                $update_stock_list[] = $update_stock_info;
            }
            else
            {
                $response['status'] = '0';
                $response['message'] = 'Insufficient stock for the product : '.$prod_info['product_code'].' and lot no : '.$prod_info['purchase_order_no'];
                echo json_encode($response);
                return;
            }
        }
        $additional_data = array(
            'sale_order_no' => $sale_info['sale_order_no'],
            'shop_id' => $shop_id,
            'customer_id' => $sale_info['customer_id'],
            'sale_order_status_id' => 1,
            'remarks' => $sale_info['remarks']
        );        
        $sale_id = $this->sale_library->add_sale_order($additional_data, $sale_product_list, $update_stock_list);
        if( $sale_id !== FALSE )
        {
            $sale_info_array = $this->sale_library->get_sale_order_info($sale_id)->result_array();
            $sale_info = array();
            if( count($sale_info_array) > 0 )
            {
                $sale_info = $sale_info_array[0];
            }
            $response['status'] = '1';
            $response['sale_info'] = $sale_info;
            $response['inserted_product_list'] = $sale_product_list;  
            
        } 
        else
        {
            $response['status'] = '0';
            $response['message'] = $this->ion_auth->errors_alert();
        }
        echo json_encode($response);
    }
    
    public function show_all_sales()
    {
        $this->data['sale_list'] = array();
        $sale_list_array = $this->sale_library->get_all_sales()->result_array();
        if( !empty($sale_list_array) )
        {
            $this->data['sale_list'] = $sale_list_array;
        } 
        $this->template->load(null, 'sales/show_all_sales', $this->data);
    }
}
