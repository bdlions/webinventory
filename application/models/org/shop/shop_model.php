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
class Shop_model extends Ion_auth_model {
    protected $shop_identity_column;
    public function __construct() {
        parent::__construct();  
        $this->shop_identity_column = $this->config->item('shop_identity_column', 'ion_auth');      
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
     * Create a new shop
     * @return newly created shop id
     * 
     * @author Nazmul on 23rd January 2014
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
            $data = array(
                'shop_id' => $shop_id,
                'type_id' => SMS_MESSAGE_CATEGORY_CUSTOMER_REGISTRATION_TYPE_ID,
                'description' => SMS_MESSAGE_CATEGORY_CUSTOMER_REGISTRATION_DESCRIPTION,
                'created_on' => now()
            );
            
            $message_category_id = $this->create_sms_message_category($data);
            
            if($message_category_id != FALSE)
            {
                $data = array(
                    'shop_id' => $shop_id,
                    'message_category_id' => $message_category_id,
                    'message_description' => SMS_CUSTOMER_REGISTRATION_MESSAGE,
                    'created_on' => now()
                );
                
                $id = $this->create_sms_message($data, $shop_id);
                if($id == FALSE)
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
            
            $data = array(
                'shop_id' => $shop_id,
                'type_id' => SMS_MESSAGE_CATEGORY_SUPPLIER_REGISTRATION_TYPE_ID,
                'description' => SMS_MESSAGE_CATEGORY_SUPPLIER_REGISTRATION_DESCRIPTION,
                'created_on' => now()
            );
            
            $message_category_id = $this->create_sms_message_category($data);
            
            if($message_category_id != FALSE)
            {
                $data = array(
                    'shop_id' => $shop_id,
                    'message_category_id' => $message_category_id,
                    'message_description' => SMS_SUPPLIER_REGISTRATION_MESSAGE,
                    'created_on' => now()
                );
                
                $id = $this->create_sms_message($data, $shop_id);
                if($id == FALSE)
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
    
    /*
     * 
     */
    public function create_sms_message_category($additional_data)
    {
        //filter out any data passed that doesnt have a matching column in the message_category table
        $message_category_data = $this->_filter_data($this->tables['message_category'], $additional_data);
  
        $this->db->insert($this->tables['message_category'], $message_category_data);
        $id = $this->db->insert_id();
        return (isset($id)) ? $id : FALSE;
    }
    /*
     * 
     */
    public function create_sms_message($additional_data, $shop_id = 0)
    {
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
        return (isset($id)) ? $id : FALSE;
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
