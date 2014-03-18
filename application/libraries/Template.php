<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Template {

    var $template_data = array();

    function set($name, $value) {
        $this->template_data[$name] = $value;
    }

    function load($template = null, $view = '', $view_data = array(), $return = FALSE) {
        $this->CI = & get_instance();
        $current_template = $template;
        
        if( !empty($view) ){
            $this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
        }
        if($template == null){
            $current_template = $this->getDefaultTemplate();
        }
        return $this->CI->load->view($current_template, $this->template_data, $return);
    }
    
    function getDefaultTemplate(){
        $this->CI = & get_instance();
        $current_template = NON_MEMBER_TEMPLATE;
        
        if($this->CI->ion_auth->get_current_user_type() == ADMIN){
            $current_template = ADMIN_LOGIN_SUCCESS_TEMPLATE;
        }
        else if($this->CI->ion_auth->get_current_user_type() == CUSTOMER){
            $current_template = CUSTOMER_LOGIN_SUCCESS_TEMPLATE;
        }
        else if($this->CI->ion_auth->get_current_user_type() == SALESMAN){
            $current_template = SALESMAN_LOGIN_SUCCESS_TEMPLATE;
        }
        else if($this->CI->ion_auth->get_current_user_type() == MANAGER){
            $current_template = MANAGER_LOGIN_SUCCESS_TEMPLATE;
        }
        return $current_template;
    }

}

?>