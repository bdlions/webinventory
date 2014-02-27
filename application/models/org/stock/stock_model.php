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
class Stock_model extends Ion_auth_model 
{    
    public function __construct() {
        parent::__construct();        
    }

    //---------------------------------------------- Stock related queries -------------------------------------------
    public function get_all_stocks($shop_id = 0, $product_id = 0, $purchase_order_no = '')
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['stock_info'].'.shop_id', $shop_id);
        if( $product_id != 0 )
        {
            $this->db->where($this->tables['stock_info'].'.product_id', $product_id);
        }
        if( !empty($purchase_order_no) )
        {
            $this->db->where($this->tables['stock_info'].'.purchase_order_no', $purchase_order_no);
        }
        return $this->db->select($this->tables['stock_info'].'.id as stock_id,'. $this->tables['stock_info'].'.shop_id,'. $this->tables['stock_info'].'.product_id,'.$this->tables['stock_info'].'.stock_amount, '.$this->tables['stock_info'].'.purchase_order_no, '.$this->tables['stock_info'].'.created_on,'.$this->tables['product_info'].'.name as product_name,'.$this->tables['product_info'].'.code as product_code,'.$this->tables['product_purchase_order'].'.unit_price as purchase_unit_price,'.$this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name')
                    ->from($this->tables['stock_info'])
                    ->join($this->tables['product_info'], $this->tables['stock_info'].'.product_id='.$this->tables['product_info'].'.id')
                    ->join($this->tables['product_purchase_order'], $this->tables['product_purchase_order'].'.purchase_order_no='.$this->tables['stock_info'].'.purchase_order_no AND '.$this->tables['product_purchase_order'].'.product_id='.$this->tables['stock_info'].'.product_id')
                    ->join($this->tables['suppliers'], $this->tables['suppliers'].'.id='.$this->tables['stock_info'].'.supplier_id')
                    ->join($this->tables['users'], $this->tables['users'].'.id='.$this->tables['suppliers'].'.user_id')
                    ->get(); 
    }
    
    public function update_stock($update_stock_list)
    {
        foreach($update_stock_list as $key => $update_stock_info)
        {
            $this->db->update($this->tables['stock_info'], $update_stock_info, array('product_id' => $update_stock_info['product_id'], 'purchase_order_no' => $update_stock_info['purchase_order_no'], 'shop_id' => $update_stock_info['shop_id'] ));
        }
    }
}
