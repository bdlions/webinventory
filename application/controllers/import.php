<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends CI_Controller {
    /*
     * Holds account status list
     * 
     * $var array
     */

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('file');

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
        $this->lang->load('shop_1');
         
        if(!$this->ion_auth->logged_in())
        {
            redirect("user/login","refresh");
        }
    }
    
    function index()
    {
        
    }
    
    public function import_customer()
    {
        $lines = file('resources/customer_info.txt');
        $counter = 0;
        $total_duplicate = 0;
        $card_no_array = array();
        foreach ($lines as $line) 
        {            
            $splited_content = explode("|", $line);
            $card_no = $splited_content[1];
            if(!in_array($card_no,$card_no_array))
            {
                if($card_no >= 8001 && $card_no <= 100000)
                {
                    $card_no_array[] = $card_no;
                    $additional_data = array(
                        'card_no' => $splited_content[1],
                        'account_status_id' => ACCOUNT_STATUS_ACTIVE,
                        'first_name' => $splited_content[2],
                        'phone' => '88'.$splited_content[3],
                        'profession_id' => $splited_content[4],
                        'institution_id' => $splited_content[5],
                        'created_date' => now()
                    );
                    $groups = array('id' => USER_GROUP_CUSTOMER);
                    $user_name = '';
                    $password = "password";
                    $email = "dummy@dummy.com";
                    $user_id = $this->ion_auth->register($user_name, $password, $email, $additional_data, $groups); 
                    if( $user_id !== FALSE )
                    {
                        //print_r('user_id:'.$user_id);
                    }
                    else
                    {
                        print_r($this->ion_auth->errors_alert());
                        print_r($additional_data);
                        break;
                    }
                    $counter++;
                }
            }
            else
            {
                $total_duplicate++;
            }                      
        }
        print_r('Total duplicate entries:'.$total_duplicate);
        print_r('Total entry stored:'.$counter);
    }
    
    public function import_supplier()
    {
        $lines = file('resources/supplier_info.txt');
        $counter = 0;
        foreach ($lines as $line) 
        {            
            $splited_content = explode("|", $line);
            $additional_data = array(
                'account_status_id' => ACCOUNT_STATUS_ACTIVE,
                'first_name' => $splited_content[1],
                'phone' => '88'.$splited_content[2],
                'address' => $splited_content[3],
                'company' => '',
                'created_date' => now()
            );
            $groups = array('id' => USER_GROUP_SUPPLIER);
            $user_name = '';
            $password = "password";
            $email = "dummy@dummy.com";
            $user_id = $this->ion_auth->register($user_name, $password, $email, $additional_data, $groups); 
            if( $user_id !== FALSE )
            {
                //print_r('user_id:'.$user_id);
            }
            else
            {
                print_r($this->ion_auth->errors_alert());
                print_r($additional_data);
                break;
            }
            $counter++;                      
        }
        print_r('Total entry stored:'.$counter);
    }
    
    /*
     * This method for configure label for a shop
     * @author Omar Faruk on 29th June 2014
     */
    public function configure_shop_label()
    {
        $user_group = $this->ion_auth->get_users_groups()->result_array();
        
        if(!empty($user_group))
        {
            $user_group = $user_group[0];
        
            if($user_group['id'] != USER_GROUP_ADMIN && $user_group['id'] != USER_GROUP_MANAGER){
                redirect("user/login","refresh");
            }
        }
        

        
        $this->data['message'] = '';
        $file_content = '';
        if($this->input->post('submit_upload_file'))
        {
            $file_content = $this->input->post('submit_upload_file');
            $write_as_string = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed') ";
            $config['upload_path'] = './application/language/english/';
            $config['allowed_types'] = '*';
            $config['max_size'] = '5000';
            $config['file_name'] = 'label_'.$this->session->userdata('shop_id').'_lang'.'.php';
            $config['overwrite'] = TRUE;
            
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) 
            {
                $file_content = $this->upload->display_errors();
            } 
            else 
            {
                $string = read_file('./application/language/english/'.'label_'.$this->session->userdata('shop_id').'_lang'.'.php');
                $file_content = $string;
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
            'value' => $this->lang->line("import_configure_shop_label_update")
        );
        
        
        $this->data['download_sample_file'] = array(
            'name' => 'download_file',
            'id' => 'download_file',
            'type' => 'submit',
            'value' => $this->lang->line("import_configure_shop_label_download_sample_file")
        );
        $this->template->load(null, 'import_configure_shop_label', $this->data);
    }
    
    /*
     * This method for download sample label file for a shop
     * @author Omar Faruk on 29th June 2014
     */
    
    public function download_sample_file()
    {
        $file_read = read_file('./resources/download/sample_label_file.php');
        header("Content-Type:text/plain");
        header("Content-Disposition: 'attachment'; filename=sample_label_file.php");
        echo $file_read;
    }
    
}
