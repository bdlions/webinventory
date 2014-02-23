<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Ion Auth Model
 *
 * Author:  Ben Edmunds
 * 		   ben.edmunds@gmail.com
 * 	  	   @benedmunds
 *
 * Added Awesomeness: Phil Sturgeon
 *
 * Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
 *
 * Created:  10.01.2009
 * 
 * Last Change: 3.22.13
 *
 * Changelog:
 * * 3-22-13 - Additional entropy added - 52aa456eef8b60ad6754b31fbdcc77bb
 * 
 * Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
 * Original Author name has been kept but that does not mean that the method has not been modified.
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
        $this->set_message('store_attendance_successful');
        return (isset($id)) ? $id : FALSE; 
    }
    
    public function update_attendance($data)
    {
        $data = $this->_filter_data($this->tables['attendance'], $data);
        $this->db->where('shop_id', $data['shop_id']);
        $this->db->where('user_id', $data['user_id']);
        $this->db->where('login_date', $data['login_date']);
        $this->db->update($this->tables['attendance'], $data);
        $this->set_message('store_attendance_successful');
    }
    
    public function get_attendance($shop_id, $user_id, $start_date, $end_date)
    {
        $end_date = date('Y-m-d', strtotime('+1 day', strtotime($end_date)));
        $this->db->where('login_date >=', $start_date);
        $this->db->where('login_date <=', $end_date);
        $this->db->where('shop_id', $shop_id);
        $this->db->where('user_id', $user_id);
        $this->response = $this->db->get($this->tables['attendance']);
        return $this;
    }
}
