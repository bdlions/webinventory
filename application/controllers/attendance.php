<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends CI_Controller {
    /*
     * Holds account status list
     * 
     * $var array
     */

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('org/common/attendances');
        $this->load->helper('url');
        $this->load->helper('file');

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
    
        if(!$this->ion_auth->logged_in())
        {
            redirect("user/login","refresh");
        }
    }    
    
    public function store_attendance()
    {
        $this->data['message'] = '';
        $salesman_list = array();
        $salesman_list_array = $this->ion_auth->get_all_salesman()->result_array();
        if(!empty($salesman_list_array))
        {
            foreach($salesman_list_array as $key => $salesman_info)
            {
                $salesman_list[] = $salesman_info;
            }
        }
        $this->data['salesman_list'] = $salesman_list;
        
        if($this->input->post('submit_store_attendance'))
        {
            $shop_id = $this->session->userdata('shop_id');
            $login_date = $this->input->post('login_date');
            $login_time = $this->input->post('login_time');
            $logout_time = $this->input->post('logout_time');
            $attendance_comment = $this->input->post('attendance_comment');
            $selected_user_id_array = array();
            foreach($salesman_list_array as $salesman_info)
            {
                if($this->input->post($salesman_info['user_id']))
                {
                    $selected_user_id_array[] = $salesman_info['user_id'];
                    if( ($login_time != '' && $logout_time != '') || ($login_time != '' && $logout_time == '') )
                    {
                        $data = array(
                            'shop_id' => $shop_id,
                            'user_id' => $salesman_info['user_id'],
                            'login_date' => $login_date,
                            'login_time' => $login_time,
                            'logout_time' => $logout_time,
                            'attendance_comment' => $attendance_comment
                        );
                        $this->attendances->add_attendance($data);
                    }
                    else if( $login_time == '' && $logout_time != '' )
                    {
                        $data = array(
                            'shop_id' => $shop_id,
                            'user_id' => $salesman_info['user_id'],
                            'login_date' => $login_date,
                            'logout_time' => $logout_time
                        );
                        if($attendance_comment != '')
                        {
                            $data['attendance_comment'] = $attendance_comment;
                        }
                        $this->attendances->update_attendance($data);                        
                    }                    
                }
            }
            $this->session->set_flashdata('message', 'Attendance stored successfully');
            redirect('attendance/store_attendance','refresh');
        }
        else
        {
            $this->data['message'] = $this->session->flashdata('message'); 
        }
        
        $date = date('Y-m-d');
        $this->data['login_date'] = array(
            'name' => 'login_date',
            'id' => 'login_date',
            'type' => 'text',
            'value' => $date
        );
        $this->data['login_time'] = array(
            'name' => 'login_time',
            'id' => 'login_time',
            'type' => 'text'
        );
        $this->data['logout_time'] = array(
            'name' => 'logout_time',
            'id' => 'logout_time',
            'type' => 'text'
        );
        $this->data['attendance_comment'] = array(
            'name' => 'attendance_comment',
            'id' => 'attendance_comment',
            'type' => 'text'
        );
        $this->data['submit_store_attendance'] = array(
            'name' => 'submit_store_attendance',
            'id' => 'submit_store_attendance',
            'type' => 'submit',
            'value' => 'Add',
        );
        $this->template->load(null, 'attendance/store_attendance', $this->data);
    }
    
    public function show_attendance()
    {
        $this->data['message'] = '';
        $salesman_list = array();
        $salesman_list_array = $this->ion_auth->get_all_salesman()->result_array();
        if(!empty($salesman_list_array))
        {
            foreach($salesman_list_array as $key => $salesman_info)
            {
                $salesman_list[$salesman_info['user_id']] = $salesman_info['first_name'].' '.$salesman_info['last_name'];
            }
        }
        $date = date('Y-m-d');
        $attendance_info_array = $this->attendances->get_attendance($date, $date)->result_array();
        $this->data['attendance_list'] = $attendance_info_array;
        $this->data['salesman_list'] = $salesman_list;        
        $this->data['show_attendance_start_date'] = array(
            'name' => 'show_attendance_start_date',
            'id' => 'show_attendance_start_date',
            'type' => 'text',
            'value' => $date
        );
        $this->data['show_attendance_end_date'] = array(
            'name' => 'show_attendance_end_date',
            'id' => 'show_attendance_end_date',
            'type' => 'text',
            'value' => $date
        );
        $this->data['button_search_attendance'] = array(
            'name' => 'button_search_attendance',
            'id' => 'button_search_attendance',
            'type' => 'submit',
            'value' => 'Search',
        );
        $this->template->load(null, 'attendance/show_attendance', $this->data);
    }
    
    public function search_attendance()
    {
        $shop_id = $this->session->userdata('shop_id');
        $user_id = $_POST['user_id'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $attendance_info_array = $this->attendances->get_attendance($start_date, $end_date, $user_id, $shop_id)->result_array();
        echo json_encode($attendance_info_array);
    }
}
