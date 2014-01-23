<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Expense extends CI_Controller {    
    protected $expense_type_list = array();
    /*
     * Holds account status list
     * 
     * $var array
     */

    function __construct() {
        parent::__construct();
        $this->expense_type_list = $this->config->item('expense_type', 'ion_auth');
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
        $this->load->library('org/shop/shop_library');
    }
    
    function index()
    {
        print_r($this->ion_auth->get_shop_id(2)->result_array());
    }
    
    public function add_expense()
    {
        $this->data['expense_type_list'] = $this->expense_type_list;
        
        $expense_types_array = $this->expenses->get_all_expense_types()->result_array();
        $expense_categories = array();
        foreach($expense_types_array as $key => $expense_type)
        {
            $expense_categories[$expense_type['id']] = $expense_type['description'];
        }
        $this->data['expense_categories'] = $expense_categories;
        
        $shop_list_array = $this->shop_library->get_all_shops()->result_array();
        $shop_list = array();
        foreach($shop_list_array as $key => $shop_info)
        {
            if( $this->session->userdata('shop_id') == $shop_info['id'])
            {
               $shop_list[$shop_info['id']] = $shop_info['name']; 
            }            
        }
        $this->data['item_list'] = $shop_list;
        
        $message_data = '';
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('expense_amount', 'Expense Amount', 'xss_clean|required');
        $this->form_validation->set_rules('expense_description', 'Expense Description', 'xss_clean');
        
        if ($this->input->post('submit_add_expense')) 
        {            
            if($this->form_validation->run() == true)
            {
                $additional_data = array(
                    'expense_type_id' => $this->input->post('expense_categories'),
                    'description' => $this->input->post('expense_description'),
                    'expense_amount' => $this->input->post('expense_amount')
                );
                if( $this->input->post('expense_categories') != $this->expense_type_list['other'])
                {
                    $additional_data['reference_id'] = $this->input->post('item_list');
                }
                $expense_id = $this->expenses->add_expense($additional_data);
                if( $expense_id !== FALSE )
                {
                    $this->session->set_flashdata('message', $this->expenses->messages());
                    redirect('expense/add_expense','refresh');
                }
                else
                {
                    $message_data = $this->expenses->errors();
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
        
        
        
        $this->data['expense_description'] = array(
            'name' => 'expense_description',
            'id' => 'expense_description',
            'class' => 'span2',
            'type' => 'text',
            'value' => $this->form_validation->set_value('expense_description'),
        );
        $this->data['expense_amount'] = array(
            'name' => 'expense_amount',
            'id' => 'expense_amount',
            'class' => 'span2',
            'type' => 'text',
            'value' => $this->form_validation->set_value('expense_amount'),
        );
        $this->data['submit_add_expense'] = array(
            'name' => 'submit_add_expense',
            'id' => 'submit_add_expense',
            'type' => 'submit',
            'value' => 'Add',
        );
        
        $this->template->load(null, 'expense/add_expense', $this->data);
    }
    
    public function show_expense()
    {
        $this->data['message'] = "";
        $this->data['expense_type_list'] = $this->expense_type_list;
        
        $expense_types_array = $this->expenses->get_all_expense_types()->result_array();
        $expense_categories = array();
        foreach($expense_types_array as $key => $expense_type)
        {
            $expense_categories[$expense_type['id']] = $expense_type['description'];
        }
        $this->data['expense_categories'] = $expense_categories;
        
        $shop_list_array = $this->shop_library->get_all_shops()->result_array();
        $shop_list = array();
        foreach($shop_list_array as $key => $shop_info)
        {
            if( $this->session->userdata('shop_id') == $shop_info['id'])
            {
               $shop_list[$shop_info['id']] = $shop_info['name']; 
            }            
        }
        $this->data['item_list'] = $shop_list;
        
        $this->template->load(null, 'expense/show_expense', $this->data);
    }
    
    public function getItems()
    {
        $result_array = array();
        $expense_type_id = $_POST['expense_type_id'];
        if( $expense_type_id == $this->expense_type_list['shop'])
        {
            $shop_list_array = $this->shop_library->get_shop()->result_array();
            $shop_list = array();
            foreach($shop_list_array as $key => $shop_info)
            {
                $shop_list[] = array(
                    'id' => $shop_info['id'],
                    'value' => $shop_info['name']
                );          
            }
            $result_array['shop_list'] = $shop_list;            
        }
        else if( $expense_type_id == $this->expense_type_list['supplier'])
        {
            $supplier_list_array = $this->ion_auth->get_all_suppliers()->result_array();
            $supplier_list = array();
            foreach($supplier_list_array as $key => $supplier_info)
            {
                $supplier_list[] = array(
                    'id' => $supplier_info['user_id'],
                    'value' => $supplier_info['first_name'].' '.$supplier_info['last_name']
                );
            }
            $result_array['supplier_list'] = $supplier_list;            
        }
        else if( $expense_type_id == $this->expense_type_list['user'])
        {
            $user_list_array = $this->ion_auth->get_all_shop_employees()->result_array();
            $user_list = array();
            //filter administrator from this list
            foreach($user_list_array as $key => $user_info)
            {
                $user_list[] = array(
                    'id' => $user_info['user_id'],
                    'value' => $user_info['first_name'].' '.$user_info['last_name']
                );
            }
            $result_array['user_list'] = $user_list;
        }
        echo json_encode($result_array);
    }
    
    public function get_expense()
    {
        $expense_type_id = $_POST['expense_type_id'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        if($expense_type_id > 0)
        {
            $expense_list_array = $this->expenses->get_expenses($expense_type_id, $start_date, $end_date)->result_array();
        }
        else
        {
            $expense_list_array = $this->expenses->get_all_expenses($start_date, $end_date)->result_array();
        }
        $result_array['expense_list'] = $expense_list_array;    
        echo json_encode($result_array);
    }
    
    public function test()
    {
        $start_date = '2014-01-22';
        $end_date = '2014-01-23';
        $expense_list_array = $this->expenses->get_all_expenses($start_date, $end_date)->result_array();
        print_r($expense_list_array);
    }
}
