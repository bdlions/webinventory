<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include APPPATH.'controllers/user.php';
class Supplier extends User {
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
        
        if(!$this->ion_auth->logged_in())
        {
            redirect("user/login","refresh");
        }
    }
    
    function index()
    {
        //write your code if required
    } 
    /*
     * This method will create a new supplier
     * @Author Nazmul on 16th January 2015
     */
    public function create_supplier() {
        $this->data['message'] = '';
        $shop_info = array();
        $shop_info_array = $this->shop_library->get_shop()->result_array();
        if (!empty($shop_info_array)) {
            $shop_info = $shop_info_array[0];
        }
        $this->data['shop_info'] = $shop_info;
        $this->form_validation->set_rules('country_code', 'Country Code', 'xss_clean|required');
        $this->form_validation->set_rules('phone', 'Phone', 'xss_clean|required');
        $this->form_validation->set_rules('first_name', 'First Name', 'xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'xss_clean');
        $this->form_validation->set_rules('address', 'Address', 'xss_clean');
        $this->form_validation->set_rules('company', 'Company', 'xss_clean');

        if ($this->input->post('submit_create_supplier')) {
            if ($this->form_validation->run() == true) {
                $user_name = '';
                $password = "password";
                $email = "dummy@dummy.com";
                $phone_no =$this->input->post('country_code').$this->input->post('phone');
                $additional_data = array(
                    'account_status_id' => ACCOUNT_STATUS_ACTIVE,
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'phone' => $phone_no,
                    'address' => $this->input->post('address'),
                    'company' => $this->input->post('company'),
                    'created_on' => now()
                );
                $groups = array('id' => USER_GROUP_SUPPLIER);
                $user_id = $this->ion_auth->register($user_name, $password, $email, $additional_data, $groups);
                if ($user_id !== FALSE) {
                    $message_type_id = SMS_MESSAGE_CATEGORY_SUPPLIER_REGISTRATION_TYPE_ID;
                    $message_category_id = $this->messages->get_sms_message_category($shop_info['shop_id'], $message_type_id)->result_array();
                    if (!empty($message_category_id)) {
                        $message_category_id = $message_category_id[0];
                        $message_category_id = $message_category_id['id'];
                    }

                    $message_info_array = $this->messages->get_sms_message($message_category_id, $shop_info['id'])->result_array();
                    $message = '';
                    if (!empty($message_info_array)) {
                        $message_info = $message_info_array[0];
                        $message = $message_info['message_description'];
                    }
                    $supplier_name = $this->input->post('first_name') . ' ' . $this->input->post('last_name');
                    $this->sms_library->send_sms($this->input->post('phone'), "Dear, " . $supplier_name . ' ' . $message);
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect("supplier/create_supplier", "refresh");
                } else {
                    $this->data['message'] = $this->ion_auth->errors();
                }
            } else {
                $this->data['message'] = validation_errors();
            }
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }
         $this->data['country_code'] = array(
            'name' => 'country_code',
            'id' => 'country_code',
            'type' => 'text',
            'value' => $this->form_validation->set_value('country_code'),
        );
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('phone'),
        );
        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('first_name'),
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('last_name'),
        );
        $this->data['address'] = array(
            'name' => 'address',
            'id' => 'address',
            'type' => 'textarea',
            'value' => $this->form_validation->set_value('address'),
        );
        $this->data['company'] = array(
            'name' => 'company',
            'id' => 'company',
            'type' => 'text',
            'value' => $this->form_validation->set_value('company'),
        );
        $this->data['submit_create_supplier'] = array(
            'name' => 'submit_create_supplier',
            'id' => 'submit_create_supplier',
            'type' => 'submit',
            'value' => 'Create',
        );
        $this->template->load(null, 'supplier/create_supplier', $this->data);
    }
    
    /*
     * Ajax Call
     * This method will create a new supplier
     * @Author Nazmul on 16th January 2015
     */
    public function create_supplier_purchase_order() {
        $response = array();
        $shop_id = $this->session->userdata('shop_id');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $phone_no = $this->input->post('country_code').$this->input->post('phone_no');
        $company = $this->input->post('company');
        $user_name = '';
        $password = "password";
        $email = "dummy@dummy.com";
        $additional_data = array(
            'company' => $company,
            'account_status_id' => ACCOUNT_STATUS_ACTIVE,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone' => $phone_no,
            'created_on' => now()
        );
        $groups = array('id' => USER_GROUP_SUPPLIER);
        $user_id = $this->ion_auth->register($user_name, $password, $email, $additional_data, $groups);
        
        if ($user_id !== FALSE) {
            $message_type_id = SMS_MESSAGE_CATEGORY_SUPPLIER_REGISTRATION_TYPE_ID;
            $message_category_id = $this->messages->get_sms_message_category($shop_id, $message_type_id)->result_array();
            if (!empty($message_category_id)) {
                $message_category_id = $message_category_id[0];
                $message_category_id = $message_category_id['id'];
            }

            $message_info_array = $this->messages->get_sms_message($message_category_id, $shop_id)->result_array();
            $message = '';
            if (!empty($message_info_array)) {
                $message_info = $message_info_array[0];
                $message = $message_info['message_description'];
            }
            $supplier_name = $this->input->post('first_name') . ' ' . $this->input->post('last_name');
            $this->sms_library->send_sms($this->input->post('phone'), "Dear, " . $supplier_name . ' ' . $message);
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            $response['message'] = 'Supplier added successfully';
            $supplier_info_array = $this->ion_auth->get_supplier_info($user_id)->result_array();
            $supplier_info = array();
            if( count($supplier_info_array) > 0 )
            {
                $supplier_info = $supplier_info_array[0];
            }
            $response['status'] = '1';
            $response['supplier_info'] = $supplier_info;
        } 
        else {
            $response['status'] = '0';
            $response['message'] = $this->ion_auth->errors_alert();
        }
        echo json_encode($response);
    }
    /*
     * This method will display all suppliers
     * @param $limit, limit of pagination
     * @param $offset, offset of pagination
     * @Author Nazmul on 16th January 2015
     */
    public function show_all_suppliers($limit, $offset = 0) {
        $all_suppliers = array();
        $this->data['supplier_list'] = array();
        //list the users
        if ($limit == 0) {
            $supplier_list_array = $this->ion_auth->get_all_suppliers()->result_array();
            $limit = PAGINATION_SUPPLIER_LIST_LIMIT;
            $all_suppliers = $supplier_list_array;
        } else {
            $supplier_list_array = $this->ion_auth->limit($limit)->offset($offset)->get_all_suppliers()->result_array();
            $all_suppliers = $this->ion_auth->get_all_suppliers()->result_array();
        }
        if (!empty($supplier_list_array)) {
            $this->data['supplier_list'] = $supplier_list_array;
        }
        $this->data['all_suppliers'] = $all_suppliers;

        $total_users = count($this->ion_auth->get_all_suppliers()->result_array());
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'supplier/show_all_suppliers/' . $limit;
        $config['total_rows'] = $total_users;
        $config['uri_segment'] = 4;
        $config['per_page'] = PAGINATION_SUPPLIER_LIST_LIMIT;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->template->load(null, 'supplier/show_all_suppliers', $this->data);
    }
    
    /*
     * Ajax Call
     * This method will return supplier info
     * @Author Nazmul on 16th January 2015
     */
    public function get_supplier_info()
    {
        $result = array();
        $supplier_id = $this->input->post('supplier_id');
        $supplier_info = array();
        if($supplier_id > 0)
        {
            $supplier_list_array = $this->ion_auth->get_supplier_info(0, $supplier_id)->result_array();
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
    
    /*
     * This method will update supplier info
     * @param $supplier_id, supplier id
     * @Author Nazmul on 16th January 2015
     */
    public function update_supplier($supplier_id = 0) {
        if ($supplier_id == 0) {
            redirect("supplier/show_all_supplierss", "refresh");
        }
        //check whether current user has permission to update supplier or not
        $this->data['message'] = '';
        $this->form_validation->set_rules('phone', 'Phone', 'xss_clean|required');
        $this->form_validation->set_rules('first_name', 'First Name', 'xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'xss_clean');
        $this->form_validation->set_rules('address', 'Address', 'xss_clean');
        $this->form_validation->set_rules('company', 'Company', 'xss_clean');

        $supplier_info = array();
        $supplier_info_array = $this->ion_auth->get_supplier_info(0, $supplier_id)->result_array();
        if (empty($supplier_info_array)) {
            redirect("supplier/show_all_suppliers", "refresh");
        } else {
            $supplier_info = $supplier_info_array[0];
        }
        $this->data['supplier_info'] = $supplier_info;
        if ($this->input->post('submit_update_supplier')) {
            if ($this->form_validation->run() == true) {
                $additional_data = array(
                    'company' => $this->input->post('company'),
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'phone' => $this->input->post('phone'),
                    'address' => $this->input->post('address'),
                    'modified_on' => now()
                );
                if ($this->ion_auth->update($supplier_info['user_id'], $additional_data)) {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect("supplier/update_supplier/" . $supplier_info['supplier_id'], "refresh");
                } else {
                    $this->data['message'] = $this->ion_auth->errors();
                }
            } else {
                $this->data['message'] = validation_errors();
            }
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }

        $this->data['company'] = array(
            'name' => 'company',
            'id' => 'company',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $supplier_info['company'],
        );
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $supplier_info['phone'],
        );
        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $supplier_info['first_name'],
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $supplier_info['last_name'],
        );
        $this->data['address'] = array(
            'name' => 'address',
            'id' => 'address',
            'type' => 'textarea',
            'value' => $supplier_info['address'],
        );
        $this->data['submit_update_supplier'] = array(
            'name' => 'submit_update_supplier',
            'id' => 'submit_update_supplier',
            'type' => 'submit',
            'value' => 'Update',
        );
        $this->template->load(null, 'supplier/update_supplier', $this->data);
    }
    
    /*
     * This method will show supplier info
     * @param $supplier_id, supplier id
     * @Author Nazmul on 16th January 2015
     */
    public function show_supplier($supplier_id = 0) {
        if ($supplier_id == 0) {
            redirect("supplier/show_all_supplierss", "refresh");
        }
        $this->data['message'] = '';
        $supplier_info = array();
        $supplier_info_array = $this->ion_auth->get_supplier_info(0, $supplier_id)->result_array();
        if (empty($supplier_info_array)) {
            redirect("supplier/show_all_suppliers", "refresh");
        } else {
            $supplier_info = $supplier_info_array[0];
        }
        $this->data['supplier_info'] = $supplier_info;
        $this->data['company'] = array(
            'name' => 'company',
            'id' => 'company',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $supplier_info['company'],
        );
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $supplier_info['phone'],
        );
        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $supplier_info['first_name'],
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $supplier_info['last_name'],
        );
        $this->data['address'] = array(
            'name' => 'address',
            'id' => 'address',
            'type' => 'textarea',
            'value' => $supplier_info['address'],
        );
        $this->template->load(null, 'supplier/show_supplier', $this->data);
    }
}
