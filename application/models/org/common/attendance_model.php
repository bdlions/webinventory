<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Attendance Model
 *
 * Requirements: PHP5 or above
 *
 */
class Attendance_model extends Ion_auth_model {
    public function __construct() {
        parent::__construct();
    }
    
    public function store_attendance($data)
    {
        
    }
    
    public function add_attendance($data)
    {
        $data = $this->_filter_data($this->tables['attendance'], $data);
        $this->db->insert($this->tables['attendance'], $data);
        $id = $this->db->insert_id();
        //$this->set_message('store_attendance_successful');
        return (isset($id)) ? $id : FALSE; 
    }
    
    public function update_attendance($data)
    {
        $data = $this->_filter_data($this->tables['attendance'], $data);
        $this->db->where('shop_id', $data['shop_id']);
        $this->db->where('user_id', $data['user_id']);
        $this->db->where('login_date', $data['login_date']);
        $this->db->update($this->tables['attendance'], $data);
        //$this->set_message('store_attendance_successful');
    }
    
    public function get_attendance($start_date, $end_date, $user_id = 0, $shop_id = 0 )
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        if($user_id != 0)
        {
            $this->db->where('user_id', $user_id);
        }
        $end_date = date('Y-m-d', strtotime('+1 day', strtotime($end_date)));
        $this->db->where('login_date >=', $start_date);
        $this->db->where('login_date <=', $end_date);
        //$this->response = $this->db->get($this->tables['attendance']);
        //return $this;
        return $this->db->select($this->tables['attendance'].'.*,'.$this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name')
                    ->from($this->tables['attendance'])
                    ->join($this->tables['users'], $this->tables['users'].'.id='.$this->tables['attendance'].'.user_id')
                    ->where($this->tables['attendance'].'.shop_id',$shop_id)
                    ->get();
    }
}
