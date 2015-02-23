<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Shop Model
 * Requirements: PHP5 or above
 *
 */
class Shop_model extends Ion_auth_model {
    protected $shop_identity_column;
    public function __construct() {
        parent::__construct();  
        $this->load->model('org/common/sms_configuration_model','sms_model');
        $this->shop_identity_column = $this->config->item('shop_identity_column', 'ion_auth');      
    }
    /*
     * This method will return all shop types
     * @Author Nazmul on 23rd February 2015
     */
    public function get_all_shop_types()
    {
        $this->trigger_events('pre_get_all_shop_types');
        return $this->db->select("*")
                ->from($this->tables['shop_type'])
                ->get();
    }
    
    /*
     * This method will return shop types of a user other than super admin
     * @Author Nazmul on 23rd February 2015
     */
    public function get_user_shop_types()
    {
        $this->trigger_events('pre_get_user_shop_types');
        $this->db->where('id', SHOP_TYPE_MEDIUM);
        return $this->db->select("*")
                ->from($this->tables['shop_type'])
                ->get();
    }
    /**
     * Shop Identity check
     *
     * @return bool
     * @author Nazmul on 23rd November 2014
     * */
    public function shop_identity_check($identity = '') {
        $this->trigger_events('shop_identity_check');
        if (empty($identity)) {
            return FALSE;
        }        
        return $this->db->where($this->shop_identity_column, $identity)
                ->count_all_results($this->tables['shop_info']) > 0;
    }
    /*
     * This method will create a news shop inserting default message configuration     * 
     * @author Nazmul on 23rd February 2015
     * 
     */
    public function create_shop($additional_data)
    {
        $this->trigger_events('pre_create_shop');
        $this->db->trans_begin();
        
        if ($this->shop_identity_column == 'name' && $this->shop_identity_check($additional_data[$this->shop_identity_column])) 
        {
            $this->set_error('shop_creation_duplicate_shop');
            return FALSE;
        }   
        //filter out any data passed that doesnt have a matching column in the users table
        $additional_data = $this->_filter_data($this->tables['shop_info'], $additional_data);
        $this->db->insert($this->tables['shop_info'], $additional_data);
        $shop_id = $this->db->insert_id();
        
        if($shop_id != FALSE)
        {
            $customer_message_category_data = array(
                'shop_id' => $shop_id,
                'type_id' => SMS_MESSAGE_CATEGORY_CUSTOMER_REGISTRATION_TYPE_ID,
                'description' => SMS_MESSAGE_CATEGORY_CUSTOMER_REGISTRATION_DESCRIPTION,
                'created_on' => now()
            );       
            $customer_message_category_id = $this->sms_model->create_sms_message_category($customer_message_category_data);
            //$customer_message_category_id = $this->create_sms_message_category($customer_message_category_data);            
            if($customer_message_category_id != FALSE)
            {
                $data = array(
                    'shop_id' => $shop_id,
                    'message_category_id' => $customer_message_category_id,
                    'message_description' => SMS_CUSTOMER_REGISTRATION_MESSAGE,
                    'created_on' => now()
                );       
                $customer_message_id = $this->sms_model->create_sms_message($data, $shop_id);
                //$customer_message_id = $this->create_sms_message($data, $shop_id);
                if($customer_message_id == FALSE)
                {
                    $this->db->trans_rollback();
                    return FALSE;
                }
            }
            else
            {
                $this->db->trans_rollback();
                return FALSE;
            }            
            $supplier_message_category_data = array(
                'shop_id' => $shop_id,
                'type_id' => SMS_MESSAGE_CATEGORY_SUPPLIER_REGISTRATION_TYPE_ID,
                'description' => SMS_MESSAGE_CATEGORY_SUPPLIER_REGISTRATION_DESCRIPTION,
                'created_on' => now()
            ); 
            $supplier_message_category_id = $this->sms_model->create_sms_message_category($supplier_message_category_data);            
            //$supplier_message_category_id = $this->create_sms_message_category($supplier_message_category_data);            
            if($supplier_message_category_id != FALSE)
            {
                $data = array(
                    'shop_id' => $shop_id,
                    'message_category_id' => $supplier_message_category_id,
                    'message_description' => SMS_SUPPLIER_REGISTRATION_MESSAGE,
                    'created_on' => now()
                );                
                $supplier_message_id = $this->sms_model->create_sms_message($data, $shop_id);
                //$supplier_message_id = $this->create_sms_message($data, $shop_id);
                if($supplier_message_id == FALSE)
                {
                    $this->db->trans_rollback();
                    return FALSE;
                }
            }
            else
            {
                $this->db->trans_rollback();
                return FALSE;
            }
        }
        else
        {
            $this->db->trans_rollback();
            return FALSE;
        }        
        $this->db->trans_commit();
        $this->set_message('shop_create_successful');
        $this->trigger_events('post_create_shop');
        return (isset($shop_id)) ? $shop_id : FALSE;
    }
    
    /**
     * Update shop info
     * @return bool
     * 
     * @author Nazmul on 23rd January 2014
     * 
     * */
    public function update_shop($id, $data)
    {
        $shop_info = $this->get_shop($id)->row();
        if (array_key_exists($this->shop_identity_column, $data) && $this->shop_identity_check($data[$this->shop_identity_column]) && $shop_info->{$this->shop_identity_column} !== $data[$this->shop_identity_column])
        {
            $this->set_error('shop_update_duplicate_shop');
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['shop_info'], $data);
        $this->db->update($this->tables['shop_info'], $data, array('id' => $id));
        $this->set_message('shop_update_successful');
        return true;
    }
    /**
     * Shop Info
     * @param $shop_id, shop id
     * @return shop info
     * @author Nazmul on 23rd November 2014
     * */
    public function get_shop($shop_id = 0)
    {
        if( 0 == $shop_id )
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('id', $shop_id);
        $this->response = $this->db->select($this->tables['shop_info'].".*,".$this->tables['shop_info'].'.id as shop_id')
                                ->from($this->tables['shop_info'])
                                ->get();
        return $this;
    }
    /**
     * Shop List
     *
     * @return shop list
     * @author Nazmul on 23rd November 2014
     * */
    public function get_all_shops()
    {
//        $this->response = $this->db->get($this->tables['shop_info']);
//        return $this;
        
        return $this->db->select($this->tables['shop_info'].'.*,'.$this->tables['shop_type'].'.type as shop_type')
                    ->from($this->tables['shop_info'])
                    ->join($this->tables['shop_type'],  $this->tables['shop_type'].'.id = '.$this->tables['shop_info'].'.shop_type_id')
                    ->get();
    }
    
    /**
     * Shop Type
     * 
     * @return shop type
     * @author Redwan on 9th April 2013
     */
    
    public function get_all_shop_type(){
        
        $this->response = $this->db->select("*")
                                ->from($this->tables['shop_type'])
                                ->get();
        return $this;
    }
        
}
