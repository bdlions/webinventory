<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 * Requirements: PHP5 or above
 *
 */
class Manage_queue_model extends Ion_auth_model {
    protected $phone_number_identity_column;
    public function __construct() {
        parent::__construct();
        $this->phone_number_identity_column = $this->config->item('queue_list_phone_number_identity_column', 'ion_auth');
    }   
    
    
    // written by omar faruk
    /*public function phone_no_identity_check($identity = '') {
        if (empty($identity)) {
            return FALSE;
        }
        return TRUE;
    }*/
    
    // written by omar faruk
    public function insert_phone_numbers($additional_data)
    {
        /*if ($this->phone_number_identity_column == 'phone_number' 
                && $this->phone_no_identity_check($additional_data['phone_number'])) 
        {
            $this->set_error('duplicate_phoneno');
            return FALSE;
        }*/
        
        $this->db->insert($this->tables['phone_directory'], $additional_data);
        $id = $this->db->insert_id();
        
        return (isset($id)) ? $id : FALSE;
    }
    
    public function update_phone_directory($id,$data)
    {
        $data = $this->_filter_data($this->tables['phone_directory'], $data);
        
        $this->db->where('id',$id);
        $this->db->update($this->tables['phone_directory'],$data);
    }
    
    // written by omar faruk
    public function get_all_phoneno() {
        return $this->db->select("*")
                    ->from($this->tables['phone_directory'])
                    ->get();
    }
    
    // written by omar faruk
    public function create_manage_queue($additional_data) {
        $this->db->insert($this->tables['queue_manage'], $additional_data);
        $id = $this->db->insert_id();
        
        return (isset($id)) ? $id : FALSE;
    }
    
    // written by omar faruk
    public function get_phone_upload_list($id) {
        $this->db->where('id', $id);
        
        return $this->db->select("*")
            ->from($this->tables['phone_upload_list'])
            ->get();
    }
    
    // written by omar faruk
    public function update_phone_upload_list_for_global_msg($id, $data) {
        
        $data = $this->_filter_data($this->tables['phone_upload_list'], $data);
        $this->db->where('id',$id);
        $this->db->update($this->tables['phone_upload_list'], $data, array('id' => $id));
        return true;
    }

    
    
    public function create_queue()
    {
        
    }
    
    // written by omar faruk
    public function create_phone_list($additional_data)
    {
        $this->db->insert($this->tables['phone_upload_list'], $additional_data);
        $id = $this->db->insert_id();
        
        return (isset($id)) ? $id : FALSE;
    }
    
}