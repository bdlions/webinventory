<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends CI_Controller {
    /*
     * Holds account status list
     * 
     * $var array
     */

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('ion_auth');
        $this->load->library('org/common/payments');
        $this->load->library('org/product/product_library');
        $this->load->library('org/purchase/purchase_library');
        $this->load->library('org/stock/stock_library');
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
        redirect("purchase/purchase_order","refresh");
    }
    
    /*
     * This method will display purchase page after retrieving relevant data
     * @author Nazmul on 23rd January 2014 
     */
    function purchase_order()
    {
        $this->data['supplier_list_array'] = array();
        $supplier_list_array = $this->ion_auth->get_all_suppliers()->result_array();
        if( count($supplier_list_array) > 0)
        {
            $this->data['supplier_list_array'] = $supplier_list_array;
        }
        $this->data['product_list_array'] = array();
        $product_list_array = $this->product_library->get_all_products()->result_array();
        if( count($product_list_array) > 0)
        {
            $this->data['product_list_array'] = $product_list_array;
        }
        
        $this->data['supplier_search_category'] = array();
        $this->data['supplier_search_category'][0] = "Select an item";
        $this->data['supplier_search_category']['phone'] = "Phone";
        $this->data['supplier_search_category']['company'] = "Company";
        
        $this->data['product_search_category'] = array();
        $this->data['product_search_category'][0] = "Select an item";
        $this->data['product_search_category']['name'] = "Product Name";
        $this->template->load(null, 'purchase/purchase_order',$this->data);
    }
    
    function raise_purchase_order()
    {
        $this->data['product_list_array'] = array();
        $product_list_array = $this->product_library->get_all_products()->result_array();
        if( count($product_list_array) > 0)
        {
            $this->data['product_list_array'] = $product_list_array;
        }
        
        $this->data['supplier_search_category'] = array();
        $this->data['supplier_search_category'][0] = "Select an item";
        $this->data['supplier_search_category']['phone'] = "Phone";
        $this->data['supplier_search_category']['company'] = "Company";
        
        $this->data['product_search_category'] = array();
        $this->data['product_search_category'][0] = "Select an item";
        $this->data['product_search_category']['name'] = "Product Name";
        $this->template->load(null, 'purchase/raise_purchase_order',$this->data);
    }
    /*
     */
    public function get_purchase_info_from_lot_no()
    {
        $result = array();
        $supplier_info = array();
        $product_list = array();
        $supplier_due = 0;
        $lot_no = $_POST['lot_no'];
        $purchase_order_array = $this->purchase_library->get_purchase_order_info(0, $lot_no)->result_array();
        if(!empty($purchase_order_array))
        {
            $purchase_order_info = $purchase_order_array[0];
            $supplier_id = $purchase_order_info['supplier_id'];
            $supplier_info_array = $this->ion_auth->get_supplier()->result_array(0, $supplier_id);
            if(!empty($supplier_info_array))
            {
                $supplier_info = $supplier_info_array[0]; 
                $supplier_due = $this->payments->get_supplier_current_due($supplier_info['supplier_id']);   
            }
        }
        $result['supplier_info'] = $supplier_info;
        $result['supplier_due'] = $supplier_due;
        $product_list_array = $this->purchase_library->get_product_list_purchase_order($lot_no)->result_array();
        if(!empty($product_list_array))
        {
            $product_list = $product_list_array;
        }
        $result['product_list'] = $product_list;
        echo(json_encode($result));
    }
    /*
     * Ajax Call
     * This method will store purchase info into the system
     * @return status, 0 for error and 1 for success
     * @return message, if there is any error
     * @retrun purchase_info, purchase info
     * @return inserted_product_list, product list of that purchase
     * @author Nazmul on 23rd January 2014
     */
    function add_purchase()
    {
        $current_time = now();
        $user_id = $this->session->userdata('user_id');
        $shop_id = $this->session->userdata('shop_id');
        $selected_product_list = $_POST['product_list'];
        $purchased_product_list = array();
        $add_stock_list = array();
        $purchase_info = $_POST['purchase_info'];
        $current_due = $_POST['current_due'];
        
        $supplier_transaction_info_array = array();
        
        foreach($selected_product_list as $key => $prod_info)
        {
            $supplier_transaction_info = array(
                'shop_id' => $shop_id,
                'supplier_id' => $purchase_info['supplier_id'],
                'created_on' => $current_time,
                'lot_no' => $prod_info['purchase_order_no'],
                'name' => $prod_info['name'],
                'quantity' => $prod_info['quantity'],
                'unit_price' => $prod_info['unit_price'],
                'sub_total' => $prod_info['sub_total'],
                'payment_status' => ''
            );
            $supplier_transaction_info_array[] = $supplier_transaction_info;
            
            $product_info = array(
                'product_id' => $prod_info['product_id'],
                'quantity' => $prod_info['quantity'],
                'purchase_order_no' => $prod_info['purchase_order_no'],
                'shop_id' => $shop_id,
                'unit_price' => $prod_info['unit_price'],
                'created_on' => $current_time,
                'created_by' => $user_id,
                'sub_total' => $prod_info['sub_total']
            );
            $purchased_product_list[] = $product_info;
            $add_stock_info = array(
                'supplier_id' => $purchase_info['supplier_id'],
                'product_id' => $prod_info['product_id'],
                'purchase_order_no' => $prod_info['purchase_order_no'],
                'shop_id' => $shop_id,
                'stock_amount' => $prod_info['quantity'],
                'created_on' => $current_time
            );
            $add_stock_list[] = $add_stock_info;
        }
        $supplier_transaction_info = array(
            'shop_id' => $shop_id,
            'supplier_id' => $purchase_info['supplier_id'],
            'created_on' => $current_time,
            'lot_no' => '',
            'name' => '',
            'quantity' => '',
            'unit_price' => '',
            'sub_total' => $current_due+$purchase_info['paid'],
            'payment_status' => 'Total due'
        );
        $supplier_transaction_info_array[] = $supplier_transaction_info;
        if( $purchase_info['paid'] > 0)
        {
            $supplier_transaction_info = array(
                'shop_id' => $shop_id,
                'supplier_id' => $purchase_info['supplier_id'],
                'created_on' => $current_time,
                'lot_no' => '',
                'name' => '',
                'quantity' => '',
                'unit_price' => '',
                'sub_total' => $purchase_info['paid'],
                'payment_status' => 'Payment(Cash)'
            );
            $supplier_transaction_info_array[] = $supplier_transaction_info;
            if( $current_due > 0)
            {
                $supplier_transaction_info = array(
                    'shop_id' => $shop_id,
                    'supplier_id' => $purchase_info['supplier_id'],
                    'created_on' => $current_time,
                    'lot_no' => '',
                    'name' => '',
                    'quantity' => '',
                    'unit_price' => '',
                    'sub_total' => $current_due,
                    'payment_status' => 'Total due'
                );
                $supplier_transaction_info_array[] = $supplier_transaction_info;
            }
        }       
        
        $additional_data = array(
            'order_date' => $current_time,
            'purchase_order_no' => $purchase_info['order_no'],
            'shop_id' => $shop_id,
            'supplier_id' => $purchase_info['supplier_id'],
            'purchase_order_status_id' => 1,
            'remarks' => $purchase_info['remarks'],
            'total' => $purchase_info['total'],
            'paid' => $purchase_info['paid'],
            'created_on' => $current_time,
            'created_by' => $user_id
        ); 
        $supplier_payment_data = array(
            'shop_id' => $shop_id,
            'supplier_id' => $purchase_info['supplier_id'],
            'amount' => $purchase_info['paid'],
            'description' => 'purchase',
            'payment_category_id' => PAYMENT_PURCHASE_PAYMENT,
            'reference_id' => $prod_info['purchase_order_no'],
            'created_on' => $current_time
        );
        $purchase_id = $this->purchase_library->add_purchase_order($additional_data, $purchased_product_list, $add_stock_list, $supplier_payment_data, $supplier_transaction_info_array);
        if( $purchase_id !== FALSE )
        {
            $purchase_info_array = $this->purchase_library->get_purchase_order_info($purchase_id)->result_array();
            $purchase_info = array();
            if( count($purchase_info_array) > 0 )
            {
                $purchase_info = $purchase_info_array[0];
            }
            $response['status'] = '1';
            $response['purchase_info'] = $purchase_info;
            $response['inserted_product_list'] = $purchased_product_list;
        } 
        else
        {
            $response['status'] = '0';
            $response['message'] = $this->purchase_library->errors_alert();
        }
        
        echo json_encode($response);
    } 
    
    /*
     * Ajax Call
     */
    function raise_purchase()
    {
        $current_time = now();
        $user_id = $this->session->userdata('user_id');
        $shop_id = $this->session->userdata('shop_id');
        $current_due = $_POST['current_due'];
        $selected_product_list = $_POST['product_list'];
        $purchase_info = $_POST['purchase_info']; 
        $order_no = $purchase_info['order_no'];
        
        //existing purchase order info
        $existing_purchase_order_info = array();
        $existing_purchase_order_array = $this->purchase_library->get_purchase_order_info(0, $order_no)->result_array();
        if(!empty($existing_purchase_order_array))
        {
            $existing_purchase_order_info = $existing_purchase_order_array[0];
        }
        //product list of existing purchase order
        $product_id_product_info_map = array();
        $existing_product_id_list = array();
        $existing_product_list_array = $this->purchase_library->get_product_list_purchase_order($order_no)->result_array();
        foreach($existing_product_list_array as $product_info)
        {
            if(!in_array($product_info['product_id'], $existing_product_id_list))
            {
                $existing_product_id_list[] = $product_info['product_id'];
            }
            $product_id_product_info_map[$product_info['product_id']] = $product_info;
        }
        //existing stock list
        $product_quantity_map = array();        
        $stock_list_array = $this->stock_library->get_all_stocks($shop_id, 0 , $order_no)->result_array();
        foreach($stock_list_array as $key => $stock_info)
        {
            $product_quantity_map[$stock_info['product_id'].'_'.$stock_info['purchase_order_no']] = $stock_info['stock_amount'];
        }
        
        $supplier_transaction_info_array = array();
        
        $new_purchased_product_list = array();
        $existing_purchased_product_list = array();
        $add_stock_list = array();
        $update_stock_list = array();
        
        foreach($selected_product_list as $key => $prod_info)
        {
            $supplier_transaction_info = array(
                'shop_id' => $shop_id,
                'supplier_id' => $purchase_info['supplier_id'],
                'created_on' => $current_time,
                'lot_no' => $order_no,
                'name' => $prod_info['name'],
                'quantity' => $prod_info['quantity'],
                'unit_price' => $prod_info['unit_price'],
                'sub_total' => $prod_info['sub_total'],
                'payment_status' => ''
            );
            $supplier_transaction_info_array[] = $supplier_transaction_info;
            if(in_array($prod_info['product_id'], $existing_product_id_list))
            {
                $purchased_product_info = array(
                    'product_id' => $prod_info['product_id'],
                    'purchase_order_no' => $order_no,
                    'shop_id' => $shop_id,
                    'quantity' => ( $product_id_product_info_map[$prod_info['product_id']]['quantity'] + $prod_info['quantity'] ),
                    'sub_total' => ( $product_id_product_info_map[$prod_info['product_id']]['sub_total'] + $prod_info['sub_total'] ),
                    'modified_on' => $current_time,
                    'modified_by' => $user_id
                );
                $existing_purchased_product_list[] = $purchased_product_info;
                $update_stock_info = array(
                    'product_id' => $prod_info['product_id'],
                    'purchase_order_no' => $order_no,
                    'shop_id' => $shop_id,
                    'stock_amount' => ( $product_quantity_map[$prod_info['product_id'].'_'.$order_no] + $prod_info['quantity'] )
                );
                $update_stock_list[] = $update_stock_info;
            }
            else
            {
                $product_info = array(
                    'product_id' => $prod_info['product_id'],
                    'quantity' => $prod_info['quantity'],
                    'purchase_order_no' => $order_no,
                    'shop_id' => $shop_id,
                    'unit_price' => $prod_info['unit_price'],
                    'created_on' => $current_time,
                    'created_by' => $user_id,
                    'sub_total' => $prod_info['sub_total']
                );
                $new_purchased_product_list[] = $product_info;
                $add_stock_info = array(
                    'supplier_id' => $purchase_info['supplier_id'],
                    'product_id' => $prod_info['product_id'],
                    'purchase_order_no' => $prod_info['purchase_order_no'],
                    'shop_id' => $shop_id,
                    'stock_amount' => $prod_info['quantity'],
                    'created_on' => $current_time
                );
                $add_stock_list[] = $add_stock_info;
            }            
        }
        $supplier_transaction_info = array(
            'shop_id' => $shop_id,
            'supplier_id' => $purchase_info['supplier_id'],
            'created_on' => $current_time,
            'lot_no' => '',
            'name' => '',
            'quantity' => '',
            'unit_price' => '',
            'sub_total' => $current_due,
            'payment_status' => 'Total due'
        );
        $supplier_transaction_info_array[] = $supplier_transaction_info;
        $additional_data = array(
            'purchase_order_no' => $order_no,
            'shop_id' => $shop_id,
            'remarks' => $purchase_info['remarks'],
            'total' => ($existing_purchase_order_info['total']+$purchase_info['total']),
            'modified_on' => $current_time,
            'modified_by' => $user_id
        ); 
        /*$response['selected_product_list'] = $selected_product_list;
        $response['purchase_info'] = $purchase_info;
        $response['existing_purchase_order_info'] = $existing_purchase_order_info;
        $response['existing_product_id_list'] = $existing_product_id_list;
        $response['supplier_transaction_info_array'] = $supplier_transaction_info_array;
        $response['existing_purchased_product_list'] = $existing_purchased_product_list;
        $response['update_stock_list'] = $update_stock_list;
        $response['new_purchased_product_list'] = $new_purchased_product_list;
        $response['add_stock_list'] = $add_stock_list;
        $response['additional_data'] = $additional_data;*/
        
        $status = $this->purchase_library->raise_purchase_order($additional_data, $new_purchased_product_list, $existing_purchased_product_list, $add_stock_list, $update_stock_list, $supplier_transaction_info_array);
        if( $status === TRUE )
        {
            $purchase_info_array = $this->purchase_library->get_purchase_order_info(0, $order_no)->result_array();
            $purchase_info = array();
            if( count($purchase_info_array) > 0 )
            {
                $purchase_info = $purchase_info_array[0];
            }
            $response['status'] = '1';
        } 
        else
        {
            $response['status'] = '0';
            $response['message'] = $this->purchase_library->errors_alert();
        }        
        echo json_encode($response);
    }
    
}
