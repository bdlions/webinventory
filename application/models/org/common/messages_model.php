<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 * Requirements: PHP5 or above
 *
 */
class Messages_model extends Ion_auth_model {
    public function __construct() {
        parent::__construct();
    }   
    /*
     * This method will creae a new message
     * @Author Nazmul on 17th May 2014
     */
    public function create_message($data)
    {
        $data = $this->_filter_data($this->tables['custom_message'], $data);
        
        $this->db->insert($this->tables['custom_message'],$data);
        $id = $this->db->insert_id();
        
        return isset($id)?$id:False;
    }
    
    /*
     * This method will return message info
     * @param $message_id, message id
     * @Author Nazmul on 17th May 2014
     */
    public function get_message_info($message_id)
    {
        $this->db->where($this->tables['custom_message'].'.id',$message_id);
        
        return $this->db->select('*')
                    ->from($this->tables['custom_message'])
                    ->get();
    }
    
    /*
     * This method will update message info
     * @Author Nazmul on 17th May 2014
     */
    public function update_message_info($message_id, $data)
    {
        $data = $this->_filter_data($this->tables['custom_message'], $data);
        
        //echo $message_id;
        //echo '<pre/>';print_r($data);exit('model');
        
        $this->db->where('id',$message_id);
        $this->db->update($this->tables['custom_message'],$data);
    }
    /*
     * This method will return message list
     * @Param $message_id_list, message id list. If the list is empty then this method will return all messages
     * @Author Nazmul on 17th May 2014
     */
    public function get_messages($message_id_list = array(), $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        if(!empty($message_id_list))
        {
            $this->db->where_in($this->tables['custom_message'].'.id',$message_id_list);
        }
        $this->db->where($this->tables['custom_message'].'.shop_id',$shop_id);
        return $this->db->select('*')
                    ->from($this->tables['custom_message'])
                    ->get();
    }
    
    public function get_all_custom_message_for_typeahed($shop_id=0)
    {
        if($shop_id!=0)
        {
            $this->db->where($this->tables['custom_message'].'.shop_id',$shop_id);
        }
        
        return $this->db->select("*")
                    ->from($this->tables['custom_message'])
                    ->get();
    }
    
    public function get_sms_message_category($shop_id,$type_id)
    {
        $this->db->where($this->tables['message_category'].'.shop_id',$shop_id);
        $this->db->where($this->tables['message_category'].'.type_id',$type_id);
        
        return $this->db->select('*')
                    ->from($this->tables['message_category'])
                    ->get();
    }
    
    public function get_sms_message($message_category_id,$shop_id=0)
    {
        $this->db->where($this->tables['message_info'].'.message_category_id',$message_category_id);
        $this->db->where($this->tables['message_info'].'.shop_id',$shop_id);
        
        return $this->db->select('*')
                    ->from($this->tables['message_info'])
                    ->get();
    }
    public function delete_message($id)
    {
        if(!isset($id) || $id <= 0)
        {
            $this->set_error('delete_notebook_message_fail');
            return FALSE;
        }
        $this->db->where('id', $id);
        $this->db->delete($this->tables['custom_message']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_notebook_message_fail');
            return FALSE;
        }
        $this->set_message('delete_notebook_message_successful');
        return TRUE;
    }
    
}
