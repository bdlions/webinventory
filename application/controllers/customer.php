<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include APPPATH.'controllers/user.php';
class Customer extends User {
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
     * This method will creae an institution
     * @Author Nazmul on 16th January 2015
     */
    public function create_institution() {
        $this->data['message'] = '';
        $this->form_validation->set_rules('institution_name', 'Institution Name', 'xss_clean|required');
        if ($this->input->post('submit_create_institution')) {
            if ($this->form_validation->run() == true) {
                $institution_name = $this->input->post('institution_name');
                $data = array(
                    'description' => $institution_name,
                    'created_on' => now()
                );
                $id = $this->ion_auth->create_institution($data);
                if ($id !== FALSE) {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect("customer/create_institution", "refresh");
                } else {
                    $this->data['message'] = $this->ion_auth->errors();
                }
            } else {
                $this->data['message'] = validation_errors();
            }
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }
        $this->data['institution_name'] = array(
            'name' => 'institution_name',
            'id' => 'institution_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('institution_name'),
        );
        $this->data['submit_create_institution'] = array(
            'name' => 'submit_create_institution',
            'id' => 'submit_create_institution',
            'type' => 'submit',
            'value' => 'Create',
        );
        $this->template->load(null, 'customer/create_institution', $this->data);
    }
    /*
     * This method will creae a profession
     * @Author Nazmul on 16th January 2015
     */
    public function create_profession() {
        $this->data['message'] = '';
        $this->form_validation->set_rules('profession_name', 'Profession Name', 'xss_clean|required');
        if ($this->input->post('submit_create_profession')) {
            if ($this->form_validation->run() == true) {
                $profession_name = $this->input->post('profession_name');
                $data = array(
                    'description' => $profession_name,
                    'created_on' => now()
                );
                $id = $this->ion_auth->create_profession($data);
                if ($id !== FALSE) {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect("customer/create_profession", "refresh");
                } else {
                    $this->data['message'] = $this->ion_auth->errors();
                }
            } else {
                $this->data['message'] = validation_errors();
            }
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }
        $this->data['profession_name'] = array(
            'name' => 'profession_name',
            'id' => 'profession_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('profession_name'),
        );
        $this->data['submit_create_profession'] = array(
            'name' => 'submit_create_profession',
            'id' => 'submit_create_profession',
            'type' => 'submit',
            'value' => 'Create',
        );
        $this->template->load(null, 'customer/create_profession', $this->data);
    }
    
