<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 * Requirements: PHP5 or above
 *
 */
class Manage_queue_model extends Ion_auth_model {
    public function __construct() {
        parent::__construct();
    }   
    
    public function insert_phone_numbers($additional_data)
    {
        $this->db->insert($this->tables['phone_directory'], $additional_data);
        $id = $this->db->insert_id();
        
        return (isset($id)) ? $id : FALSE;
    }
    
}