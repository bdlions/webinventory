<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Supplier
 *
 * @author Zia
 */
class Sales extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        //$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        //$this->lang->load('auth');
        //$this->load->helper('language');
    }
    function newSalesOrder()
    {
        //$this->load->view('supplier/suppliers');
        $this->template->load(SALESMAN_LOGIN_SUCCESS_TEMPLATE, 'sales/sales_order');
    }
    
    function customerSelect()
    {
        $this->template->load(SALESMAN_LOGIN_SUCCESS_TEMPLATE, 'sales/customer_select');
    }
    function newCustomer()
    {
        $this->template->load(SALESMAN_LOGIN_SUCCESS_TEMPLATE, 'sales/new_customer');
    }
    function customerList()
    {
        $this->template->load(SALESMAN_LOGIN_SUCCESS_TEMPLATE, 'sales/customer_list');
    }
    function paidOrders()
    {
        $this->template->load(SALESMAN_LOGIN_SUCCESS_TEMPLATE, 'sales/paid_orders');
    }
    function signUp()
    {
        $this->template->load(SALESMAN_LOGIN_SUCCESS_TEMPLATE, 'supplier/create_user_new');
    }
    function home()
    {
        $this->template->load(SALESMAN_LOGIN_SUCCESS_TEMPLATE, 'supplier/home');
    }


    //put your code here
}

?>
