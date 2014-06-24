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
        $this->load->library('org/shop/shop_library');
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
        
        if(!$this->ion_auth->logged_in())
        {
            redirect("user/login","refresh");
        }
    }

    function index() {
        
    }

    function sale_order() {
        $shop_info = array();
        $shop_info_array = $this->shop_library->get_shop()->result_array();
        if(!empty($shop_info_array))
        {
            $shop_info = $shop_info_array[0];
        }
        $this->data['shop_info'] = $shop_info;
        
        $salesman_list = array();
        $salesman_list_array = $this->ion_auth->get_all_salesman()->result_array();
        if (!empty($salesman_list_array)) {
            foreach ($salesman_list_array as $key => $salesman_info) {
                $salesman_list[$salesman_info['user_id']] = $salesman_info['first_name'] . ' ' . $salesman_info['last_name'];
            }
        }
        $this->data['salesman_list'] = $salesman_list;
        $this->data['user_info'] = array();
        $user_info_array = $this->ion_auth->user()->result_array();
        if (!empty($user_info_array)) {
            $this->data['user_info'] = $user_info_array[0];
        }

        $this->data['product_list_array'] = array();
        $product_list_array = $this->product_library->get_all_products()->result_array();
        if (count($product_list_array) > 0) {
            $this->data['product_list_array'] = $product_list_array;
        }
        $this->data['customer_search_category'] = array();
        $this->data['customer_search_category'][0] = "Select an item";
        $this->data['customer_search_category']['phone'] = "Phone";
        if($shop_info['shop_type_id'] == SHOP_TYPE_SMALL){$this->data['customer_search_category']['card_no'] = "Card No";}
        $this->data['customer_search_category']['first_name'] = "First Name";
        $this->data['customer_search_category']['last_name'] = "Last Name";

        $this->data['product_search_category'] = array();
        $this->data['product_search_category'][0] = "Select an item";
        $this->data['product_search_category']['name'] = "Product Name";
        
        $product_unit_category_list_array = $this->product_library->get_all_product_unit_category()->result_array();
        $this->data['product_unit_category_list'] = array();
        if( !empty($product_unit_category_list_array) )
        {
            foreach ($product_unit_category_list_array as $key => $unit_category) {
                $this->data['product_unit_category_list'][$unit_category['id']] = $unit_category['description'];
            }
        }
        if($shop_info['shop_type_id'] == SHOP_TYPE_SMALL) {$this->template->load(null, 'sales/sales_order', $this->data);}
        if($shop_info['shop_type_id'] == SHOP_TYPE_MEDIUM) {$this->template->load(null, 'sales/sales_order_med', $this->data);}
    }
    
    function add_sale() {
        $current_time = now();
        $shop_id = $this->session->userdata('shop_id');
        $selected_product_list = $_POST['product_list'];
        $sale_product_list = array();
        $stock_out_list = array();
        $sale_info = $_POST['sale_info'];
        $current_due = $_POST['current_due'];

        $product_quantity_map = array();
        $stock_list_array = $this->stock_library->search_stocks()->result_array();
        foreach ($stock_list_array as $key => $stock_info) {
            $product_quantity_map[$stock_info['product_id'] . '_' . $stock_info['purchase_order_no']] = $stock_info['current_stock'];
        }
        $customer_transaction_info_array = array();
        $total_products = count($selected_product_list);
        $product_counter=0;
        foreach ($selected_product_list as $key => $prod_info) {
            $product_counter++;
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
                'profit' => '',
                'remarks' => $sale_info['remarks']
            );
            if($product_counter == $total_products)
            {
                $customer_transaction_info['remarks'] = $sale_info['remarks'];
            }
            else
            {
                $customer_transaction_info['remarks'] = '';
            }
            $customer_transaction_info_array[] = $customer_transaction_info;            
            $product_info = array(
                'product_id' => $prod_info['product_id'],
                'purchase_order_no' => $prod_info['purchase_order_no'],
                'sale_order_no' => $sale_info['sale_order_no'],
                'shop_id' => $shop_id,
                'unit_price' => $prod_info['unit_price'],
                'created_on' => $current_time,
                'created_by' => $sale_info['created_by']
            );
            $sale_product_list[] = $product_info;
            
            if (array_key_exists($product_info['product_id'] . '_' . $product_info['purchase_order_no'], $product_quantity_map) && ( $product_quantity_map[$product_info['product_id'] . '_' . $product_info['purchase_order_no']] >= $prod_info['quantity'] )) {
                $stock_out_info = array(
                    'product_id' => $prod_info['product_id'],
                    'purchase_order_no' => $prod_info['purchase_order_no'],
                    'sale_order_no' => $sale_info['sale_order_no'],
                    'shop_id' => $shop_id,
                    'stock_out' => $prod_info['quantity'],
                    'created_on' => $current_time,
                    'transaction_category_id' => STOCK_SALE_IN
                );
                $stock_out_list[] = $stock_out_info;
            } else {
                $response['status'] = '0';
                $response['message'] = 'Insufficient stock for the product : ' . $prod_info['name'] . ' and lot no : ' . $prod_info['purchase_order_no'];
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
            'sub_total' => ($current_due + $sale_info['cash_paid'] + $sale_info['check_paid']),
            'payment_status' => 'Total due',
            'profit' => '',
            'remarks' => ''
        );
        $customer_transaction_info_array[] = $customer_transaction_info;
        if ($sale_info['cash_paid'] + $sale_info['check_paid'] > 0) {
            if ($sale_info['cash_paid'] > 0) {
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
                    'profit' => '',
                    'remarks' => ''
                );
                $customer_transaction_info_array[] = $customer_transaction_info;
            }
            if ($sale_info['check_paid'] > 0) {
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
                    'profit' => '',
                    'remarks' => ''
                );
                $customer_transaction_info_array[] = $customer_transaction_info;
            }
            if ($current_due > 0) {
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
                    'profit' => '',
                    'remarks' => ''
                );
                $customer_transaction_info_array[] = $customer_transaction_info;
            }
        }
        $customer_payment_data_array = array();
        if ($sale_info['cash_paid'] > 0) {
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
        if ($sale_info['check_paid'] > 0) {
            $customer_payment_data = array(
                'sale_order_no' => $sale_info['sale_order_no'],
                'payment_type_id' => $this->payment_type_list['cash_id'],
                'payment_category_id' => $this->payment_category_list['sale_payment_id'],
                'shop_id' => $shop_id,
                'customer_id' => $sale_info['customer_id'],
                'amount' => $sale_info['check_paid'],
                'description' => 'sale check:' . $sale_info['check_description'],
                'reference_id' => $sale_info['sale_order_no'],
                'created_on' => $current_time
            );
            $customer_payment_data_array[] = $customer_payment_data;
        }
        $additional_data = array(
            'sale_date' => $current_time,
            'created_on' => $current_time,
            'total' => $sale_info['total'],
            'paid' => $sale_info['cash_paid'] + $sale_info['check_paid'],
            'sale_order_no' => $sale_info['sale_order_no'],
            'shop_id' => $shop_id,
            'customer_id' => $sale_info['customer_id'],
            'sale_order_status_id' => 1,
            'remarks' => $sale_info['remarks'],
            'created_by' => $sale_info['created_by']
        );
        $sale_id = $this->sale_library->add_sale_order($additional_data, $sale_product_list, $stock_out_list, $customer_payment_data_array, $customer_transaction_info_array);
        if ($sale_id !== FALSE) {
            $response['status'] = '1';
        } else {
            $response['status'] = '0';
            $response['message'] = $this->ion_auth->errors_alert();
        }
        echo json_encode($response);
    }
    
    public function get_sale_info_from_sale_order_no() {
        $result = array();
        $customer_info = array();
        $sale_product_list = array();
        $customer_due = 0;
        $sale_order_no = $_POST['sale_order_no'];
        $sale_info_array = $this->sale_library->get_sale_info($sale_order_no)->result_array();
        if(!empty($sale_info_array))
        {
            $sale_info = $sale_info_array[0];
            $customer_id = $sale_info['customer_id'];
            $customer_info_array = $this->ion_auth->get_customer(0, $customer_id)->result_array();
            if(!empty($customer_info_array))
            {
                $customer_info = $customer_info_array[0]; 
                $customer_due = $this->payments->get_customer_current_due($customer_info['customer_id']);   
            }
        }        
        $sale_product_list_array = $this->sale_library->get_sale_product_list($sale_order_no)->result_array();
       // echo '<pre/>';print_r($sale_product_list_array);exit;
        if(!empty($sale_product_list_array))
        {
            $sale_product_list = $sale_product_list_array;            
        }
        $result['customer_info'] = $customer_info;
        $result['customer_due'] = $customer_due;  
        $result['sale_product_list'] = $sale_product_list;        
        echo(json_encode($result));
    }

    public function return_sale_order($sale_order_no = '') {
        
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
            //$this->session->set_flashdata('message',"You have no permission to view that page");
            
            if($user_group['id'] == USER_GROUP_SALESMAN)
            {
                redirect('user/salesman_login',"refresh");
            }
        }
        
        
        
        $shop_info = array();
        $shop_info_array = $this->shop_library->get_shop()->result_array();
        if(!empty($shop_info_array))
        {
            $shop_info = $shop_info_array[0];
        }
        $this->data['shop_info'] = $shop_info;
        $salesman_list = array();
        $salesman_list_array = $this->ion_auth->get_all_salesman()->result_array();
        if (!empty($salesman_list_array)) {
            foreach ($salesman_list_array as $key => $salesman_info) {
                $salesman_list[$salesman_info['user_id']] = $salesman_info['first_name'] . ' ' . $salesman_info['last_name'];
            }
        }
        $this->data['salesman_list'] = $salesman_list;
        $this->data['user_info'] = array();
        $user_info_array = $this->ion_auth->user()->result_array();
        if (!empty($user_info_array)) {
            $this->data['user_info'] = $user_info_array[0];
        }
        $this->data['product_list_array'] = array();
        $product_list_array = $this->product_library->get_all_products()->result_array();
        if (count($product_list_array) > 0) {
            $this->data['product_list_array'] = $product_list_array;
        }
        $this->data['sale_order_no'] = $sale_order_no;
        if($shop_info['shop_type_id'] == SHOP_TYPE_SMALL){$this->template->load(null, 'sales/return_sale_order', $this->data);}
        if($shop_info['shop_type_id'] == SHOP_TYPE_MEDIUM){$this->template->load(null, 'sales/return_sale_order_med', $this->data);}
    }
    /*
     * Ajax Call
     */
    function update_return_sale_order() {
        $current_time = now();
        $shop_id = $this->session->userdata('shop_id');
        $current_due = $_POST['current_due'];
        $return_balance = $_POST['return_balance'];
        $selected_product_list = $_POST['product_list'];
        $sale_info = $_POST['sale_info'];
        $sale_order_no = $sale_info['sale_order_no'];
        $user_id = $sale_info['created_by'];
        $response = array();

        //existing sale list
        $product_id_quantity_map = array();
        $sale_list_array = $this->sale_library->get_sale_current_product_quantity_list($sale_order_no)->result_array();
        foreach ($sale_list_array as $key => $product_info) {
            $product_id_quantity_map[$product_info['purchase_order_no'].'_'.$product_info['product_id']] = $product_info['sale_quantity'];
        }

        $customer_transaction_info_array = array();
        $add_stock_list = array();
        foreach ($selected_product_list as $key => $prod_info) 
        {
            $customer_transaction_info = array(
                'sale_order_no' => $sale_order_no,
                'shop_id' => $shop_id,
                'customer_id' => $sale_info['customer_id'],
                'created_on' => $current_time,
                'lot_no' => $prod_info['purchase_order_no'],
                'name' => $prod_info['name'],
                'quantity' => '-' . $prod_info['quantity'],
                'unit_price' => $prod_info['unit_price'],
                'sub_total' => '-' . $prod_info['sub_total'],
                'payment_status' => 'Return product',
                'profit' => ''
            );
            $customer_transaction_info_array[] = $customer_transaction_info;
            if ($product_id_quantity_map[$prod_info['purchase_order_no'].'_'.$prod_info['product_id']] >= $prod_info['quantity']) {
                $add_stock_info = array(
                    'product_id' => $prod_info['product_id'],
                    'purchase_order_no' => $prod_info['purchase_order_no'],
                    'sale_order_no' => $sale_order_no,
                    'shop_id' => $shop_id,
                    'stock_in' => $prod_info['quantity'],
                    'created_on' => $current_time,
                    'transaction_category_id' => STOCK_SALE_PARTIAL_OUT
                );
                $add_stock_list[] = $add_stock_info;
            } 
            else {
                $response['status'] = '0';
                $response['message'] = 'Returned quantity: '.$prod_info['quantity'].' exceeds sale quantity for the product: ' . $prod_info['name'] . ' and lot no: ' . $prod_info['purchase_order_no'].'. Original sale quantity was: '.$product_id_quantity_map[$prod_info['purchase_order_no'].'_'.$prod_info['product_id']];
                echo json_encode($response);
                return;
            }
        }
        $customer_transaction_info = array(
            'sale_order_no' => $sale_order_no,
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
        $additional_data = array(
            'sale_order_no' => $sale_order_no,
            'shop_id' => $shop_id,
            'remarks' => $sale_info['remarks'],
            'modified_on' => $current_time,
            'modified_by' => $user_id
        );
        $return_balance_info = array();
        if($return_balance > 0)
        {
            $return_balance_info = array(
                'shop_id' => $shop_id,
                'sale_order_no' => $sale_order_no,
                'customer_id' => $sale_info['customer_id'],
                'amount' => $return_balance,
                'created_on' => $current_time,
                'created_by' => $user_id
            );
            $customer_transaction_info = array(
                'sale_order_no' => $sale_order_no,
                'shop_id' => $shop_id,
                'customer_id' => $sale_info['customer_id'],
                'created_on' => $current_time,
                'lot_no' => '',
                'name' => '',
                'quantity' => '',
                'unit_price' => '',
                'sub_total' => $return_balance,
                'payment_status' => 'Return balance',
                'profit' => ''
            );
            $customer_transaction_info_array[] = $customer_transaction_info;
        }
        $status = $this->sale_library->return_sale_order($additional_data, $add_stock_list, $customer_transaction_info_array, $return_balance_info);
        if( $status === TRUE )
        {
            $response['status'] = '1';
        } 
        else
        {
            $response['status'] = '0';
            $response['message'] = $this->sale_library->errors_alert();
        }
        echo json_encode($response);
    }
    
    public function delete_sale($sale_order_id = '') {
        
        $this->data['message'] = '';
        if ($this->input->post('submit_delete_sale')) 
        {
            $sale_order_no = $this->input->post('sale_order_no');
            $response = $this->delete_sale_order($sale_order_no);
            if($response['status'] == '1')
            {
                $this->session->set_flashdata('message', 'Sale is deleted successfully');
            }
            else
            {
                $this->session->set_flashdata('message', $response['message']);
            }
            redirect('sale/delete_sale', 'refresh');
        } 
        else 
        {
            $this->data['message'] = $this->session->flashdata('message');
        }
        $this->data['sale_order_no'] = array(
            'name' => 'sale_order_no',
            'id' => 'sale_order_no',
            'type' => 'text',
            'value' => $sale_order_id
        );
        $this->data['submit_delete_sale'] = array(
            'name' => 'submit_delete_sale',
            'id' => 'submit_delete_sale',
            'type' => 'submit',
            'value' => 'Delete',
        );
        $this->template->load(null, 'sales/delete_sale', $this->data);
    }
    
    function delete_sale_order($sale_order_no) {
        $current_time = now();
        $shop_id = $this->session->userdata('shop_id');
        $user_id = $this->session->userdata('user_id');
        $response = array();

        $customer_transaction_info_array = array();
        $add_stock_list = array();
        $customer_id = 0;
        
        //existing sale list
        $existing_sale_product_price = 0;
        //$product_id_quantity_map = array();
        $sale_list_array = $this->sale_library->get_sale_detail($sale_order_no)->result_array();
        foreach ($sale_list_array as $key => $prod_info) {
            $customer_id = $prod_info['customer_id'];
            //$product_id_quantity_map[$prod_info['product_id']] = $prod_info['total_sale'];
            $existing_sale_product_price = $existing_sale_product_price + ($prod_info['total_sale']*$prod_info['unit_price']);
            
            $sub_total = ($prod_info['total_sale']*$prod_info['unit_price']);
            $customer_transaction_info = array(
                'sale_order_no' => $sale_order_no,
                'shop_id' => $shop_id,
                'customer_id' => $prod_info['customer_id'],
                'created_on' => $current_time,
                'lot_no' => $prod_info['purchase_order_no'],
                'name' => $prod_info['product_name'],
                'quantity' => '-' . $prod_info['total_sale'],
                'unit_price' => $prod_info['unit_price'],
                'sub_total' => '-' . $sub_total,
                'payment_status' => 'Sale Deleted',
                'profit' => ''
            );
            $customer_transaction_info_array[] = $customer_transaction_info;
            $add_stock_info = array(
                'product_id' => $prod_info['product_id'],
                'purchase_order_no' => $prod_info['purchase_order_no'],
                'sale_order_no' => $sale_order_no,
                'shop_id' => $shop_id,
                'stock_in' => $prod_info['total_sale'],
                'created_on' => $current_time,
                'transaction_category_id' => STOCK_SALE_DELETE
            );
            $add_stock_list[] = $add_stock_info;
        }
        if( $existing_sale_product_price == 0)
        {
            $response['status'] = '0';
            $response['message'] = 'Invalid Sale to be deleted.';
            return $response;
        }
        $current_due = $this->payments->get_customer_current_due($customer_id);
        $return_balance = 0;
        if( $current_due - $existing_sale_product_price < 0 )
        {            
            $return_balance = $existing_sale_product_price - $current_due;
            $current_due = 0;
        }
        $customer_transaction_info = array(
            'sale_order_no' => $sale_order_no,
            'shop_id' => $shop_id,
            'customer_id' => $customer_id,
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
        $additional_data = array(
            'sale_order_no' => $sale_order_no,
            'shop_id' => $shop_id,
            'modified_on' => $current_time,
            'modified_by' => $user_id
        );
        $return_balance_info = array();
        if($return_balance > 0)
        {
            $return_balance_info = array(
                'shop_id' => $shop_id,
                'sale_order_no' => $sale_order_no,
                'customer_id' => $customer_id,
                'amount' => $return_balance,
                'created_on' => $current_time,
                'created_by' => $user_id
            );
            $customer_transaction_info = array(
                'sale_order_no' => $sale_order_no,
                'shop_id' => $shop_id,
                'customer_id' => $customer_id,
                'created_on' => $current_time,
                'lot_no' => '',
                'name' => '',
                'quantity' => '',
                'unit_price' => '',
                'sub_total' => $return_balance,
                'payment_status' => 'Return balance',
                'profit' => ''
            );
            $customer_transaction_info_array[] = $customer_transaction_info;
        }
        $status = $this->sale_library->return_sale_order($additional_data, $add_stock_list, $customer_transaction_info_array, $return_balance_info);
        if( $status === TRUE )
        {
            $response['status'] = '1';
        } 
        else
        {
            $response['status'] = '0';
            $response['message'] = $this->sale_library->errors_alert();
        }
        return $response;
    }
}
