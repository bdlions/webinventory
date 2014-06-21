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
class Search_customer_model extends Ion_auth_model {
    public function __construct() {
        parent::__construct();
    }  
    
    public function search_customer_by_profession($profession_id = '', $shop_id = '')
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        if(!empty($profession_id))
        {
            $this->db->where($this->tables['customers'].'.profession_id',$profession_id);
        }
        return $this->db->select($this->tables['users'].'.id as user_id,'.$this->tables['customers'].'.id as customer_id,'. $this->tables['users'].'.username,'. $this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name, '.$this->tables['users'].'.phone,'.$this->tables['customers'].'.card_no,'.$this->tables['users'].'.address')
                    ->from($this->tables['users'])
                    ->join($this->tables['customers'], $this->tables['users'].'.id='.$this->tables['customers'].'.user_id')
                    ->join($this->tables['users_shop_info'], $this->tables['users'].'.id='.$this->tables['users_shop_info'].'.user_id')
                    ->where($this->tables['users_shop_info'].'.shop_id',$shop_id)
                    ->get(); 
    }
    
    public function search_customer_by_institution($institution_id = '', $shop_id = '')
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        if(!empty($institution_id))
        {
            $this->db->where($this->tables['customers'].'.institution_id',$institution_id);
        }
        return $this->db->select($this->tables['users'].'.id as user_id,'.$this->tables['customers'].'.id as customer_id,'. $this->tables['users'].'.username,'. $this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name, '.$this->tables['users'].'.phone,'.$this->tables['customers'].'.card_no,'.$this->tables['users'].'.address')
                    ->from($this->tables['users'])
                    ->join($this->tables['customers'], $this->tables['users'].'.id='.$this->tables['customers'].'.user_id')
                    ->join($this->tables['users_shop_info'], $this->tables['users'].'.id='.$this->tables['users_shop_info'].'.user_id')
                    ->where($this->tables['users_shop_info'].'.shop_id',$shop_id)
                    ->get(); 
    }
    
    public function search_customer_by_card_no($card_no, $shop_id = '')
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['customers'].'.card_no',$card_no);
        return $this->db->select($this->tables['users'].'.id as user_id,'.$this->tables['customers'].'.id as customer_id,'. $this->tables['users'].'.username,'. $this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name, '.$this->tables['users'].'.phone,'.$this->tables['customers'].'.card_no,'.$this->tables['users'].'.address')
                    ->from($this->tables['users'])
                    ->join($this->tables['customers'], $this->tables['users'].'.id='.$this->tables['customers'].'.user_id')
                    ->join($this->tables['users_shop_info'], $this->tables['users'].'.id='.$this->tables['users_shop_info'].'.user_id')
                    ->where($this->tables['users_shop_info'].'.shop_id',$shop_id)
                    ->get(); 
    }
    
    public function search_customer_by_phone($phone = '', $shop_id = '')
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        if(!empty($phone))
        {
            $this->db->where($this->tables['users'].'.phone',$phone);
        }
        return $this->db->select($this->tables['users'].'.id as user_id,'.$this->tables['customers'].'.id as customer_id,'. $this->tables['users'].'.username,'. $this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name, '.$this->tables['users'].'.phone,'.$this->tables['customers'].'.card_no,'.$this->tables['users'].'.address')
                    ->from($this->tables['users'])
                    ->join($this->tables['customers'], $this->tables['users'].'.id='.$this->tables['customers'].'.user_id')
                    ->join($this->tables['users_shop_info'], $this->tables['users'].'.id='.$this->tables['users_shop_info'].'.user_id')
                    ->where($this->tables['users_shop_info'].'.shop_id',$shop_id)
                    ->get(); 
    }
    
    /*
     * This method will return customer list based on card no range
     * @param $start_card_no, start card no
     * @param $end_card_no, end card no
     * @author Nazmul
     */
    public function search_customer_by_card_no_range($start_card_no , $end_card_no , $shop_id = 0 )
    {

        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }        
        $order_by = 'cast('.$this->tables['customers'].'.card_no as unsigned) asc';
        $this->db->order_by($order_by);
        $where = 'cast('.$this->tables['customers'].'.card_no as unsigned) >= '.$start_card_no;
        $this->db->where($where);
        $where = 'cast('.$this->tables['customers'].'.card_no as unsigned) <= '.$end_card_no;
        $this->db->where($where);
        //$this->db->where($this->tables['customers'].'.card_no >=', $start_card_no);
        //$this->db->where($this->tables['customers'].'.card_no <=', $end_card_no);        
        return $this->db->select($this->tables['users'].'.id as user_id,'.$this->tables['customers'].'.id as customer_id,'. $this->tables['users'].'.username,'. $this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name, '.$this->tables['users'].'.phone,'.$this->tables['customers'].'.card_no,'.$this->tables['users'].'.address')
                    ->from($this->tables['users'])
                    ->join($this->tables['customers'], $this->tables['users'].'.id='.$this->tables['customers'].'.user_id')
                    ->join($this->tables['users_shop_info'], $this->tables['users'].'.id='.$this->tables['users_shop_info'].'.user_id')
                    ->where($this->tables['users_shop_info'].'.shop_id',$shop_id)
                    ->get(); 
    }
}
