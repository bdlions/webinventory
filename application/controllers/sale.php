<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends CI_Controller {
    /*
     * Holds account status list
     * 
     * $var array
     */
    protected $payment_type_list = array();
    protected $payment_category_list = array();
    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('ion_auth');
        $this->load->library('org/common/payments');
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
        $this->payment_type_list = $this->config->item('payment_type', 'ion_auth');
        $this->payment_category_list = $this->config->item('payment_category', 'ion_auth');
        $this->lang->load('auth');
        $this->load->helper('language');
    }
    
    function index()
    {
        
    }
    
    function sale_order()
    {
        $salesman_list = array();
        $salesman_list_array = $this->ion_auth->get_all_salesman()->result_array();
        if(!empty($salesman_list_array))
        {
            foreach($salesman_list_array as $key => $salesman_info)
            {
                $salesman_list[$salesman_info['user_id']] = $salesman_info['first_name'].' '.$salesman_info['last_name'];
            }
        }
        $this->data['salesman_list'] = $salesman_list;
        $this->data['user_info'] = array();
        $user_info_array = $this->ion_auth->user()->result_array();
        if(!empty($user_info_array))
        {
            $this->data['user_info'] = $user_info_array[0];
        }
        
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
        
        $this->template->load(null, 'sales/sales_order',$this->data);
    }
    
    function add_sale()
    {
        $current_time = now();
        $shop_id = $this->session->userdata('shop_id');
        $selected_product_list = $_POST['product_list'];
        $sale_product_list = array();
        $sale_info = $_POST['sale_info'];
        $current_due = $_POST['current_due'];
        
        $product_quantity_map = array();        
        $stock_list_array = $this->stock_library->get_all_stocks($shop_id)->result_array();
        foreach($stock_list_array as $key => $stock_info)
        {
            $product_quantity_map[$stock_info['product_id'].'_'.$stock_info['purchase_order_no']] = $stock_info['stock_amount'];
        }
        $customer_transaction_info_array = array();
        foreach($selected_product_list as $key => $prod_info)
        {
            $customer_transaction_info = array(
                'sale_order_no' => $sale_info['sale_order_no'],
                'shop_id' => $shop_id,
                'customer_id' => $sale_info['customer_id'],
                'created_on' => $current_time,
                'lot_no' => $prod_info['purchase_order_no'],
                'name' => $prod_info['name'],
                'quantity' => $prod_info['quantity'],
                'unit_price' => $prod_info['unit_price'],
                'sub_total' => $prod_info['sub_total'],
                'payment_status' => '',
                'profit' => ''
            );
            $customer_transaction_info_array[] = $customer_transaction_info;
            
            $product_info = array(
                'created_on' => $current_time,
                'product_id' => $prod_info['product_id'],
                'quantity' => $prod_info['quantity'],
                'unit_price' => $prod_info['unit_price'],
                'purchase_order_no' => $prod_info['purchase_order_no'],
                'shop_id' => $shop_id,
                'sale_order_no' => $sale_info['sale_order_no'],
                'sub_total' => $prod_info['sub_total'],
                'created_by' => $sale_info['created_by']
            );
            $sale_product_list[] = $product_info;
            if ( array_key_exists($product_info['product_id'].'_'.$product_info['purchase_order_no'], $product_quantity_map) && ( $product_quantity_map[$product_info['product_id'].'_'.$product_info['purchase_order_no']] >= $prod_info['quantity'] ) ) {
                $update_stock_info = array(
                    'product_id' => $prod_info['product_id'],
                    'purchase_order_no' => $prod_info['purchase_order_no'],
                    'shop_id' => $shop_id,
                    'stock_amount' => ( $product_quantity_map[$product_info['product_id'].'_'.$product_info['purchase_order_no']] - $prod_info['quantity'] )
                );
                $update_stock_list[] = $update_stock_info;
            }
            else
            {
                $response['status'] = '0';
                $response['message'] = 'Insufficient stock for the product : '.$prod_info['name'].' and lot no : '.$prod_info['purchase_order_no'];
                echo json_encode($response);
                return;
            }
        }
        $customer_transaction_info = array(
            'sale_order_no' => $sale_info['sale_order_no'],
            'shop_id' => $shop_id,
            'customer_id' => $sale_info['customer_id'],
            'created_on' => $current_time,
            'lot_no' => '',
            'name' => '',
            'quantity' => '',
            'unit_price' => '',
            'sub_total' => $current_due+$sale_info['cash_paid']+$sale_info['check_paid'],
            'payment_status' => 'Total due',
            'profit' => ''
        );
        $customer_transaction_info_array[] = $customer_transaction_info;
        if( $sale_info['cash_paid']+$sale_info['check_paid'] > 0)
        {
            if( $sale_info['cash_paid'] > 0 )
            {
                $customer_transaction_info = array(
                    'sale_order_no' => $sale_info['sale_order_no'],
                    'shop_id' => $shop_id,
                    'customer_id' => $sale_info['customer_id'],
                    'created_on' => $current_time,
                    'lot_no' => '',
                    'name' => '',
                    'quantity' => '',
                    'unit_price' => '',
                    'sub_total' => $sale_info['cash_paid'],
                    'payment_status' => 'Payment(Cash)',
                    'profit' => ''
                );
                $customer_transaction_info_array[] = $customer_transaction_info;
            }
            if( $sale_info['check_paid'] > 0 )
            {
                $customer_transaction_info = array(
                    'sale_order_no' => $sale_info['sale_order_no'],
                    'shop_id' => $shop_id,
                    'customer_id' => $sale_info['customer_id'],
                    'created_on' => $current_time,
                    'lot_no' => '',
                    'name' => '',
                    'quantity' => '',
                    'unit_price' => '',
                    'sub_total' => $sale_info['check_paid'],
                    'payment_status' => 'Payment(Check)',
                    'profit' => ''
                );
                $customer_transaction_info_array[] = $customer_transaction_info;
            }
            if( $current_due > 0)
            {
                $customer_transaction_info = array(
                    'sale_order_no' => $sale_info['sale_order_no'],
                    'shop_id' => $shop_id,
                    'customer_id' => $sale_info['customer_id'],
                    'created_on' => $current_time,
                    'lot_no' => '',
                    'name' => '',
                    'quantity' => '',
                    'unit_price' => '',
                    'sub_total' => $current_due,
                    'payment_status' => 'Total due',
                    'profit' => ''
                );
                $customer_transaction_info_array[] = $customer_transaction_info;
            }
        }
        
        $customer_payment_data_array = array();
        if( $sale_info['cash_paid'] > 0)
        {
            $customer_payment_data = array(
                'sale_order_no' => $sale_info['sale_order_no'],
                'payment_type_id' => $this->payment_type_list['cash_id'],
                'payment_category_id' => $this->payment_category_list['sale_payment_id'],
                'shop_id' => $shop_id,
                'customer_id' => $sale_info['customer_id'],
                'amount' => $sale_info['cash_paid'],
                'description' => 'sale cash',
                'reference_id' => $sale_info['sale_order_no'],
                'created_on' => $current_time
            );
            $customer_payment_data_array[] = $customer_payment_data;
        }
        if( $sale_info['check_paid'] > 0)
        {
            $customer_payment_data = array(
                'sale_order_no' => $sale_info['sale_order_no'],
                'payment_type_id' => $this->payment_type_list['cash_id'],
                'payment_category_id' => $this->payment_category_list['sale_payment_id'],
                'shop_id' => $shop_id,
                'customer_id' => $sale_info['customer_id'],
                'amount' => $sale_info['check_paid'],
                'description' => 'sale check:'.$sale_info['check_description'],
                'reference_id' => $sale_info['sale_order_no'],
                'created_on' => $current_time
            );
            $customer_payment_data_array[] = $customer_payment_data;
        }
        
        $additional_data = array(
            'sale_date' => $current_time,
            'created_on' => $current_time,
            'total' => $sale_info['total'],
            'paid' => $sale_info['cash_paid']+$sale_info['check_paid'],
            'sale_order_no' => $sale_info['sale_order_no'],
            'shop_id' => $shop_id,
            'customer_id' => $sale_info['customer_id'],
            'sale_order_status_id' => 1,
            'remarks' => $sale_info['remarks'],            
            'created_by' => $sale_info['created_by']
        );        
        $sale_id = $this->sale_library->add_sale_order($additional_data, $sale_product_list, $update_stock_list, $customer_payment_data_array, $customer_transaction_info_array);
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
    
    /*public function show_all_sales()
    {
        $this->data['sale_list'] = array();
        $sale_list_array = $this->sale_library->get_all_sales()->result_array();
        if( !empty($sale_list_array) )
        {
            $this->data['sale_list'] = $sale_list_array;
        } 
        $this->template->load(null, 'sales/show_all_sales', $this->data);
    }*/
    public function delete_sale()
    {
        $this->data['message'] = '';
        if($this->input->post('submit_delete_sale'))
        {
            $sale_order_no = $this->input->post('sale_order_no');
            $this->return_sale($sale_order_no);
            redirect('sale/delete_sale','refresh');
        }
        else
        {
            $this->data['message'] = $this->session->flashdata('message'); 
        }
        $this->data['sale_order_no'] = array(
            'name' => 'sale_order_no',
            'id' => 'sale_order_no',
            'type' => 'text',
            'value' => ''
        );
        $this->data['submit_delete_sale'] = array(
            'name' => 'submit_delete_sale',
            'id' => 'submit_delete_sale',
            'type' => 'submit',
            'value' => 'Delete',
        );
        $this->template->load(null, 'sales/delete_sale', $this->data);
    }
    public function return_sale($sale_order_no)
    {
        $shop_id = $this->session->userdata('shop_id');
        $customer_transaction_info_array = array();
        $current_time = now();
        //update stock for this sale order
        $update_stock_list = array();
        $product_quantity_map = array();        
        $stock_list_array = $this->stock_library->get_all_stocks($shop_id)->result_array();
        foreach($stock_list_array as $key => $stock_info)
        {
            $product_quantity_map[$stock_info['product_id'].'_'.$stock_info['purchase_order_no']] = $stock_info['stock_amount'];
        }
        $sale_order_info = array();
        $sale_order_array = $this->sale_library->get_sale_order($sale_order_no)->result_array();
        if(!empty($sale_order_array))
        {
            $sale_order_info = $sale_order_array[0];
        }
        else
        {
            $this->session->set_flashdata('message', 'sale order doesnot exist.');
            return;
        }
        $product_sale_order_array = $this->sale_library->get_product_sale_orders($sale_order_no)->result_array();
        if(!empty($product_sale_order_array))
        {
            foreach($product_sale_order_array as $product_info)
            {
                $update_stock_info = array(
                    'product_id' => $product_info['product_id'],
                    'purchase_order_no' => $product_info['purchase_order_no'],
                    'shop_id' => $product_info['shop_id'],
                    'stock_amount' => ( $product_quantity_map[$product_info['product_id'].'_'.$product_info['purchase_order_no']] + $product_info['quantity'] )
                );
                $update_stock_list[] = $update_stock_info;
                
                $customer_transaction_info = array(
                    'sale_order_no' => $product_info['sale_order_no'],
                    'shop_id' => $shop_id,
                    'customer_id' => $sale_order_info['customer_id'],
                    'created_on' => $current_time,
                    'lot_no' => $product_info['purchase_order_no'],
                    'name' => '',
                    'quantity' => $product_info['quantity'],
                    'unit_price' => $product_info['unit_price'],
                    'sub_total' => $product_info['sub_total'],
                    'payment_status' => 'Return Product',
                    'profit' => ''
                );
                $customer_transaction_info_array[] = $customer_transaction_info;
            }
        }
        if(!empty($update_stock_list))
        {
            $this->stock_library->update_stock($update_stock_list);
        }
        $this->sale_library->delete_product_sale_order($sale_order_no);
        $this->sale_library->delete_sale_order($sale_order_no);
        $this->payments->delete_customer_payment($sale_order_no);
        //add in customer transaction
        $current_due = $this->payments->get_customer_current_due($sale_order_info['customer_id']);
        $customer_transaction_info = array(
            'sale_order_no' => $product_info['sale_order_no'],
            'shop_id' => $shop_id,
            'customer_id' => $sale_order_info['customer_id'],
            'created_on' => now(),
            'lot_no' => '',
            'name' => '',
            'quantity' => '',
            'unit_price' => '',
            'sub_total' => $current_due,
            'payment_status' => 'Total due',
            'profit' => ''
        );
        $customer_transaction_info_array[] = $customer_transaction_info;
        $this->payments->add_customer_transactions($customer_transaction_info_array);
        $this->session->set_flashdata('message', 'sale order is removed.');
    }
}
