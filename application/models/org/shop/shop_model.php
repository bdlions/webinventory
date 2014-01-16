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
    public function __construct() {
        parent::__construct();        
    }

    //---------------------------------------------- Shop related queries -------------------------------------------
    /*
     * This method will add a new shop into database
     */
    public function create_shop($additional_data)
    {
        $this->trigger_events('pre_create_shop');
            
        //filter out any data passed that doesnt have a matching column in the users table
        $additional_data = $this->_filter_data($this->tables['shop_info'], $additional_data);

        $this->db->insert($this->tables['shop_info'], $additional_data);

        $id = $this->db->insert_id();

        $this->trigger_events('post_create_shop');

        return (isset($id)) ? $id : FALSE;
    }
    
    public function update_shop($shop_id, $data)
    {
        $this->db->update($this->tables['shop_info'], $data, array('id' => $shop_id));
    }
    
    public function get_shop($shop_id = '')
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('id', $shop_id);
        $this->response = $this->db->get($this->tables['shop_info']);
        return $this;
    }
    
    public function get_all_shops()
    {
        $this->response = $this->db->get($this->tables['shop_info']);
        return $this;
    }    
}
