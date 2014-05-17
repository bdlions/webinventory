<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {
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
    }
    
    function index()
    {
        
    }
    /*
     * This method will create new custom message
     * @Author Nazmul on 17th May 2014
     */
    public function create_custom_message()
    {
        
    }
    /*
     * This method will update custom message
     * @Author Nazmul on 17th May 2014
     */
    public function update_custom_message()
    {
        
    }
    
    /*
     * This method will search custom message
     * @Author Nazmul on 17th May 2014
     */
    public function search_custom_messages()
    {
        
    }
}
