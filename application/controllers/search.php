<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {
    /*
     * Holds account status list
     * 
     * $var array
     */

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
        $this->load->library('org/common/expenses');
        $this->load->library('org/common/payments');
        $this->load->library('org/common/utils');
        $this->load->library('org/product/product_library');
        $this->load->library('org/search/search_customer');
        $this->load->library('org/sale/sale_library');
        $this->load->library('org/common/search_typeahead');
        
        if(!$this->ion_auth->logged_in())
        {
            redirect("user/login","refresh");
        }
    }
    
    function index()
    {
        
    }
    /*
     * This method will return customer list based on search parameter
     * @param search_category_name, column name of customer or user table
     * @param search_category_value, value of coumn of customer or user table
     * @return customer list
     */
    function search_customer_sale_order()
    {
        $result_array = array();
        $search_category_name = $_POST['search_category_name'];
        $search_category_value = $_POST['search_category_value'];
        $customer_list_array = $this->ion_auth->limit(PAGINATION_SEARCH_CUSTOMER_SALE_ORDER_LIMIT)->search_customer($search_category_name, $search_category_value)->result_array();
        if( count($customer_list_array) > 0)
        {
            $result_array = $customer_list_array;
        }
        echo json_encode($result_array);
    }
    /*
     * This method will return supplier list based on search parameter
     * @param search_category_name, column name of supplier or user table
     * @param search_category_value, value of coumn of supplier or user table
     * @return supplier list
     */
    function search_supplier_purchase_order()
    {
        $result_array = array();
        $search_category_name = $_POST['search_category_name'];
        $search_category_value = $_POST['search_category_value'];
        $supplier_list_array = $this->ion_auth->limit(PAGINATION_SEARCH_SUPPLIER_PURCHASE_ORDER_LIMIT)->search_supplier($search_category_name, $search_category_value)->result_array();
        if( count($supplier_list_array) > 0)
        {
            $result_array = $supplier_list_array;
        }
        echo json_encode($result_array);
    }
    /*
     * This method will return product list based on search parameter either from sale or purchase page
     * @param search_category_name, column name of product table
     * @param search_category_value, value of coumn of product table
     * @return product list
     */
    function search_product_order()
    {
        $result_array = array();
        $search_category_name = $_POST['search_category_name'];
        $search_category_value = $_POST['search_category_value'];
        $product_list_array = $this->product_library->search_product($search_category_name, $search_category_value)->result_array();
        if( count($product_list_array) > 0)
        {
            $result_array = $product_list_array;
        }
        echo json_encode($result_array);
    }
    
    //---------------------------------------- Sale Search ----------------------------------------------
    /*
     * Daily Sale
     */
    public function daily_sales()
    {
        $shop_info = array();
        $shop_info_array = $this->shop_library->get_shop()->result_array();
        if(!empty($shop_info_array))
        {
            $shop_info = $shop_info_array[0];
        }
        $this->data = $this->process_daily_sale();
        $this->data['shop_info'] = $shop_info;
        if($shop_info['shop_type_id'] == SHOP_TYPE_SMALL){$this->template->load(null, 'search/sale/daily_sales', $this->data);}
        if($shop_info['shop_type_id'] == SHOP_TYPE_MEDIUM){$this->template->load(null, 'search/sale/daily_sales_med', $this->data);}
    }
    /*
     * Ajax call
     */
    public function get_daily_sales()
    {
        $product_id = $_POST['product_id'];
        $result = $this->process_daily_sale($product_id);
        //print_r($result);
        //echo '<pre/>';print_r($result);exit('hi');
        echo json_encode($result);
    }
    
    /*public function process_daily_sale($product_id = 0)
    {
        //$today = date('Y-m-d');
        $time = $this->utils->get_current_date_start_time();
        $result = array();
        $shop_id = $this->session->userdata('shop_id');
        $product_list = array();
        $product_list_array = $this->product_library->get_all_products($shop_id)->result_array();
        if( !empty($product_list_array) )
        {
            foreach($product_list_array as $product_info)
            {
                $product_list[$product_info['id']] = $product_info['name'];
            }
        }
        $result['product_list'] = $product_list;
        
        $total_product_sold = 0;
        $total_profit = 0;
        $total_sale_price = 0;
        
        $sale_list = array();
        $sale_list_array = $this->sale_library->get_daily_sales($time, $shop_id, $product_id)->result_array();
        if( !empty($sale_list_array) )
        {
            foreach($sale_list_array as $sale_info)
            {
                $sale_info['created_on'] = $this->utils->process_time($sale_info['created_on']);
                $total_product_sold = $total_product_sold + $sale_info['quantity'];
                $total_profit = $total_profit + $sale_info['total_sale_price'] - ($sale_info['quantity']*$sale_info['purchase_unit_price']);
                $total_sale_price = $total_sale_price + $sale_info['total_sale_price'];
                $sale_list[] = $sale_info;
            }
        }
        $result['sale_list'] = $sale_list;
        $result['total_product_sold'] = $total_product_sold;
        if($this->session->userdata('user_type') != SALESMAN)
        {                                    
            $result['total_profit'] = $total_profit;
        }        
        $result['total_sale_price'] = $total_sale_price;
        
        //expense of today
        $total_expense = 0;
        $expense_list_array = $this->expenses->get_all_expenses_today($time)->result_array();
        foreach($expense_list_array as $expense_info)
        {
            $total_expense = $total_expense + $expense_info['expense_amount'];
        }
        $result['total_expense'] = $total_expense;
        //total due
        $total_due = 0;
        $sale_order_array = $this->sale_library->get_sale_orders_today($time)->result_array();
        foreach($sale_order_array as $sale_info)
        {
            if( ($sale_info['total'] - $sale_info['paid']) > 0)
            {
                $total_due = $total_due + ($sale_info['total'] - $sale_info['paid']);
            }
        }
        $result['total_due'] = $total_due;
        
        //total due collect
        $total_due_collect = 0;
        $payment_list_array = $this->payments->get_customer_due_collect_today($time)->result_array();
        if(!empty($payment_list_array))
        {
            $total_due_collect = $payment_list_array[0]['total_due_collect'];
        }        
        $result['total_due_collect'] = $total_due_collect;
        
        //customers total payments and total payments of today
        $customers_total_payment = 0;
        $customers_total_payment_array = $this->payments->get_customers_total_payment()->result_array();
        if(!empty($customers_total_payment_array))
        {
            $customers_total_payment = $customers_total_payment_array[0]['total_payment'];
        }
        $customers_total_payment_today = 0;
        $customers_total_payment_today_array = $this->payments->get_customers_total_payment_today($time)->result_array();
        if(!empty($customers_total_payment_today_array))
        {
            $customers_total_payment_today = $customers_total_payment_today_array[0]['total_payment'];
        }
        //shop total expenses and total expenses of today
        $shop_total_expenses = 0;
        $shop_total_expenses_array = $this->expenses->get_shop_total_expenses()->result_array();
        if(!empty($shop_total_expenses_array))
        {
            $shop_total_expenses = $shop_total_expenses_array[0]['total_expense'];
        }
        $shop_total_expenses_today = 0;
        $shop_total_expenses_today_array = $this->expenses->get_shop_total_expenses_today($time)->result_array();
        if(!empty($shop_total_expenses_today_array))
        {
            $shop_total_expenses_today = $shop_total_expenses_today_array[0]['total_expense'];
        }
        //suppliers total returned payment and returned payment of today
        $suppliers_total_returned_payment = 0;
        $suppliers_total_returned_payment_array = $this->payments->get_suppliers_total_returned_payment()->result_array();
        if(!empty($suppliers_total_returned_payment_array))
        {
            $suppliers_total_returned_payment = $suppliers_total_returned_payment_array[0]['total_returned_payment'];
        }
        $suppliers_total_returned_payment_today = 0;
        $suppliers_total_returned_payment_today_array = $this->payments->get_suppliers_total_returned_payment_today($time)->result_array();
        if(!empty($suppliers_total_returned_payment_today_array))
        {
            $suppliers_total_returned_payment_today = $suppliers_total_returned_payment_today_array[0]['total_returned_payment'];
        }
        //customers total returned payment and returned payment of today
        $customers_total_returned_payment = 0;
        $customers_total_returned_payment_array = $this->payments->get_customers_total_returned_payment()->result_array();
        if(!empty($customers_total_returned_payment_array))
        {
            $customers_total_returned_payment = $customers_total_returned_payment_array[0]['total_returned_payment'];
        }
        $customers_total_returned_payment_today = 0;
        $customers_total_returned_payment_today_array = $this->payments->get_customers_total_returned_payment_today($time)->result_array();
        if(!empty($customers_total_returned_payment_today_array))
        {
            $customers_total_returned_payment_today = $customers_total_returned_payment_today_array[0]['total_returned_payment'];
        }
        
        $result['suppliers_total_returned_payment_today'] = $suppliers_total_returned_payment_today;
        $result['customers_total_returned_payment_today'] = $customers_total_returned_payment_today;
        
        $current_balance = $customers_total_payment + $suppliers_total_returned_payment - $customers_total_returned_payment - $shop_total_expenses;
        $result['current_balance'] = $current_balance;
        
        $previous_balance = $current_balance - ($customers_total_payment_today + $suppliers_total_returned_payment_today - $customers_total_returned_payment_today - $shop_total_expenses_today);
        $result['previous_balance'] = $previous_balance;
        return $result;
    }*/
    public function process_daily_sale($product_id = 0)
    {
        
        $time = $this->utils->get_current_date_start_time();
        $result = array();
        $shop_id = $this->session->userdata('shop_id');
        $product_list = array();
        $product_list_array = $this->product_library->get_all_products($shop_id)->result_array();
        
        if($product_id!=0)
        {
            foreach($product_list_array as $row)
            {
                if($row['product_id']==$product_id)
                {
                    $result['category_name'] = $row['category_unit'];
                    break;
                }
            }
        }
        else
        {
            $result['category_name'] = '';
        }
        
        if( !empty($product_list_array) )
        {
            foreach($product_list_array as $product_info)
            {
                $product_list[$product_info['id']] = $product_info['name'];
            }
        }
        //echo '<pre/>';print_r($product_list);exit;
        $result['product_list'] = $product_list;
        
        
        
        $total_product_sold = 0;
        $total_profit = 0;
        $total_sale_price = 0;
        
        $sale_list = array();
        $sale_list_array = $this->sale_library->get_daily_sales($time, $product_id, $shop_id)->result_array();
        if( !empty($sale_list_array) )
        {
            foreach($sale_list_array as $sale_info)
            {
                if($sale_info['total_sale'] > 0)
                {
                    $sale_info['created_on'] = $this->utils->process_time($sale_info['created_on']);
                    $total_product_sold = $total_product_sold + $sale_info['total_sale'];
                    $total_profit = $total_profit + (($sale_info['sale_unit_price'] - $sale_info['purchase_unit_price'])*$sale_info['total_sale']);
                    $total_sale_price = $total_sale_price + ($sale_info['sale_unit_price']*$sale_info['total_sale']);
                    $sale_list[] = $sale_info;
                }                
            }
        }
        
        //echo '<pre/>';print_r($sale_list);exit;
        $result['sale_list'] = $sale_list;
        $result['total_product_sold'] = $total_product_sold;
        if($this->session->userdata('user_type') != SALESMAN)
        {                                    
            $result['total_profit'] = $total_profit;
        }        
        $result['total_sale_price'] = $total_sale_price;
        
        //expense of today
        $total_expense = 0;
        $expense_list_array = $this->expenses->get_all_expenses_today($time)->result_array();
        foreach($expense_list_array as $expense_info)
        {
            $total_expense = $total_expense + $expense_info['expense_amount'];
        }
        $result['total_expense'] = $total_expense;
        //total customer payment
        $total_customer_payment = 0;
        $customer_payment_list_array = $this->payments->get_customer_payment_today($time)->result_array();
        if(!empty($customer_payment_list_array))
        {
            $total_customer_payment = $customer_payment_list_array[0]['total_customer_payment'];
        } 
        $result['total_due'] = $total_sale_price - $total_customer_payment;
        
        //total due collect
        $total_due_collect = 0;
        $payment_list_array = $this->payments->get_customer_due_collect_today($time)->result_array();
        if(!empty($payment_list_array))
        {
            $total_due_collect = $payment_list_array[0]['total_due_collect'];
        }        
        $result['total_due_collect'] = $total_due_collect;
        
        //customers total payments and total payments of today
        $customers_total_payment = 0;
        $customers_total_payment_array = $this->payments->get_customers_total_payment()->result_array();
        if(!empty($customers_total_payment_array))
        {
            $customers_total_payment = $customers_total_payment_array[0]['total_payment'];
        }
        $customers_total_payment_today = 0;
        $customers_total_payment_today_array = $this->payments->get_customers_total_payment_today($time)->result_array();
        if(!empty($customers_total_payment_today_array))
        {
            $customers_total_payment_today = $customers_total_payment_today_array[0]['total_payment'];
        }
        //shop total expenses and total expenses of today
        $shop_total_expenses = 0;
        $shop_total_expenses_array = $this->expenses->get_shop_total_expenses()->result_array();
        if(!empty($shop_total_expenses_array))
        {
            $shop_total_expenses = $shop_total_expenses_array[0]['total_expense'];
        }
        $shop_total_expenses_today = 0;
        $shop_total_expenses_today_array = $this->expenses->get_shop_total_expenses_today($time)->result_array();
        if(!empty($shop_total_expenses_today_array))
        {
            $shop_total_expenses_today = $shop_total_expenses_today_array[0]['total_expense'];
        }
        //suppliers total returned payment and returned payment of today
        $suppliers_total_returned_payment = 0;
        $suppliers_total_returned_payment_array = $this->payments->get_suppliers_total_returned_payment()->result_array();
        if(!empty($suppliers_total_returned_payment_array))
        {
            $suppliers_total_returned_payment = $suppliers_total_returned_payment_array[0]['total_returned_payment'];
        }
        $suppliers_total_returned_payment_today = 0;
        $suppliers_total_returned_payment_today_array = $this->payments->get_suppliers_total_returned_payment_today($time)->result_array();
        if(!empty($suppliers_total_returned_payment_today_array))
        {
            $suppliers_total_returned_payment_today = $suppliers_total_returned_payment_today_array[0]['total_returned_payment'];
        }
        //customers total returned payment and returned payment of today
        $customers_total_returned_payment = 0;
        $customers_total_returned_payment_array = $this->payments->get_customers_total_returned_payment()->result_array();
        if(!empty($customers_total_returned_payment_array))
        {
            $customers_total_returned_payment = $customers_total_returned_payment_array[0]['total_returned_payment'];
        }
        $customers_total_returned_payment_today = 0;
        $customers_total_returned_payment_today_array = $this->payments->get_customers_total_returned_payment_today($time)->result_array();
        if(!empty($customers_total_returned_payment_today_array))
        {
            $customers_total_returned_payment_today = $customers_total_returned_payment_today_array[0]['total_returned_payment'];
        }
        
        $result['suppliers_total_returned_payment_today'] = $suppliers_total_returned_payment_today;
        $result['customers_total_returned_payment_today'] = $customers_total_returned_payment_today;
        
        $result['total_due'] = $result['total_due'] + $result['customers_total_returned_payment_today'];
        
        $current_balance = $customers_total_payment + $suppliers_total_returned_payment - $customers_total_returned_payment - $shop_total_expenses;
        $result['current_balance'] = $current_balance;
        
        $previous_balance = $current_balance - ($customers_total_payment_today + $suppliers_total_returned_payment_today - $customers_total_returned_payment_today - $shop_total_expenses_today);
        $result['previous_balance'] = $previous_balance;
        return $result;
    }
    
    public function all_sales()
    {
        $shop_id = $this->session->userdata('shop_id');
        $product_list = array();
        $product_list_array = $this->product_library->get_all_products($shop_id)->result_array();
        if( !empty($product_list_array) )
        {
            foreach($product_list_array as $key => $product_info)
            {
                $product_list[$product_info['id']] = $product_info['name'];
            }
        }
        $this->data['product_list'] = $product_list;
        
        $time = $this->utils->get_human_to_unix(date('Y-m-d'));
        $this->data['sale_list'] = array();
        $sale_list_array = $this->sale_library->get_all_sales($time, $shop_id)->result_array();
        if( !empty($sale_list_array) )
        {
            $this->data['sale_list'] = $sale_list_array;
        } 
        $this->template->load(null, 'search/sale/all_sales', $this->data);
    }
    
    /*
     * Ajax Call
     */
    public function search_by_sales()
    {
        $user_id = $_POST['user_id'];
        $product_id = $_POST['product_id'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $start_time = $this->utils->get_human_to_unix($start_date);
        $end_time = ($this->utils->get_human_to_unix($end_date) + 86400);
        
        $total_sale_price = 0;
        $total_quantity= 0;
        $total_profit= 0;
        
        $this->data['sale_list'] = array();
        
        $sale_list = array();
        $sale_list_array = $this->sale_library->get_user_sales($start_time, $end_time, $user_id, $product_id)->result_array();
        if( !empty($sale_list_array) )
        {
            foreach($sale_list_array as $sale_info)
            {
                $sale_info['created_on'] = $this->utils->process_time($sale_info['created_on']);                
                $total_sale_price = $total_sale_price + ($sale_info['sale_unit_price']*$sale_info['total_sale']);
                $total_quantity = $total_quantity + $sale_info['total_sale'];
                $total_profit = $total_profit + ($sale_info['sale_unit_price'] - $sale_info['purchase_unit_price'])*$sale_info['total_sale'];
                $sale_list[] = $sale_info;
            }
        }
        $result_array['sale_list'] = $sale_list;  
        $result_array['total_sale_price'] = $total_sale_price;  
        $result_array['total_quantity'] = $total_quantity;  
        $result_array['total_profit'] = $total_profit;  
        echo json_encode($result_array);
    }
    public function search_sales()
    {
        $employee_list = array();
        $employee_list_array = $this->ion_auth->get_all_salesman()->result_array();
        if(!empty($employee_list_array))
        {
            foreach($employee_list_array as $key => $employee_info)
            {
                $employee_list[$employee_info['user_id']] = $employee_info['first_name'].' '.$employee_info['last_name'];
            }
        }
        $this->data['employee_list'] = $employee_list;
        $this->data['user_info'] = array();
        $user_info_array = $this->ion_auth->user()->result_array();
        if(!empty($user_info_array))
        {
            $this->data['user_info'] = $user_info_array[0];
        }
        
        $product_list = array();
        $product_list_array = $this->product_library->get_all_products()->result_array();
        //echo '<pre/>';print_r($product_list_array);exit;
        if( !empty($product_list_array) )
        {
            foreach($product_list_array as $key => $product_info)
            {
                $product_list[$product_info['id']] = $product_info['name'];
            }
        }
        $this->data['product_list'] = $product_list;
        $date = date('Y-m-d');
        $this->data['start_date'] = array(
            'name' => 'start_date',
            'id' => 'start_date',
            'type' => 'text',
            'value' => $date
        );
        $this->data['end_date'] = array(
            'name' => 'end_date',
            'id' => 'end_date',
            'type' => 'text',
            'value' => $date
        );
        $this->data['button_search_sale'] = array(
            'name' => 'button_search_sale',
            'id' => 'button_search_sale',
            'type' => 'reset',
            'value' => 'Search',
        );
        $this->template->load(null, 'search/sale/search_sales', $this->data);
    }
    /*
     * Ajax Call
     */
    public function search_sales_by_purchase_order_no()
    {
        $purchase_order_no = $_POST['purchase_order_no'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $start_time = $this->utils->get_human_to_unix($start_date);
        $end_time = ($this->utils->get_human_to_unix($end_date) + 86400);
        
        $total_sale_price = 0;
        $total_quantity= 0;
        $total_profit= 0;
        
        $this->data['sale_list'] = array();
        
        $sale_list = array();
        $sale_list_array = $this->sale_library->get_user_sales_by_purchase_order_no($start_time, $end_time, $purchase_order_no)->result_array();
        if( !empty($sale_list_array) )
        {
            foreach($sale_list_array as $sale_info)
            {
                $sale_info['created_on'] = $this->utils->process_time($sale_info['created_on']);                
                $total_sale_price = $total_sale_price + ($sale_info['sale_unit_price']*$sale_info['total_sale']);
                $total_quantity = $total_quantity + $sale_info['total_sale'];
                $total_profit = $total_profit + ($sale_info['sale_unit_price'] - $sale_info['purchase_unit_price'])*$sale_info['total_sale'];
                $sale_list[] = $sale_info;
            }
        }
        $result_array['sale_list'] = $sale_list;  
        $result_array['total_sale_price'] = $total_sale_price;  
        $result_array['total_quantity'] = $total_quantity;  
        $result_array['total_profit'] = $total_profit;  
        echo json_encode($result_array);
    }
    public function search_sales_purchase_order_no()
    {
        $this->data['purchase_order_no'] = array(
            'name' => 'purchase_order_no',
            'id' => 'purchase_order_no',
            'type' => 'text'
        );
        $date = date('Y-m-d');
        $this->data['start_date'] = array(
            'name' => 'start_date',
            'id' => 'start_date',
            'type' => 'text',
            'value' => $date
        );
        $this->data['end_date'] = array(
            'name' => 'end_date',
            'id' => 'end_date',
            'type' => 'text',
            'value' => $date
        );
        $this->data['button_search_sale'] = array(
            'name' => 'button_search_sale',
            'id' => 'button_search_sale',
            'type' => 'reset',
            'value' => 'Search',
        );
        $this->template->load(null, 'search/sale/purchase_order_no', $this->data);
    }
    
    /*
     * Ajax Call
     */
    public function search_sales_by_customer_card_no()
    {
        $card_no = $_POST['card_no'];
        $total_sale_price = 0;
        $total_quantity= 0;
        $total_profit = 0;
        $sale_list = array();
        $sale_list_array = $this->sale_library->get_user_sales_by_card_no($card_no)->result_array();
        if( !empty($sale_list_array) )
        {
            foreach($sale_list_array as $sale_info)
            {
                $total_sale_price = $total_sale_price + ($sale_info['sale_unit_price']*$sale_info['total_sale']);
                $total_quantity = $total_quantity + $sale_info['total_sale'];
                $total_profit = $total_profit + ($sale_info['sale_unit_price'] - $sale_info['purchase_unit_price'])*$sale_info['total_sale'];
                $sale_list[] = $sale_info;
            }
        }
        $result_array['sale_list'] = $sale_list;  
        $result_array['total_sale_price'] = $total_sale_price;
        $result_array['total_profit'] = $total_profit;
        $result_array['total_quantity'] = $total_quantity;  
        echo json_encode($result_array);
    }
    public function search_sales_customer_card_no()
    {
        $this->data['card_no'] = array(
            'name' => 'card_no',
            'id' => 'card_no',
            'type' => 'text'
        );
        $this->data['button_search_sale'] = array(
            'name' => 'button_search_sale',
            'id' => 'button_search_sale',
            'type' => 'reset',
            'value' => 'Search',
        );
        $this->template->load(null, 'search/sale/customer_card_no', $this->data);
    }
    
    /*
     * Ajax Call
     */
    public function search_sales_by_customer_name()
    {
        $name = $_POST['name'];
        $total_sale_price = 0;
        $total_quantity= 0;
        $total_profit= 0;
        $sale_list = array();
        $sale_list_array = $this->sale_library->get_user_sales_by_name($name)->result_array();
        if( !empty($sale_list_array) )
        {
            foreach($sale_list_array as $sale_info)
            {
                $total_sale_price = $total_sale_price + ($sale_info['sale_unit_price']*$sale_info['total_sale']);
                $total_quantity = $total_quantity + $sale_info['total_sale'];
                $total_profit = $total_profit + ($sale_info['sale_unit_price'] - $sale_info['purchase_unit_price'])*$sale_info['total_sale'];
                $sale_list[] = $sale_info;
            }
        }
        $result_array['sale_list'] = $sale_list;  
        $result_array['total_sale_price'] = $total_sale_price; 
        $result_array['total_profit'] = $total_profit;
        $result_array['total_quantity'] = $total_quantity;  
        echo json_encode($result_array);
    }
    public function search_sales_customer_name()
    {
        $shop_info = array();
        $shop_info_array = $this->shop_library->get_shop()->result_array();
        if(!empty($shop_info_array))
        {
            $shop_info = $shop_info_array[0];
        }
        $this->data['shop_info'] = $shop_info;
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text'
        );
        $this->data['button_search_sale'] = array(
            'name' => 'button_search_sale',
            'id' => 'button_search_sale',
            'type' => 'reset',
            'value' => 'Search',
        );
        if($shop_info['shop_type_id'] == SHOP_TYPE_SMALL){$this->template->load(null, 'search/sale/customer_name', $this->data);}
        if($shop_info['shop_type_id'] == SHOP_TYPE_MEDIUM){$this->template->load(null, 'search/sale/customer_name_med', $this->data);}
    }
    
    /*
     * Ajax Call
     */
    public function search_sales_by_customer_phone()
    {
        $phone = $_POST['phone'];
        $total_sale_price = 0;
        $total_quantity= 0;
        $total_profit= 0;
        $sale_list = array();
        $sale_list_array = $this->sale_library->get_user_sales_by_phone($phone)->result_array();
        //echo '<pre/>';print_r($sale_list_array);exit;
        if( !empty($sale_list_array) )
        {
            foreach($sale_list_array as $sale_info)
            {
                $total_sale_price = $total_sale_price + ($sale_info['sale_unit_price']*$sale_info['total_sale']);
                $total_quantity = $total_quantity + $sale_info['total_sale'];
                $total_profit = $total_profit + ($sale_info['sale_unit_price'] - $sale_info['purchase_unit_price'])*$sale_info['total_sale'];
                $sale_list[] = $sale_info;
            }
        }
        $result_array['sale_list'] = $sale_list;  
        $result_array['total_sale_price'] = $total_sale_price;  
        $result_array['total_quantity'] = $total_quantity;  
        $result_array['total_profit'] = $total_profit;
        //echo '<pre/>';print_r($result_array);exit;
        echo json_encode($result_array);
    }
    public function search_sales_customer_phone()
    {
        $shop_info = array();
        $shop_info_array = $this->shop_library->get_shop()->result_array();
        if(!empty($shop_info_array))
        {
            $shop_info = $shop_info_array[0];
        }
        $this->data['shop_info'] = $shop_info;
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text'
        );
        $this->data['button_search_sale'] = array(
            'name' => 'button_search_sale',
            'id' => 'button_search_sale',
            'type' => 'reset',
            'value' => 'Search',
        );
        if($shop_info['shop_type_id'] == SHOP_TYPE_SMALL){$this->template->load(null, 'search/sale/customer_phone', $this->data);}
        if($shop_info['shop_type_id'] == SHOP_TYPE_MEDIUM){$this->template->load(null, 'search/sale/customer_phone_med', $this->data);}
    }
    
    public function search_customers_by_total_purchased()
    {
        $total_purchased = $_POST['total_purchased'];
        $customer_list = array();
        $card_no_customer_id_map = array();
        $card_no_total_products_map = array();
        $customer_id_array = array();
        $sale_list_array = $this->sale_library->get_all_sales()->result_array();
        foreach($sale_list_array as $sale_info)
        {
            if(!array_key_exists($sale_info['card_no'], $card_no_customer_id_map))
            {
                $card_no_customer_id_map[$sale_info['card_no']] = $sale_info['customer_id'];
            }
            if(!array_key_exists($sale_info['card_no'], $card_no_total_products_map))
            {
                $card_no_total_products_map[$sale_info['card_no']] = $sale_info['total_sale'];
            }
            else
            {
                $card_no_total_products_map[$sale_info['card_no']] = $card_no_total_products_map[$sale_info['card_no']] + $sale_info['total_sale'];
            }
        }
        foreach($card_no_total_products_map as $card_no => $total_products)
        {
            if($total_products == $total_purchased)
            {
                $customer_id_array[] = $card_no_customer_id_map[$card_no];
            }
        }
        if(!empty($customer_id_array))
        {
            $customer_list = $this->ion_auth->get_customers($customer_id_array)->result_array(); 
        }
        $result_array['customer_list'] =  $customer_list;
        echo json_encode($result_array);
    }
    public function download_search_customers_total_purchased()
    {
        $content = '';
        $total_purchased = $this->input->post('total_purchased');
        $customer_list = array();
        $card_no_customer_id_map = array();
        $card_no_total_products_map = array();
        $customer_id_array = array();
        $sale_list_array = $this->sale_library->get_all_sales()->result_array();
        foreach($sale_list_array as $sale_info)
        {
            if(!array_key_exists($sale_info['card_no'], $card_no_customer_id_map))
            {
                $card_no_customer_id_map[$sale_info['card_no']] = $sale_info['customer_id'];
            }
            if(!array_key_exists($sale_info['card_no'], $card_no_total_products_map))
            {
                $card_no_total_products_map[$sale_info['card_no']] = $sale_info['total_sale'];
            }
            else
            {
                $card_no_total_products_map[$sale_info['card_no']] = $card_no_total_products_map[$sale_info['card_no']] + $sale_info['total_sale'];
            }
        }
        foreach($card_no_total_products_map as $card_no => $total_products)
        {
            if($total_products == $total_purchased)
            {
                $customer_id_array[] = $card_no_customer_id_map[$card_no];
            }
        }
        if(!empty($customer_id_array))
        {
            $customer_list = $this->ion_auth->get_customers($customer_id_array)->result_array(); 
        }
        foreach($customer_list as $customer_info)
        {
            $content = $content.$customer_info['phone'].'-'.$customer_info['first_name'].' '.$customer_info['last_name']."\r\n";           
        }        
        $file_name = now();
        header("Content-Type:text/plain");
        header("Content-Disposition: 'attachment'; filename=".$file_name.".txt");
        echo $content;
    }
    public function search_customers_total_purchased()
    {
        $this->data['total_purchased'] = array(
            'name' => 'total_purchased',
            'id' => 'total_purchased',
            'type' => 'text'
        );
        $this->data['button_search_customer'] = array(
            'name' => 'button_search_customer',
            'id' => 'button_search_customer',
            'type' => 'button',
            'value' => 'Search',
        );
        $this->data['button_download_customer'] = array(
            'name' => 'button_download_customer',
            'id' => 'button_download_customer',
            'type' => 'submit',
            'value' => 'Download',
        );
        
        
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
        }
        
        $this->data['user_group'] = $user_group;
        $this->template->load(null, 'search/customer/total_purchased', $this->data);
    }
    
    //---------------------------------------- Customer Search -------------------------------------------
    /*
     * Ajax Call
     */
    public function search_customer_by_profession()
    {
        $profession_id = $_POST['profession_id'];
        $result_array = $this->search_customer->search_customer_by_profession($profession_id)->result_array();
        echo json_encode($result_array);
    }
    public function download_search_customer_by_profession()
    {
        $content = '';
        $profession_id = $this->input->post('profession_list');
        $customer_list_array = $this->search_customer->search_customer_by_profession($profession_id)->result_array();
        foreach($customer_list_array as $customer_info)
        {
            $content = $content.$customer_info['phone'].'-'.$customer_info['first_name'].' '.$customer_info['last_name']."\r\n";
        }
        
        $file_name = now();
        header("Content-Type:text/plain");
        header("Content-Disposition: 'attachment'; filename=".$file_name.".txt");
        echo $content;
    }
    
    public function search_customer_profession()
    {
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
        }
        
        $this->data['user_group'] = $user_group;
        
        
        $profession_list_array = $this->ion_auth->get_all_professions()->result_array();
        
        $this->data['profession_list'] = array();
        if( !empty($profession_list_array) )
        {
            foreach ($profession_list_array as $key => $profession) {
                $this->data['profession_list'][$profession['id']] = $profession['description'];
            }
        }
        $this->data['button_search_customer'] = array(
            'name' => 'button_search_customer',
            'id' => 'button_search_customer',
            'type' => 'reset',
            'value' => 'Search',
        );
        $this->data['button_download_customer'] = array(
            'name' => 'button_download_customer',
            'id' => 'button_download_customer',
            'type' => 'submit',
            'value' => 'Download',
        );
        $this->template->load(null, 'search/customer/profession',$this->data);
    }
    
    /*
     * Ajax Call
     */
    public function search_customer_by_institution()
    {
        $institution_id = $_POST['institution_id'];
        $result_array = $this->search_customer->search_customer_by_institution($institution_id)->result_array();
        echo json_encode($result_array);
    }
    
    public function download_search_customer_by_institution()
    {
        $content = '';
        $institution_id = $this->input->post('institution_list');
        $customer_list_array = $this->search_customer->search_customer_by_institution($institution_id)->result_array();
        foreach($customer_list_array as $customer_info)
        {
            $content = $content.$customer_info['phone'].'-'.$customer_info['first_name'].' '.$customer_info['last_name']."\r\n";
        }
        
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
        }
        
        $this->data['user_group'] = $user_group;
        
        $file_name = now();
        header("Content-Type:text/plain");
        header("Content-Disposition: 'attachment'; filename=".$file_name.".txt");
        echo $content;
    }
    
    public function search_customer_institution()
    {
        $institution_list_array = $this->ion_auth->get_all_institutions()->result_array();
        $this->data['institution_list'] = array();
        if( !empty($institution_list_array) )
        {
            foreach ($institution_list_array as $key => $institution) {
                $this->data['institution_list'][$institution['id']] = $institution['description'];
            }
        }
        $this->data['button_search_customer'] = array(
            'name' => 'button_search_customer',
            'id' => 'button_search_customer',
            'type' => 'reset',
            'value' => 'Search',
        );
        $this->data['button_download_customer'] = array(
            'name' => 'button_download_customer',
            'id' => 'button_download_customer',
            'type' => 'submit',
            'value' => 'Download',
        );
        
        
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
        }
        
        $this->data['user_group'] = $user_group;
        $this->template->load(null, 'search/customer/institution',$this->data);
    }
    /*
     * Ajax Call
     */
    public function search_customer_by_card_no()
    {
        
        $card_no = $_POST['card_no'];
        $result_array['customer_list'] = $this->search_customer->search_customer_by_card_no($card_no)->result_array();
        echo json_encode($result_array);
    }
    
    public function download_search_customer_by_card_no()
    {
        $content = '';
        $card_no = $this->input->post('card_no');
        $customer_list_array = $this->search_customer->search_customer_by_card_no($card_no)->result_array();
        foreach($customer_list_array as $customer_info)
        {
            $content = $content.$customer_info['phone'].'-'.$customer_info['first_name'].' '.$customer_info['last_name']."\r\n";
        }
        
        
        $file_name = now();
        header("Content-Type:text/plain");
        header("Content-Disposition: 'attachment'; filename=".$file_name.".txt");
        echo $content;
    }
    
    public function search_customer_card_no()
    {
        $this->data['card_no'] = array(
            'name' => 'card_no',
            'id' => 'card_no',
            'type' => 'text'
        );
        $this->data['button_search_customer'] = array(
            'name' => 'button_search_customer',
            'id' => 'button_search_customer',
            'type' => 'reset',
            'value' => 'Search',
        );
        $this->data['button_download_customer'] = array(
            'name' => 'button_download_customer',
            'id' => 'button_download_customer',
            'type' => 'submit',
            'value' => 'Download',
        );
        
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
        }
        
        $this->data['user_group'] = $user_group;
        $this->template->load(null, 'search/customer/card_no',$this->data);
    }
    
    /*
     * Ajax Call
     */
    public function search_customer_by_phone()
    {
        $phone = $_POST['phone'];
        $result_array['customer_list'] = $this->search_customer->search_customer_by_phone($phone)->result_array();
        echo json_encode($result_array);
    }
    
    public function download_search_customer_by_phone()
    {
        $content = '';
        $phone = $this->input->post('phone');
        $customer_list_array = $this->search_customer->search_customer_by_phone($phone)->result_array();
        foreach($customer_list_array as $customer_info)
        {
            $content = $content.$customer_info['phone'].'-'.$customer_info['first_name'].' '.$customer_info['last_name']."\r\n";
        }
        
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
        }
        
        $this->data['user_group'] = $user_group;
        
        $file_name = now();
        header("Content-Type:text/plain");
        header("Content-Disposition: 'attachment'; filename=".$file_name.".txt");
        echo $content;
    }
    
    public function search_customer_phone()
    {
        $shop_info = array();
        $shop_info_array = $this->shop_library->get_shop()->result_array();
        if(!empty($shop_info_array))
        {
            $shop_info = $shop_info_array[0];
        }
        $this->data['shop_info'] = $shop_info;
        
        
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
        }
        
        $this->data['user_group'] = $user_group;
        
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text'
        );
        $this->data['button_search_customer'] = array(
            'name' => 'button_search_customer',
            'id' => 'button_search_customer',
            'type' => 'reset',
            'value' => 'Search',
        );
        $this->data['button_download_customer'] = array(
            'name' => 'button_download_customer',
            'id' => 'button_download_customer',
            'type' => 'submit',
            'value' => 'Download',
        );
        if($shop_info['shop_type_id'] == SHOP_TYPE_SMALL){$this->template->load(null, 'search/customer/phone',$this->data);}
        if($shop_info['shop_type_id'] == SHOP_TYPE_MEDIUM){$this->template->load(null, 'search/customer/phone_med',$this->data);}
    }
    
    /*
     * Ajax Call
     */
    public function search_customer_by_card_no_range()
    {
        $start_card_no = $_POST['start_card_no'];
        $end_card_no = $_POST['end_card_no'];
        
        $customer_list = array();
        $customer_list_array = $this->search_customer->search_customer_by_card_no_range()->result_array();
        foreach($customer_list_array as $customer_info)
        {
            if( $start_card_no+0 <= $customer_info['card_no']+0 && $customer_info['card_no']+0 <= $end_card_no+0)
            {
                $customer_list[] = $customer_info;
            }
        }
        $result_array['customer_list'] = $customer_list;
        echo json_encode($result_array);
    }
    
    public function download_search_customer_by_card_no_range()
    {
        $content = '';
        $start_card_no = $this->input->post('start_card_no');
        $end_card_no = $this->input->post('end_card_no');
        
        $customer_list_array = $this->search_customer->search_customer_by_card_no_range($shop_id = '',$start_card_no, $end_card_no)->result_array();
        foreach($customer_list_array as $customer_info)
        {
            $content = $content.$customer_info['phone'].'-'.$customer_info['first_name'].' '.$customer_info['last_name']."\r\n";
        }
        
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
        }
        
        $this->data['user_group'] = $user_group;
        
        $file_name = now();
        header("Content-Type:text/plain");
        header("Content-Disposition: 'attachment'; filename=".$file_name.".txt");
        echo $content;
    }
    
    public function search_customer_card_no_range()
    {
        $this->data['start_card_no'] = array(
            'name' => 'start_card_no',
            'id' => 'start_card_no',
            'type' => 'text'
        );
        $this->data['end_card_no'] = array(
            'name' => 'end_card_no',
            'id' => 'end_card_no',
            'type' => 'text'
        );
        $this->data['button_search_customer'] = array(
            'name' => 'button_search_customer',
            'id' => 'button_search_customer',
            'type' => 'reset',
            'value' => 'Search',
        );
        
        $this->data['button_download_customer'] = array(
            'name' => 'button_download_customer',
            'id' => 'button_download_customer',
            'type' => 'submit',
            'value' => 'Download',
        );
        
        
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
        }
        
        $this->data['user_group'] = $user_group;
        
        $this->template->load(null, 'search/customer/card_no_range',$this->data);
    }
    
    //omar
    public function get_supplier() {
        $suppliers = $this->ion_auth->get_all_supplier_for_typeahed();
        $temp_supplier = array();
        
        foreach ($suppliers as  $supplier) {
            $supplier -> value = $supplier -> first_name . " ". $supplier -> last_name . " ". $supplier -> phone . " " . $supplier -> company;
            //$supplier -> value = $supplier -> first_name . " ". $supplier -> last_name . " ". $supplier -> phone . " " . $supplier -> company;
            array_push($temp_supplier, $supplier);
        }
        echo json_encode($temp_supplier);
    }
    
    public function get_customer()
    {
        $customers = $this->ion_auth->get_all_customers_for_typeahed();
        $temp_customer = array();
        
        foreach ($customers as  $customer) {
            $customer -> value = $customer -> first_name . " ". $customer -> last_name . " ". $customer -> phone ." ". $customer->card_no ;
            array_push($temp_customer, $customer);
        }
        echo json_encode($temp_customer);
    }
    
    /*
     * This method will return customer list from typeahead request
     * @author Nazmul on 19th June 2014
     */
    public function get_customers()
    {
        $search_value = $_GET['query'];
        $customers = $this->search_typeahead->get_customers($search_value);
        echo json_encode($customers);
    }
    
    /*
     * This method will return customer info for ajax call
     * @author Nazmul on 19th June 2014
     */
    public function get_customer_info()
    {
        $result = array();
        $customer_id = $_POST['customer_id'];
        $customer_info = array();
        if($customer_id > 0)
        {
            $customer_list_array = $this->ion_auth->get_customer_info($customer_id)->result_array();
            if(!empty($customer_list_array))
            {
                $customer_info = $customer_list_array[0];
            }
        }
        if(!empty($customer_info))
        {
            $result['status'] = 1;
            $result['customer_info'] = $customer_info;
        }
        else
        {
            $result['status'] = 0;
            $result['message'] = 'Invalid customer';
        }
        echo json_encode($result);
    }
    
    /*
     * This method will return supplier list from typeahead request
     * @author Nazmul on 19th June 2014
     */
    public function get_suppliers()
    {
        $search_value = $_GET['query'];
        $suppliers = $this->search_typeahead->get_suppliers($search_value);
        echo json_encode($suppliers);
    }
    
    /*
     * This method will return supplier info for ajax call
     * @author Nazmul on 19th June 2014
     * return supplier_info with status 1, otherwise error message with status 0
     */
    public function get_supplier_info()
    {
        $result = array();
        $supplier_id = $_POST['supplier_id'];
        $supplier_info = array();
        if($supplier_id > 0)
        {
            $supplier_list_array = $this->ion_auth->get_supplier_info($supplier_id)->result_array();
            if(!empty($supplier_list_array))
            {
                $supplier_info = $supplier_list_array[0];
            }
        }
        if(!empty($supplier_info))
        {
            $result['status'] = 1;
            $result['supplier_info'] = $supplier_info;
        }
        else
        {
            $result['status'] = 0;
            $result['message'] = 'Invalid supplier';
        }
        echo json_encode($result);
    }
    
}
