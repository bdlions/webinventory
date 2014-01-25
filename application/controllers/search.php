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
        $this->template->load(null, 'search/customer_profession',$this->data);
    }
}
