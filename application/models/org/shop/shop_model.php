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
        if ($this->shop_identity_column == 'name' && $this->shop_identity_check($additional_data[$this->shop_identity_column])) 
        {
            $this->set_error('shop_creation_duplicate_shop');
            return FALSE;
        }   
        //filter out any data passed that doesnt have a matching column in the users table
        $additional_data = $this->_filter_data($this->tables['shop_info'], $additional_data);
        $this->db->insert($this->tables['shop_info'], $additional_data);
        $id = $this->db->insert_id();
        $this->set_message('shop_create_successful');
        $this->trigger_events('post_create_shop');
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
        $this->response = $this->db->get($this->tables['shop_info']);
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
        $this->response = $this->db->get($this->tables['shop_info']);
        return $this;
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
