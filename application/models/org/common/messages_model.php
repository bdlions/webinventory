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
        
        $this->db->where('id',$message_id);
        $this->db->update($this->tables['custom_message'],$data);
    }
    /*
     * This method will return message list
     * @Param $message_id_list, message id list. If the list is empty then this method will return all messages
     * @Author Nazmul on 17th May 2014
     */
    public function get_messages($message_id_list = array())
    {
        if(!empty($message_id_list))
        {
            $this->db->where_in($this->tables['custom_message'].'.id',$message_id_list);
        }
        
        return $this->db->select('*')
                    ->from($this->tables['custom_message'])
                    ->get();
    }
    
    public function get_all_custom_message_for_typeahed()
    {
        return $this->db->select("*")
                    ->from($this->tables['custom_message'])
                    ->get();
    }
}