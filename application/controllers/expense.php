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
        $this->load->library('org/common/utils');
        $this->load->library('org/shop/shop_library');
    }
    
    function index()
    {
        //print_r($this->ion_auth->get_shop_id(2)->result_array());
    }
    
    public function add_expense($selected_expense_category = 0)
    {
        if($selected_expense_category == 0)
        {
            $selected_expense_category = 3;
        }
        $current_time = now();
        $shop_id = $this->session->userdata('shop_id');
        $this->data['expense_type_list'] = $this->expense_type_list;
        
        $expense_types_array = $this->expenses->get_all_expense_types()->result_array();
        $expense_categories = array();
        foreach($expense_types_array as $key => $expense_type)
        {
            $expense_categories[$expense_type['id']] = $expense_type['description'];
        }
        $this->data['expense_categories'] = $expense_categories;
        
        
        /*$shop_list_array = $this->shop_library->get_all_shops()->result_array();
        $shop_list = array();
        foreach($shop_list_array as $key => $shop_info)
        {
            if( $this->session->userdata('shop_id') == $shop_info['id'])
            {
               $shop_list[$shop_info['id']] = $shop_info['name']; 
            }            
        }
        $this->data['item_list'] = $shop_list;*/
        $this->data['item_list'] = array();
        
        $message_data = '';
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('expense_amount', 'Expense Amount', 'xss_clean|required');
        $this->form_validation->set_rules('expense_description', 'Expense Description', 'xss_clean');
        
        if ($this->input->post('submit_add_expense')) 
        {            
            if($this->form_validation->run() == true)
            {
                $additional_data = array(
                    'shop_id' => $shop_id,
                    'expense_date' => $current_time,
                    'created_on' => $current_time,
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
                    $selected_expense_category = $this->input->post('expense_categories');
                    redirect('expense/add_expense/'.$selected_expense_category,'refresh');
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
        
        
        $this->data['selected_expense_category'] = $selected_expense_category;
        $this->data['expense_description'] = array(
            'name' => 'expense_description',
            'id' => 'expense_description',
            'type' => 'text',
            'value' => $this->form_validation->set_value('expense_description'),
        );
        $this->data['expense_amount'] = array(
            'name' => 'expense_amount',
            'id' => 'expense_amount',
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
        $this->data['message'] = $this->session->flashdata('message');
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
        $date = date('Y-m-d');    
        
        $start_time = $this->utils->get_current_date_start_time();
        $end_time = $start_time + 86400;
        $expense_list = $this->expenses->get_all_expenses($start_time, $end_time);
        $this->data['expense_list'] = $expense_list;
        
        $this->data['show_expense_start_date'] = array(
            'name' => 'show_expense_start_date',
            'id' => 'show_expense_start_date',
            'type' => 'text',
            'value' => $date
        );
        $this->data['show_expense_end_date'] = array(
            'name' => 'show_expense_end_date',
            'id' => 'show_expense_end_date',
            'type' => 'text',
            'value' => $date
        );
        $this->data['button_search_expense'] = array(
            'name' => 'button_search_expense',
            'id' => 'button_search_expense',
            'type' => 'reset',
            'value' => 'Search',
        );
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
                    'id' => $supplier_info['supplier_id'],
                    'value' => $supplier_info['first_name'].' '.$supplier_info['last_name']
                );
            }
            $supplier_list[] = array(
                'id' => 0,
                'value' => 'All'
            );
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
            $user_list[] = array(
                'id' => 0,
                'value' => 'All'
            );
            $result_array['user_list'] = $user_list;
        }
        echo json_encode($result_array);
    }
    
    public function get_expense()
    {
        $expense_type_id = $_POST['expense_type_id'];
        $reference_id = $_POST['reference_id'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $start_time = $this->utils->get_human_to_unix($start_date);
        $end_time = $this->utils->get_human_to_unix($end_date) + 86400;
        $expense_list_array = array();
        if($expense_type_id > 0)
        {
            $expense_list_array = $this->expenses->get_expenses($expense_type_id, $reference_id, $start_time, $end_time);
        }
        else
        {
            $expense_list_array = $this->expenses->get_all_expenses($start_time, $end_time);
        }
        echo json_encode($expense_list_array);
    }
    
    public function delete_expense($expense_id)
    {
        $this->data['expense_id'] = $expense_id;
        if ($this->input->post('submit_delete_expense_yes')) 
        {
            if($this->expenses->delete_expense($expense_id))
            {
                $this->session->set_flashdata('message', $this->expenses->messages());
            }
            else
            {
                $this->session->set_flashdata('message', $this->expenses->errors());
            }
            redirect('expense/show_expense','refresh');
        }
        else if ($this->input->post('submit_delete_expense_no')) 
        {
            redirect('expense/show_expense','refresh');
        }
        $this->data['submit_delete_expense_yes'] = array(
            'name' => 'submit_delete_expense_yes',
            'id' => 'submit_delete_expense_yes',
            'type' => 'submit',
            'value' => 'Yes',
        );
        $this->data['submit_delete_expense_no'] = array(
            'name' => 'submit_delete_expense_no',
            'id' => 'submit_delete_expense_no',
            'type' => 'submit',
            'value' => 'No',
        );
        $this->template->load(null, 'expense/delete_expense_confirmation', $this->data);
    }
    
    public function test()
    {
        $expense_type_id = 1;
        $start_date = '2014-03-18';
        $end_date = '2014-03-18';
        print_r($this->get_expense($expense_type_id, $start_date, $end_date));
    }
}
