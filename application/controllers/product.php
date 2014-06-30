<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
    /*
     * Holds account status list
     * 
     * $var array
     */

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('org/product/product_library');
        $this->load->library('org/shop/shop_library');
        $this->load->helper('url');
        $this->load->helper('file');

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
        redirect("product/show_all_products");
    }
    
    /*
     * This method will dispaly add a product into database
     * @author Nazmul on 22nd January 2014
     */
    public function create_product()
    {
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
            
            if($user_group['id'] == USER_GROUP_SALESMAN)
            {
                $this->session->set_flashdata('message',"You have no permission to view that page");
                redirect('user/salesman_login',"refresh");
            }
            
            $sub_check = $this->shop_library->subsription_check();

            if($sub_check == TRUE)
            {
                if($user_group['id'] == USER_GROUP_MANAGER)
                {
                    $this->session->set_flashdata('message',MESSAGE_FOR_SUBSCRIPTION);
                    redirect('user/manager_login',"refresh");
                }
//                else if($user_group['id'] == USER_GROUP_SALESMAN)
//                {
//                    $this->session->set_flashdata('message',MESSAGE_FOR_SUBSCRIPTION);
//                    redirect('user/show_all_suppliers/25',"refresh");
//                }
            }
        }
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('name', 'Product Name', 'xss_clean|required');
        $this->form_validation->set_rules('size', 'Product Size', 'xss_clean');
        $this->form_validation->set_rules('weight', 'Product Weight', 'xss_clean');
        $this->form_validation->set_rules('warranty', 'Product Warranty', 'xss_clean');
        $this->form_validation->set_rules('quality', 'Product Quality', 'xss_clean');
        $this->form_validation->set_rules('brand_name', 'Brand Name', 'xss_clean');
        $this->form_validation->set_rules('unit_price', 'Unit Price', 'xss_clean');
        $this->form_validation->set_rules('remarks', 'Remarks', 'xss_clean');
        
        if ($this->input->post('submit_create_product')) 
        {            
            if($this->form_validation->run() == true)
            {
                $additional_data = array(
                    'size' => $this->input->post('size'),
                    'weight' => $this->input->post('weight'),
                    'warranty' => $this->input->post('warranty'),
                    'quality' => $this->input->post('quality'),
                    'brand_name' => $this->input->post('brand_name'),
                    'remarks' => $this->input->post('remarks'),
                    'unit_price' => $this->input->post('unit_price')
                );
                
                if($this->input->post('product_unit_category_list'))
                {
                    $additional_data['unit_category_id'] = $this->input->post('product_unit_category_list');
                }
                
                $product_name = $this->input->post('name');
                $product_id = $this->product_library->create_product($product_name, $additional_data);
                if( $product_id !== FALSE )
                {
                    $this->session->set_flashdata('message', $this->product_library->messages());
                    redirect('product/create_product','refresh');
                }
                else
                {
                    $this->data['message'] = $this->product_library->errors();
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
        
        $product_unit_category_list_array = $this->product_library->get_all_product_unit_category()->result_array();
        $this->data['product_unit_category_list'] = array();
        if( !empty($product_unit_category_list_array) )
        {
            foreach ($product_unit_category_list_array as $key => $unit_category) {
                $this->data['product_unit_category_list'][$unit_category['id']] = $unit_category['description'];
            }
        }
        
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('name'),
        );
        $this->data['size'] = array(
            'name' => 'size',
            'id' => 'size',
            'type' => 'text',
            'value' => $this->form_validation->set_value('size'),
        );
        $this->data['weight'] = array(
            'name' => 'weight',
            'id' => 'weight',
            'type' => 'text',
            'value' => $this->form_validation->set_value('weight'),
        );
        $this->data['warranty'] = array(
            'name' => 'warranty',
            'id' => 'warranty',
            'type' => 'text',
            'value' => $this->form_validation->set_value('warranty'),
        );
        $this->data['quality'] = array(
            'name' => 'quality',
            'id' => 'quality',
            'type' => 'text',
            'value' => $this->form_validation->set_value('quality'),
        );
        $this->data['unit_price'] = array(
            'name' => 'unit_price',
            'id' => 'unit_price',
            'type' => 'text',
            'value' => $this->form_validation->set_value('unit_price'),
        );
        $this->data['brand_name'] = array(
            'name' => 'brand_name',
            'id' => 'brand_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('brand_name'),
        );
        $this->data['remarks'] = array(
            'name' => 'remarks',
            'id' => 'remarks',
            'type' => 'text',
            'value' => $this->form_validation->set_value('remarks'),
        );
        $this->data['submit_create_product'] = array(
            'name' => 'submit_create_product',
            'id' => 'submit_create_product',
            'type' => 'submit',
            'value' => 'Add',
        );
        $this->template->load(null, 'product/create_product', $this->data);
    }
    
    public function create_product_by_ajax()
    {
        $product_name = $this->input->post('input_product_name');
        $product_unit_category = $this->input->post('product_unit_category');
        
         $data = array(
                'unit_category_id' => $product_unit_category,
                'created_on' => now()
            );

        $product_id = $this->product_library->create_product($product_name, $data);
        if( $product_id !== FALSE )
        {
            $response['status'] = 1;
            $response['message'] = 'Product is added successfully.';
            $data = $this->product_library->get_product($product_id)->result_array();
            if(!empty($data))
            {
                $response['product_info'] = $data[0];
            } 
        }
        else
        {
            $response['status'] = 0;
            $this->data['message'] = 'Duplicate product name';
        }
        
        echo json_encode($response);
    }
    
    /*
     * This method will dispaly all products of a shop
     * @author Nazmul on 22nd January 2014
     */
    public function show_all_products($shop_id = '')
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->data['product_list'] = array();
        $product_list_array = $this->product_library->get_all_products($shop_id)->result_array();
        if( !empty($product_list_array) )
        {
            $this->data['product_list'] = $product_list_array;
        }
        $this->template->load(null, 'product/show_all_products', $this->data);
    }
    
    /*
     * This method will update product info
     * @author Nazmul on 22nd January 2014
     */
    public function update_product($product_id = '')
    {
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
            
            if($user_group['id'] == USER_GROUP_SALESMAN)
            {
                $this->session->set_flashdata('message',"You have no permission to view that page");
                redirect('user/salesman_login',"refresh");
            }
            
            $sub_check = $this->shop_library->subsription_check();

            if($sub_check == TRUE)
            {
                if($user_group['id'] == USER_GROUP_MANAGER)
                {
                    $this->session->set_flashdata('message',MESSAGE_FOR_SUBSCRIPTION);
                    redirect('product/show_all_products',"refresh");
                }
                else if($user_group['id'] == USER_GROUP_SALESMAN)
                {
                    $this->session->set_flashdata('message',MESSAGE_FOR_SUBSCRIPTION);
                    redirect('product/show_all_products',"refresh");
                }
            }
        }
        
        if(empty($product_id))
        {
            redirect("product/show_all_products","refresh");
        }
        $this->data['message'] = '';
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('name', 'Product Name', 'xss_clean|required');
        $this->form_validation->set_rules('size', 'Product Size', 'xss_clean');
        $this->form_validation->set_rules('weight', 'Product Weight', 'xss_clean');
        $this->form_validation->set_rules('warranty', 'Product Warranty', 'xss_clean');
        $this->form_validation->set_rules('quality', 'Product Quality', 'xss_clean');
        $this->form_validation->set_rules('brand_name', 'Brand Name', 'xss_clean');
        $this->form_validation->set_rules('unit_price', 'Unit Price', 'xss_clean|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'xss_clean');
        
        $product_info = array();
        $product_info_array = $this->product_library->get_product($product_id)->result_array();
        if(empty($product_info_array))
        {
            redirect("product/show_all_products","refresh");
        }
        else
        {
            $product_info = $product_info_array[0];
        }
        $product_unit_category_list_array = $this->product_library->get_all_product_unit_category()->result_array();
        $this->data['product_unit_category_list'] = array();
        if( !empty($product_unit_category_list_array) )
        {
            foreach ($product_unit_category_list_array as $key => $unit_category) {
                $this->data['product_unit_category_list'][$unit_category['id']] = $unit_category['description'];
            }
        }
        
        if($product_info['unit_category_id'] != NULL) {
            $this->data['selected_unit_category'] = $product_info['unit_category_id'];
        } else {
            $this->data['selected_unit_category'] = NULL;
        }

        $this->data['product_info'] = $product_info;
        if ($this->input->post('submit_update_product')) 
        {            
            if($this->form_validation->run() == true)
            {
                $additional_data = array(
                    'name' => $this->input->post('name'),
                    'size' => $this->input->post('size'),
                    'weight' => $this->input->post('weight'),
                    'warranty' => $this->input->post('warranty'),
                    'quality' => $this->input->post('quality'),
                    'brand_name' => $this->input->post('brand_name'),
                    'remarks' => $this->input->post('remarks'),
                    'unit_price' => $this->input->post('unit_price')
                );
                
                if($this->input->post('product_unit_category_list'))
                {
                    $additional_data['unit_category_id'] = $this->input->post('product_unit_category_list');
                }
                
                if( $this->product_library->update_product($product_id, $additional_data) )
                {
                    $this->session->set_flashdata('message', $this->product_library->messages());
                    redirect('product/update_product/'.$product_info['id'],'refresh');
                }
                else
                {
                    $this->data['message'] = $this->product_library->errors();
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
        
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'value' => $product_info['name']
        );
        $this->data['size'] = array(
            'name' => 'size',
            'id' => 'size',
            'type' => 'text',
            'value' => $product_info['size']
        );
        $this->data['weight'] = array(
            'name' => 'weight',
            'id' => 'weight',
            'type' => 'text',
            'value' => $product_info['weight']
        );
        $this->data['warranty'] = array(
            'name' => 'warranty',
            'id' => 'warranty',
            'type' => 'text',
            'value' => $product_info['warranty']
        );
        $this->data['quality'] = array(
            'name' => 'quality',
            'id' => 'quality',
            'type' => 'text',
            'value' => $product_info['quality']
        );
        $this->data['unit_price'] = array(
            'name' => 'unit_price',
            'id' => 'unit_price',
            'type' => 'text',
            'value' => $product_info['unit_price']
        );
        $this->data['brand_name'] = array(
            'name' => 'brand_name',
            'id' => 'brand_name',
            'type' => 'text',
            'value' => $product_info['brand_name']
        );
        $this->data['remarks'] = array(
            'name' => 'remarks',
            'id' => 'remarks',
            'type' => 'text',
            'value' => $product_info['remarks']
        );
        $this->data['submit_update_product'] = array(
            'name' => 'submit_update_product',
            'id' => 'submit_update_product',
            'type' => 'submit',
            'value' => 'Update',
        );
        $this->template->load(null, 'product/update_product', $this->data);
    }
    
    /*
     * This method will dispaly product info
     * @author Nazmul on 22nd January 2014
     */
    public function show_product($product_id = '')
    {
        if(empty($product_id))
        {
            redirect("product/show_all_products","refresh");
        }
        $product_info = array();
        $product_info_array = $this->product_library->get_product($product_id)->result_array();
        if(!empty($product_info_array))
        {
            $product_info = $product_info_array[0];
        }
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'value' => $product_info['name'],
        );
        $this->data['size'] = array(
            'name' => 'size',
            'id' => 'size',
            'type' => 'text',
            'value' => $product_info['size'],
        );
        $this->data['weight'] = array(
            'name' => 'weight',
            'id' => 'weight',
            'type' => 'text',
            'value' => $product_info['weight'],
        );
        $this->data['warranty'] = array(
            'name' => 'warranty',
            'id' => 'warranty',
            'type' => 'text',
            'value' => $product_info['warranty'],
        );
        $this->data['quality'] = array(
            'name' => 'quality',
            'id' => 'quality',
            'type' => 'text',
            'value' => $product_info['quality'],
        );
        $this->data['unit_price'] = array(
            'name' => 'unit_price',
            'id' => 'unit_price',
            'type' => 'text',
            'value' => $product_info['unit_price'],
        );
        $this->data['brand_name'] = array(
            'name' => 'brand_name',
            'id' => 'brand_name',
            'type' => 'text',
            'value' => $product_info['brand_name'],
        );
        $this->template->load(null, 'product/show_product', $this->data);
    }    
    
    /*
     * Ajax Call
     * This method will create a new product into the system
     * @return status, 0 for error and 1 for success
     * @return message, if there is any error
     * @return product_info, newly created product
     * @author Nazmul on 22nd January 2014
     */
    public function create_product_sale_order()
    {
        $response = array();
        $product_name = $_POST['product_name'];
        $additional_data = array();
        $product_id = $this->product_library->create_product($product_name, $additional_data);
        if( $product_id !== FALSE )
        {
            $product_info_array = $this->product_library->get_product($product_id)->result_array();
            $product_info = array();
            if( count($product_info_array) > 0 )
            {
                $product_info = $product_info_array[0];
            }
            $response['status'] = '1';
            $response['product_info'] = $product_info;            
        }  
        else
        {
           $response['status'] = '0';
           $response['message'] = $this->product_library->errors_alert();
        }
        echo json_encode($response);
    }
    
    /*
     * Ajax Call
     * This method will create a new product into the system
     * @return status, 0 for error and 1 for success
     * @return message, if there is any error
     * @return product_info, newly created product
     * @author Nazmul on 22nd January 2014
     */
    public function create_product_purchase_order()
    {
        $response = array();
        $product_name = $_POST['product_name'];
        $additional_data = array();
        $product_id = $this->product_library->create_product($product_name, $additional_data);
        if( $product_id !== FALSE )
        {
            $product_info_array = $this->product_library->get_product($product_id)->result_array();
            $product_info = array();
            if( count($product_info_array) > 0 )
            {
                $product_info = $product_info_array[0];
            }
            $response['status'] = '1';
            $response['product_info'] = $product_info;            
        }  
        else
        {
           $response['status'] = '0';
           $response['message'] = $this->product_library->errors_alert();
        }
        echo json_encode($response);
    }
    
    /*
     * This method will upload product list
     * @author Omar Faruk on Aprial 2014
     */
    public function import_product()
    {
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
        
            if($user_group['id'] != USER_GROUP_ADMIN && $user_group['id'] != USER_GROUP_MANAGER){
                redirect("user/login","refresh");
            }
            
            $sub_check = $this->shop_library->subsription_check();

            if($sub_check == TRUE)
            {
                if($user_group['id'] == USER_GROUP_MANAGER)
                {
                    $this->session->set_flashdata('message',MESSAGE_FOR_SUBSCRIPTION);
                    redirect('user/manager_login',"refresh");
                }
                else if($user_group['id'] == USER_GROUP_SALESMAN)
                {
                    $this->session->set_flashdata('message',MESSAGE_FOR_SUBSCRIPTION);
                    redirect('user/salesman_login',"refresh");
                }
            }
        }
        

        
        $this->data['message'] = '';
        $file_content = '';
        if($this->input->post('submit_upload_file'))
        {
            //echo $this->session->userdata('shop_id'); exit("i m here");
            //$file_content = $this->input->post('submit_upload_file');
            //echo '<pre>';print_r($file_content);exit;
            $config['upload_path'] = './upload/';
            $config['allowed_types'] = 'txt';
            $config['max_size'] = '5000';
            $config['file_name'] = $this->session->userdata('shop_id').".txt";
            $config['overwrite'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) 
            {
                $file_content = $this->upload->display_errors();
            } 
            else 
            {
                $string = read_file('./upload/'.$this->session->userdata('shop_id').'.txt');
                $file_content = $string;
            }
        }
        if($this->input->post('submit_process_file'))
        {
            $content = trim($this->input->post('textarea_details'));
            $path = './upload/'.$this->session->userdata('shop_id').'.txt';
            if ( write_file($path, $content) )
            {
                 redirect('product/process_product_file/','refresh');
            }
            
        }
        $this->data['textarea_details'] = array(
            'name'  => 'textarea_details',
            'id'    => 'textarea_details',
            'value' => $file_content,
            'rows'  => '20',
            'cols'  => '100'
        );
        $this->data['submit_upload_file'] = array(
            'name' => 'submit_upload_file',
            'id' => 'submit_upload_file',
            'type' => 'submit',
            'value' => 'Upload',
        );
        $this->data['submit_process_file'] = array(
            'name' => 'submit_process_file',
            'id' => 'submit_process_file',
            'type' => 'submit',
            'value' => 'Import Product List',
        );
        
        $this->data['download_sample_file'] = array(
            'name' => 'download_file',
            'id' => 'download_file',
            'type' => 'submit',
            'value' => 'Download Sample file',
        );
        $this->template->load(null, 'product/import_product', $this->data);
    }
    
     /*
     * This method will import uploaded product list
     * @author Omar Faruk on Aprial 2014
     */
    public function process_product_file()
    {
        $product_list_map = array();
        $product_list = array();
        $this->data['message'] = '';
        $file_content = read_file('./upload/'.$this->session->userdata('shop_id').'.txt');
        $file_content_array = explode("\n", $file_content);
        
        $counter = 0;
        $total_duplicate = 0;
        
        foreach($file_content_array as $line)
        {
            if( $line != '' )
            {
                $line_array = explode("~", $line);
                if(count($line_array)> 1)
                {
                    $product_name = $line_array[0];
                    $category_name = $line_array[5];
                    $shop_id = $this->session->userdata('shop_id');
                    $product_unit = $this->product_library->get_all_product_unit_category($shop_id)->result_array();
                    $i=0;
                    $category_name_lower = strtolower($category_name);
                    for(;$i<count($product_unit);$i++){
                        $product_unit[$i]['description'] = strtolower($product_unit[$i]['description']);
                        if($product_unit[$i]['description']==$category_name_lower)
                        {
                            $category_name = $product_unit[$i]['id'];
                            break;
                        }
                    }
                    if($i==count($product_unit)){
                        $data = array(
                            'description' => $category_name,
                            'created_on' => now()
                        );
                        $category_name = $this->product_library->create_product_unit_category($data);
                    }
                    $additional_data = array(
                        'size' => $line_array[1],
                        'weight' => $line_array[2],
                        'warranty' => $line_array[3],
                        'quality' => $line_array[4],
                        'unit_category_id' => $category_name,
                        'brand_name' => $line_array[6],
                        'unit_price' => $line_array[7]                        
                    );
                    
                    //echo '<pre/>';print_r($product_name);print_r($additional_data);exit;
                    $product_id = $this->product_library->create_product($product_name, $additional_data);
                    if( $product_id !== FALSE )
                    {
                        $this->session->set_flashdata('message', $this->product_library->messages());
                        $counter++;
                    }
                    else
                    {
                        $this->data['message'] = $this->product_library->errors().' '.$product_name;
                        $total_duplicate++;
                    }
                }
            }               
        }
        
        //print_r('Total duplicate product item:'.$total_duplicate);
        //echo '<br>';
        //print_r('Total stored product item:'.$counter);
        redirect('product/show_all_products','refresh');
    }
    
     /*
     * This method for create product unit category
     * @author Omar Faruk on Aprial 2014
     */
    public function create_product_unit_category()
    {
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
            
            if($user_group['id'] == USER_GROUP_SALESMAN)
            {
                $this->session->set_flashdata('message',"You have no permission to view that page");
                redirect('user/salesman_login',"refresh");
            }
            
            $sub_check = $this->shop_library->subsription_check();

            if($sub_check == TRUE)
            {
                if($user_group['id'] == USER_GROUP_MANAGER)
                {
                    $this->session->set_flashdata('message',MESSAGE_FOR_SUBSCRIPTION);
                    redirect('user/manager_login',"refresh");
                }
//                else if($user_group['id'] == USER_GROUP_SALESMAN)
//                {
//                    $this->session->set_flashdata('message',MESSAGE_FOR_SUBSCRIPTION);
//                    redirect('user/show_all_suppliers/25',"refresh");
//                }
            }
        }
        
        
        
        $this->data['message'] = '';
        $this->form_validation->set_rules('unit_name', 'Product Unit Category Name', 'xss_clean|required');
        if ($this->input->post('submit_create_unit')) 
        {
            if ($this->form_validation->run() == true) 
            {
                $unit_name = $this->input->post('unit_name');
                $data = array(
                    'description' => $unit_name,
                    'created_on' => now()
                );
                $id = $this->product_library->create_product_unit_category($data);
                if( $id !== FALSE )
                {
                    $this->session->set_flashdata('message', 'Product Unit Category is created successfully.');
                    redirect("product/create_product_unit_category","refresh");
                }
                else
                {
                    $this->data['message'] = $this->ion_auth->errors();
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
        $this->data['unit_name'] = array(
            'name' => 'unit_name',
            'id' => 'unit_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('unit_name'),
        );
        $this->data['submit_create_unit'] = array(
            'name' => 'submit_create_unit',
            'id' => 'submit_create_unit',
            'type' => 'submit',
            'value' => 'Create',
        );
        $this->template->load(null, 'product/create_product_unit_category',$this->data);
    }
    
    public function create_product_unit(){
        $unit_name = $this->input->post('unit_name');
        $product_unit = $this->product_library->get_all_product_unit_category()->result_array();
        $unit_name_lower = strtolower($unit_name);
        for($i=0;$i<count($product_unit);$i++){
            $name = strtolower($product_unit[$i]['description']);
            if($name == $unit_name_lower){
                //echo json_encode($product_unit);
                return;
            }
        }
        
        $data = array(
                'description' => $unit_name,
                'created_on' => now()
            );
        
        $id = $this->product_library->create_product_unit_category($data);
        
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Product Unit Category is added successfully.';
            $data = $this->product_library->get_product_unit_category_info($id)->result_array();
            if(!empty($data))
            {
                $response['product_category_info'] = $data[0];
            }             
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = 'Product Unit Category is duplicate';
        }
        
        echo json_encode($response);
    }


    public function download_sample_file()
    {
        $file_read = read_file('./upload/sample_file.txt');
        header("Content-Type:text/plain");
        header("Content-Disposition: 'attachment'; filename=sample_file.txt");
        echo $file_read;
    }

}
