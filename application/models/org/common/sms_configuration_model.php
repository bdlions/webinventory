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
class Sms_configuration_model extends Ion_auth_model {
    public function __construct() {
        parent::__construct();
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
