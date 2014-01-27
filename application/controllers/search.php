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
        $this->load->library('org/product/product_library');
        $this->load->library('org/search/search_customer');
        $this->load->library('org/sale/sale_library');
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
        $customer_list_array = $this->ion_auth->search_customer($search_category_name, $search_category_value)->result_array();
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
        $supplier_list_array = $this->ion_auth->search_supplier($search_category_name, $search_category_value)->result_array();
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
    public function all_sales()
    {
        $this->data['sale_list'] = array();
        $sale_list_array = $this->sale_library->get_all_sales()->result_array();
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
        $this->data['sale_list'] = array();
        $sale_list_array = $this->sale_library->get_user_sales($start_date, $end_date, $user_id, $product_id)->result_array();
        $result_array['sale_list'] = $sale_list_array;    
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
        if( !empty($product_list_array) )
        {
            foreach($product_list_array as $key => $product_info)
            {
                $product_list[$product_info['id']] = $product_info['name'];
            }
        }
        $this->data['product_list'] = $product_list;
        $this->data['start_date'] = array(
            'name' => 'start_date',
            'id' => 'start_date',
            'type' => 'text'
        );
        $this->data['end_date'] = array(
            'name' => 'end_date',
            'id' => 'end_date',
            'type' => 'text'
        );
        $this->data['button_search_sale'] = array(
            'name' => 'button_search_sale',
            'id' => 'button_search_sale',
            'type' => 'reset',
            'value' => 'Search',
        );
        $this->template->load(null, 'search/sale/search_sales', $this->data);
    }
    
    //---------------------------------------- Customer Search -------------------------------------------
    /*
     * Ajax Call
     */
    public function search_customer_by_profession()
    {
        $profession_id = $_POST['profession_id'];
        $result_array['customer_list'] = $this->search_customer->search_customer_by_profession($profession_id)->result_array();
        echo json_encode($result_array);
    }
    
    public function search_customer_profession()
    {
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
        $this->template->load(null, 'search/customer/profession',$this->data);
    }
    
    /*
     * Ajax Call
     */
    public function search_customer_by_institution()
    {
        $institution_id = $_POST['institution_id'];
        $result_array['institution_list'] = $this->search_customer->search_customer_by_institution($institution_id)->result_array();
        echo json_encode($result_array);
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
        $this->template->load(null, 'search/customer/card_no',$this->data);
    }
}