    /*
     * This method will create a new customer
     * @Author Nazmul on 16th January 2015
     */
    public function create_customer() {
        $shop_info = array();
        $shop_info_array = $this->shop_library->get_shop()->result_array();
        if (!empty($shop_info_array)) {
            $shop_info = $shop_info_array[0];
        }
        else
        {
            //add the logic if required
        }
        $this->data['shop_info'] = $shop_info;
        $this->data['message'] = '';
        if ($shop_info['shop_type_id'] == SHOP_TYPE_SMALL) {
            $this->form_validation->set_rules('card_no', 'Card No', 'xss_clean|required');
        }
        $this->form_validation->set_rules('phone', 'Phone', 'xss_clean|required');
        //$this->form_validation->set_rules('country_code', 'Country Code', 'xss_clean|required');
        $this->form_validation->set_rules('first_name', 'First Name', 'xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'xss_clean');
        $this->form_validation->set_rules('address', 'Address', 'xss_clean');
        if ($this->input->post('submit_create_customer')) {
            if ($this->form_validation->run() == true) {
                $user_name = '';
                $password = "password";
                $email = "dummy@dummy.com";
                //$phone_no =$this->input->post('country_code').$this->input->post('phone');
                $phone_no = $this->input->post('phone');
                $additional_data = array(
                    'account_status_id' => $this->account_status_list['active_id'],
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'phone' => $phone_no,
                    'address' => $this->input->post('address'),
                    'created_on' => now()
                );
                $additional_data['shop_type_id'] = $shop_info['shop_type_id'];
                if ($shop_info['shop_type_id'] == SHOP_TYPE_SMALL) {
                    $additional_data['card_no'] = $this->input->post('card_no');
                    if ($this->input->post('institution_list')) {
                        $additional_data['institution_id'] = $this->input->post('institution_list');
                    }
                    if ($this->input->post('profession_list')) {
                        $additional_data['profession_id'] = $this->input->post('profession_list');
                    }
                }
                $groups = array('id' => USER_GROUP_CUSTOMER);
                $user_id = $this->ion_auth->register($user_name, $password, $email, $additional_data, $groups);
                if ($user_id !== FALSE) {
                    $message_type_id = SMS_MESSAGE_CATEGORY_CUSTOMER_REGISTRATION_TYPE_ID;
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
                    $customer_name = $this->input->post('first_name') . ' ' . $this->input->post('last_name');
                    $this->sms_library->send_sms($this->input->post('phone'), "Dear, " . $customer_name . ' ' . $message);
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect("customer/create_customer", "refresh");
                } else {
                    $this->data['message'] = $this->ion_auth->errors();
                }
            } else {
                $this->data['message'] = validation_errors();
            }
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }


        if ($shop_info['shop_type_id'] == SHOP_TYPE_SMALL) {
            $institution_list_array = $this->ion_auth->get_all_institutions()->result_array();
            $this->data['institution_list'] = array();
            if (!empty($institution_list_array)) {
                foreach ($institution_list_array as $key => $institution) {
                    $this->data['institution_list'][$institution['id']] = $institution['description'];
                }
            }
            $profession_list_array = $this->ion_auth->get_all_professions()->result_array();
            $this->data['profession_list'] = array();
            if (!empty($profession_list_array)) {
                foreach ($profession_list_array as $key => $profession) {
                    $this->data['profession_list'][$profession['id']] = $profession['description'];
                }
            }
            $this->data['card_no'] = array(
                'name' => 'card_no',
                'id' => 'card_no',
                'type' => 'text',
                'value' => $this->form_validation->set_value('card_no'),
            );
        }
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'value' => $this->form_validation->set_value('phone'),
        );
//        $this->data['country_code'] = array(
//            'name' => 'country_code',
//            'id' => 'country_code',
//            'type' => 'text',
//            'value' => $this->form_validation->set_value('country_code'),
//        );
        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('first_name'),
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('last_name'),
        );
        $this->data['address'] = array(
            'name' => 'address',
            'id' => 'address',
            'type' => 'textarea',
            'value' => $this->form_validation->set_value('address'),
        );
        $this->data['submit_create_customer'] = array(
            'name' => 'submit_create_customer',
            'id' => 'submit_create_customer',
            'type' => 'submit',
            'value' => 'Create',
        );
        $this->template->load(null, 'customer/create_customer', $this->data);
    }
    
    /*
     * Ajax Call
     * This method will create a customer
     * @Author Nazmul on 16th January 2015
     */
    public function create_customer_sale_order() {
        $response = array();
        $shop_info_array = $this->shop_library->get_shop()->result_array();
        if (!empty($shop_info_array)) {
            $shop_info = $shop_info_array[0];
        }
        $first_name = $this->input->post('first_name');
        //$last_name = $this->input->post('last_name');
        $phone_no = $this->input->post('phone_no');
       
        $user_name = '';
        $password = "password";
        $email = "dummy@dummy.com";
        $additional_data = array(
            'account_status_id' => $this->account_status_list['active_id'],
            'first_name' => $first_name,
            //'last_name' => $last_name,
            'phone' => $phone_no,
            'created_date' => date('Y-m-d H:i:s')
        );
        $additional_data['shop_type_id'] = $shop_info['shop_type_id'];
        if ($shop_info['shop_type_id'] == SHOP_TYPE_SMALL) {
            $additional_data['card_no'] = $this->input->post('card_no');
        }
        $groups = array('id' => USER_GROUP_CUSTOMER);
        $user_id = $this->ion_auth->register($user_name, $password, $email, $additional_data, $groups);
        if ($user_id !== FALSE) {
            $customer_info_array = $this->ion_auth->get_customer_info($user_id)->result_array();
            $customer_info = array();
            if (count($customer_info_array) > 0) {
                $customer_info = $customer_info_array[0];
            }
            $response['status'] = '1';
            $response['customer_info'] = $customer_info;
            $message_type_id = SMS_MESSAGE_CATEGORY_CUSTOMER_REGISTRATION_TYPE_ID;
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
            $customer_name = $this->input->post('first_name') . ' ' . $this->input->post('last_name');
            $this->sms_library->send_sms($this->input->post('phone'), "Dear " . $customer_name . ', ' . $message);
        } 
        else {
            $response['status'] = '0';
            $response['message'] = $this->ion_auth->errors_alert();
        }
        echo json_encode($response);
    }
    
    /*
     * This method will display all customers
     * @param $limit, limit of pagination
     * @param $offset, offset of pagination
     * @Author Nazmul on 16th January 2015
     */
    public function show_all_customers($limit, $offset = 0) {
        $shop_info = array();
        $shop_info_array = $this->shop_library->get_shop()->result_array();
        if (!empty($shop_info_array)) {
            $shop_info = $shop_info_array[0];
        }
        else
        {
            //add the logicc if required
        }
        
        $this->data['shop_info'] = $shop_info;        
        $user_id = $this->session->userdata('user_id');        
        $user_group = $this->ion_auth->get_users_groups($user_id)->result_array();        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
        }        
        $this->data['user_group'] = $user_group;        
        $this->data['customer_list'] = array();
        //list the users
        if ($limit == 0) {
            $customer_list_array = $this->ion_auth->get_all_customers($shop_info['shop_id'], $shop_info['shop_type_id'])->result_array();
            $limit = PAGINATION_CUSTOMER_LIST_LIMIT;
        } else {
            $customer_list_array = $this->ion_auth->limit($limit)->offset($offset)->get_all_customers($shop_info['shop_id'], $shop_info['shop_type_id'])->result_array();            
        }
        if (!empty($customer_list_array)) {
            $this->data['customer_list'] = $customer_list_array;
        }
        $this->data['button_download_customer'] = array(
            'name' => 'button_download_customer',
            'id' => 'button_download_customer',
            'type' => 'submit',
            'value' => 'Download',
        );

        $total_users = count($this->ion_auth->get_all_customers()->result_array());
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'customer/show_all_customers/' . $limit;
        $config['total_rows'] = $total_users;
        $config['uri_segment'] = 4;
        $config['per_page'] = PAGINATION_CUSTOMER_LIST_LIMIT;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();       
        $this->template->load(null, 'customer/show_all_customers', $this->data);
    }
    
    /*
     * Ajax Call
     * This method will return customer info
     * @Author Nazmul on 16th January 2015
     */
    public function get_customer_info()
    {
        $result = array();
        $customer_id = $this->input->post('customer_id');
        $customer_info = array();
        if($customer_id > 0)
        {
            $customer_list_array = $this->ion_auth->get_customer_info(0, $customer_id)->result_array();
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
     * This method will show a customer
     * @param $customer_id, customer id
     * @Author Nazmul on 16th January 2015
     */
    public function show_customer($customer_id = 0) {
        if ($customer_id == 0) {
            redirect("customer/show_all_customers/".PAGINATION_CUSTOMER_LIST_LIMIT, "refresh");
        }
        $this->data['message'] = '';
        $customer_info = array();
        $customer_info_array = $this->ion_auth->get_customer_info(0, $customer_id)->result_array();
        if (empty($customer_info_array)) {
            redirect("customer/show_all_customers/".PAGINATION_CUSTOMER_LIST_LIMIT, "refresh");
        } else {
            $customer_info = $customer_info_array[0];
        }        
        $this->data['customer_info'] = $customer_info;
        $shop_id = $this->session->userdata('shop_id');        
        $shop_info = $this->shop_library->get_shop($shop_id)->result_array();        
        if(!empty($shop_info))
        {
            $shop_info = $shop_info[0];
        }
        else
        {
            //write your code if required
        }  
        $this->data['shop_info'] = $shop_info;
        if($shop_info['shop_type_id'] == SHOP_TYPE_SMALL){    
        
            $institution_list_array = $this->ion_auth->get_all_institutions()->result_array();
            $this->data['institution_list'] = array();
            if (!empty($institution_list_array)) {
                foreach ($institution_list_array as $key => $institution) {
                    $this->data['institution_list'][$institution['id']] = $institution['description'];
                }
            }
            $this->data['selected_institution'] = $customer_info['institution_id'];
            $profession_list_array = $this->ion_auth->get_all_professions()->result_array();
            $this->data['profession_list'] = array();
            if (!empty($profession_list_array)) {
                foreach ($profession_list_array as $key => $profession) {
                    $this->data['profession_list'][$profession['id']] = $profession['description'];
                }
            }
            $this->data['selected_profession'] = $customer_info['profession_id'];
            $this->data['card_no'] = array(
                'name' => 'card_no',
                'id' => 'card_no',
                'type' => 'text',
                'class' => 'form-control',
                'value' => $customer_info['card_no'],
            );
        
        }
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $customer_info['phone'],
        );
        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $customer_info['first_name'],
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $customer_info['last_name'],
        );
        $this->data['address'] = array(
            'name' => 'address',
            'id' => 'address',
            'type' => 'textarea',
            'value' => $customer_info['address'],
        );
        if($shop_info['shop_type_id'] == SHOP_TYPE_SMALL){
            $this->template->load(null, 'customer/show_customer', $this->data);
        }
        else{
            $this->template->load(null, 'customer/show_customer_med', $this->data);
        }    
    }
    
    /*
     * This method will update customer information
     * @param $customer_id, customer id
     * @Author Nazmul on 16th January 2015
     */
    public function update_customer($customer_id = 0) {
        if ($customer_id == 0) {
            redirect("customer/show_all_customers/".PAGINATION_CUSTOMER_LIST_LIMIT, "refresh");
        }
        //validate whether current user has permission to update this custome or not
        $this->data['message'] = '';
        $this->form_validation->set_rules('card_no', 'Card No', 'xss_clean|required');
        $this->form_validation->set_rules('phone', 'Phone', 'xss_clean|required');
        $this->form_validation->set_rules('first_name', 'First Name', 'xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'xss_clean');
        $this->form_validation->set_rules('address', 'Address', 'xss_clean');

        $customer_info = array();
        $customer_info_array = $this->ion_auth->get_customer_info(0, $customer_id)->result_array();
        if (empty($customer_info_array)) {
            redirect("customer/show_all_customers/".PAGINATION_CUSTOMER_LIST_LIMIT, "refresh");
        } else {
            $customer_info = $customer_info_array[0];
        }
        $this->data['customer_info'] = $customer_info;        
        $shop_id = $this->session->userdata('shop_id');        
        $shop_info = $this->shop_library->get_shop($shop_id)->result_array();        
        if(!empty($shop_info))
        {
            $shop_info = $shop_info[0];
        }
        else
        {
            //write your code if required
        }
        $this->data['shop_info'] = $shop_info;
        if ($this->input->post('submit_update_customer')) {
            if ($this->form_validation->run() == true) {
                $additional_data = array(
                    'user_group_id' => $this->user_group['customer_id'],
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'phone' => $this->input->post('phone'),
                    'address' => $this->input->post('address'),
                    'modified_date' => date('Y-m-d H:i:s')
                );
                
                if($shop_info['shop_type_id']==SHOP_TYPE_SMALL){
                    $additional_data['card_no'] = $this->input->post('card_no');
                
                    if ($this->input->post('institution_list')) {
                        $additional_data['institution_id'] = $this->input->post('institution_list');
                    }
                    if ($this->input->post('profession_list')) {
                        $additional_data['profession_id'] = $this->input->post('profession_list');
                    }
                }
                
                if ($this->ion_auth->update($customer_info['user_id'], $additional_data)) {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    
                    redirect("customer/update_customer/" . $customer_id, "refresh");
                } else {
                    $this->data['message'] = $this->ion_auth->errors();
                }
            } else {
                $this->data['message'] = validation_errors();
            }
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }
        if($shop_info['shop_type_id'] == SHOP_TYPE_SMALL){
            $institution_list_array = $this->ion_auth->get_all_institutions()->result_array();
            $this->data['institution_list'] = array();
            if (!empty($institution_list_array)) {
                foreach ($institution_list_array as $key => $institution) {
                    $this->data['institution_list'][$institution['id']] = $institution['description'];
                }
            }
            $this->data['selected_institution'] = $customer_info['institution_id'];
            $profession_list_array = $this->ion_auth->get_all_professions()->result_array();
            $this->data['profession_list'] = array();
            if (!empty($profession_list_array)) {
                foreach ($profession_list_array as $key => $profession) {
                    $this->data['profession_list'][$profession['id']] = $profession['description'];
                }
            }
            $this->data['selected_profession'] = $customer_info['profession_id'];
            $this->data['card_no'] = array(
                'name' => 'card_no',
                'id' => 'card_no',
                'type' => 'text',
                'value' => $customer_info['card_no'],
            );
        }        
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'value' => $customer_info['phone'],
        );
        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $customer_info['first_name'],
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $customer_info['last_name'],
        );
        $this->data['address'] = array(
            'name' => 'address',
            'id' => 'address',
            'type' => 'textarea',
            'value' => $customer_info['address'],
        );
        $this->data['submit_update_customer'] = array(
            'name' => 'submit_update_customer',
            'id' => 'submit_update_customer',
            'type' => 'submit',
            'value' => 'Update',
        );        
        $this->template->load(null, 'customer/update_customer', $this->data);
    }
}
