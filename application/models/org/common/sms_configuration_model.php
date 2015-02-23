<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  sms configuration model
 * @Author Nazmul on 23rd Feburary 2015
 * Requirements: PHP5 or above
 *
 */
class Sms_configuration_model extends Ion_auth_model {
    public function __construct() {
        parent::__construct();
    }    
    /*
     * This method will create sms message category
     * @param $additional_data, sms message category data
     * @Author Nazmul on 23rd February 2015
     */
    public function create_sms_message_category($additional_data)
    {
        $this->trigger_events('pre_create_sms_message_category');
        //filter out any data passed that doesnt have a matching column in the message_category table
        $message_category_data = $this->_filter_data($this->tables['message_category'], $additional_data);
        $this->db->insert($this->tables['message_category'], $message_category_data);
        $id = $this->db->insert_id();
        if( $id > 0)
        {
            $this->set_message('create_message_category_successful');
        }
        else
        {
            $this->set_error('create_message_category_unsuccessful');
        }
        $this->trigger_events('post_create_sms_message_category');
        return (isset($id)) ? $id : FALSE;
    }
    /*
     * This method will create sms message
     * @param $additional_data, sms message data
     * @param $shop_id, shop id
     * @Author Nazmul on 23rd February 2015
     */
    public function create_sms_message($additional_data, $shop_id = 0)
    {
        $this->trigger_events('pre_create_sms_message');
        if( 0 == $shop_id )
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $data = array(
            'shop_id' => $shop_id
        );
        //filter out any data passed that doesnt have a matching column in the message_category table
        $message_data = array_merge($this->_filter_data($this->tables['message_info'], $additional_data), $data);
        $this->db->insert($this->tables['message_info'], $message_data);
        $id = $this->db->insert_id();
        if( $id > 0)
        {
            $this->set_message('create_message_successful');
        }
        else
        {
            $this->set_error('create_message_unsuccessful');
        }
        $this->trigger_events('post_create_sms_message');
        return (isset($id)) ? $id : FALSE;
    }
    
   
    
    public function store_sms_configuration_shop($data)
    {         
        $data = $this->_filter_data($this->tables['sms_configuration_shop'], $data);
        if($this->is_shop_sms_status_stored($data['shop_id']))
        {            
            $this->update_sms_configuration_shop($data);
        }
        else
        {            
            $this->add_sms_configuration_shop($data);
        }
        return;
    }
    public function add_sms_configuration_shop($data)
    {
       $this->db->insert('sms_configuration_shop',$data);
       $this->set_message('add_shop_sms_configuration');
       return;
    }
    
    public function update_sms_configuration_shop($data)
    {
        $this->db->where('shop_id', $data['shop_id']);
        $this->db->update('sms_configuration_shop',$data); 
        $this->set_message('update_shop_sms_configuration');
        return;
    }
    
    public function get_sms_configuration_shop($shop_id = '')
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id', $shop_id);
        $this->response = $this->db->get($this->tables['sms_configuration_shop']);
        return $this;
    }
    
    public function get_sms_status()
    {
        $this->response = $this->db->select('*')
                            ->from('sms_configuration_shop')
                            ->join($this->tables['shop_info'], $this->tables['shop_info'].'.id='.$this->tables['sms_configuration_shop'].'.shop_id')
                            ->get();
        return $this;
    }
    
    function is_shop_sms_status_stored($shop_id = 0) 
    {
        if( $shop_id == 0 )
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        return $this->db->where('shop_id', $shop_id)->count_all_results($this->tables['sms_configuration_shop']) > 0;
    }
}
