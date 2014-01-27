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
class Sale_model extends Ion_auth_model 
{
    public function __construct() {
        parent::__construct();        
    }

    /**
     * Storing sale order, product sale order into the database
     * Updating stock into the database
     * @return sale order id
     * @author Nazmul on 23rd November 2014
     * */
    public function add_sale_order($additional_data, $sale_product_list, $update_stock_list)
    {
        $this->trigger_events('pre_add_sale_order');
        //filter out any data passed that doesnt have a matching column in the users table
        $sale_data = $this->_filter_data($this->tables['sale_order'], $additional_data);
        $this->db->trans_begin();
        $this->db->insert($this->tables['sale_order'], $sale_data);

        $id = $this->db->insert_id();
        if($id > 0)
        {
            $this->db->insert_batch($this->tables['product_sale_order'], $sale_product_list);
            foreach($update_stock_list as $key => $update_stock_info)
            {
                $this->db->update($this->tables['stock_info'], $update_stock_info, array('product_id' => $update_stock_info['product_id'], 'purchase_order_no' => $update_stock_info['purchase_order_no'] ));
            }
        }
        $this->db->trans_commit();
        $this->trigger_events('post_add_sale_order');
        return (isset($id)) ? $id : FALSE;
    }
    
    public function get_all_sales($shop_id = '')
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        return $this->db->select($this->tables['product_info'].'.name,'. $this->tables['product_sale_order'].'.quantity,'. $this->tables['product_sale_order'].'.unit_price as sale_unit_price,'.$this->tables['product_sale_order'].'.discount,'.$this->tables['product_sale_order'].'.sub_total as total_sale_price,'.$this->tables['product_purchase_order'].'.unit_price as purchase_unit_price,'.$this->tables['product_purchase_order'].'.purchase_order_no')
                    ->from($this->tables['product_sale_order'])
                    ->join($this->tables['product_info'], $this->tables['product_info'].'.id='.$this->tables['product_sale_order'].'.product_id')
                    ->join($this->tables['product_purchase_order'], $this->tables['product_purchase_order'].'.purchase_order_no='.$this->tables['product_sale_order'].'.purchase_order_no AND '.$this->tables['product_purchase_order'].'.product_id='.$this->tables['product_sale_order'].'.product_id')
                    ->where($this->tables['product_sale_order'].'.shop_id',$shop_id)
                    ->get();  
    }
    
    public function get_user_sales($start_date, $end_date, $user_id = '' , $product_id = '', $shop_id = '')
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        if(!empty($user_id) && $user_id > 0)
        {
            $this->db->where($this->tables['product_sale_order'].'.created_by', $user_id);
        }
        if(!empty($product_id) && $product_id > 0)
        {
            $this->db->where($this->tables['product_sale_order'].'.product_id', $product_id);
        }
        $end_date = date('Y-m-d', strtotime('+1 day', strtotime($end_date)));
        $this->db->where($this->tables['product_sale_order'].'.created_date >=', $start_date);
        $this->db->where($this->tables['product_sale_order'].'.created_date <=', $end_date);
        return $this->db->select($this->tables['product_info'].'.name,'. $this->tables['product_sale_order'].'.quantity,'. $this->tables['product_sale_order'].'.unit_price as sale_unit_price,'.$this->tables['product_sale_order'].'.discount,'.$this->tables['product_sale_order'].'.sub_total as total_sale_price,'.$this->tables['product_purchase_order'].'.unit_price as purchase_unit_price,'.$this->tables['product_purchase_order'].'.purchase_order_no')
                    ->from($this->tables['product_sale_order'])
                    ->join($this->tables['product_info'], $this->tables['product_info'].'.id='.$this->tables['product_sale_order'].'.product_id')
                    ->join($this->tables['product_purchase_order'], $this->tables['product_purchase_order'].'.purchase_order_no='.$this->tables['product_sale_order'].'.purchase_order_no AND '.$this->tables['product_purchase_order'].'.product_id='.$this->tables['product_sale_order'].'.product_id')
                    ->where($this->tables['product_sale_order'].'.shop_id',$shop_id)
                    ->get();  
    }
    
    public function get_sale_order_info($sale_id)
    {
        $this->db->where($this->tables['sale_order'].'.id', $sale_id);
        return $this->db->select('*')
                    ->from($this->tables['sale_order'])
                    ->get(); 
    }
}
