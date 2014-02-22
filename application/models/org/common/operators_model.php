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
class Operators_model extends Ion_auth_model {
    public function __construct() {
        parent::__construct();
    }
    
    public function operator_identity_check($additional_data) {
        $this->trigger_events('pre_operator_identity_check');
        $this->db->where('operator_prefix', $additional_data['operator_prefix']);
        $this->db->where('operator_name', $additional_data['operator_name']);
        return $this->db->count_all_results($this->tables['operators']) > 0;
    }
    
    public function create_operator($additional_data)
    {
        $this->trigger_events('pre_create_operator');
        if ($this->operator_identity_check($additional_data)) 
        {
            $this->set_error('operator_creation_duplicate_operator');
            return FALSE;
        }   
        //filter out any data passed that doesnt have a matching column in the users table
        $additional_data = $this->_filter_data($this->tables['operators'], $additional_data);
        $this->db->insert($this->tables['operators'], $additional_data);
        $id = $this->db->insert_id();
        $this->set_message('operator_create_successful');
        $this->trigger_events('post_create_operator');
        return (isset($id)) ? $id : FALSE;
    }
    
    public function get_all_operators()
    {
        $this->response = $this->db->get($this->tables['operators']);
        return $this;
    }
}
