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
class Search_typeahead_model extends Ion_auth_model {
    public function __construct() {
        parent::__construct();
    }
    
    /*
     * This method will return customer list
     * @param $search_value, value to be searched in first_name/last_name/phone/card_no
     * @param $shop_id, shop id
     * @author Nazmul on 19th June 2014
     */
    public function get_customers($search_value, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->like($this->tables['users'].'.first_name', $search_value);
        $this->db->or_like($this->tables['users'].'.last_name', $search_value);
        $this->db->or_like($this->tables['users'].'.phone', $search_value);
        $this->db->or_like($this->tables['customers'].'.card_no', $search_value);
        $this->db->order_by($this->tables['customers'].'.card_no','asc');
        $this->db->limit(100);
        $query = $this->db->select($this->tables['customers'].'.id as customer_id,'. $this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name, '.$this->tables['users'].'.phone,'.$this->tables['customers'].'.card_no')
                    ->from($this->tables['users'])
                    ->join($this->tables['customers'], $this->tables['users'].'.id='.$this->tables['customers'].'.user_id')
                    ->join($this->tables['users_shop_info'], $this->tables['users'].'.id='.$this->tables['users_shop_info'].'.user_id AND '.$this->tables['users_shop_info'].'.shop_id = '.$shop_id)
                    ->get();
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    /*
     * This method will return supplier list
     * @param $search_value, value to be searched in first_name/last_name/phone/company
     * @param $shop_id, shop id
     * @author Nazmul on 19th June 2014
     */
    public function get_suppliers($search_value, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->like($this->tables['users'].'.first_name', $search_value);
        $this->db->or_like($this->tables['users'].'.last_name', $search_value);
        $this->db->or_like($this->tables['users'].'.phone', $search_value);
        $this->db->or_like($this->tables['suppliers'].'.company', $search_value);
        $this->db->order_by($this->tables['suppliers'].'.company','asc');
        $this->db->limit(100);
        $query = $this->db->select($this->tables['users'].'.id as user_id,'.$this->tables['suppliers'].'.id as supplier_id,'. $this->tables['users'].'.username,'. $this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name, '.$this->tables['users'].'.phone,'.$this->tables['suppliers'].'.company')
                    ->from($this->tables['users'])
                    ->join($this->tables['suppliers'], $this->tables['users'].'.id='.$this->tables['suppliers'].'.user_id')
                    ->join($this->tables['users_shop_info'], $this->tables['users'].'.id='.$this->tables['users_shop_info'].'.user_id AND '.$this->tables['users_shop_info'].'.shop_id = '.$shop_id)
                    ->get();
        
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return array();
        }
    }
}
