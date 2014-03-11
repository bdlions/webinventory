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
class Purchase_model extends Ion_auth_model 
{
    public function __construct() {
        parent::__construct();        
    }
    
    /**
     * Purchase Order No of a shop is checked
     *
     * @return bool
     * @author Nazmul on 22nd November 2014
     * */
    public function purchase_order_no_check($purchase_order_no = '') {
        $this->trigger_events('purchase_order_no_check');
        if (empty($purchase_order_no)) {
            return FALSE;
        }
        $shop_id = $this->session->userdata('shop_id');
        $this->db->where('shop_id', $shop_id);
        $this->db->where('purchase_order_no', $purchase_order_no);
        return $this->db->count_all_results($this->tables['purchase_order']) > 0;
    }
    /**
     * Storing purchase order, product purchase order and stock into the database
     *
     * @return bool
     * @author Nazmul on 22nd November 2014
     * */
    public function add_purchase_order($additional_data, $purchased_product_list, $add_stock_list, $supplier_payment_data, $supplier_transaction_info_array)
    {
        $this->trigger_events('pre_add_purchase_order');
        if ($this->purchase_order_no_check($additional_data['purchase_order_no'])) {
            $this->set_error('add_purchase_order_duplicate_purchase_order_no');
            return FALSE;
        }
        $this->db->trans_begin();
        //filter out any data passed that doesnt have a matching column in the users table
        $purchase_data = $this->_filter_data($this->tables['purchase_order'], $additional_data);

        $this->db->insert($this->tables['purchase_order'], $purchase_data);

        $id = $this->db->insert_id();
        if($id > 0)
        {
            if($supplier_payment_data['amount'] > 0)
            {
                $this->db->insert($this->tables['supplier_payment_info'], $supplier_payment_data);
            }            
            $this->db->insert_batch($this->tables['supplier_transaction_info'], $supplier_transaction_info_array);
            $this->db->insert_batch($this->tables['product_purchase_order'], $purchased_product_list);
            if( !empty($add_stock_list) )
            {
                $this->db->insert_batch($this->tables['stock_info'], $add_stock_list);            
            }            
        }

        $this->trigger_events('post_add_purchase_order');
        $this->db->trans_commit();
        return (isset($id)) ? $id : FALSE;
    }
    public function raise_purchase_order($additional_data, $new_purchased_product_list, $existing_purchased_product_list, $add_stock_list, $update_stock_list, $supplier_transaction_info_array)
    {
        $this->trigger_events('pre_raise_purchase_order');
        $this->db->trans_begin();
        //filter out any data passed that doesnt have a matching column in the users table
        $purchase_data = $this->_filter_data($this->tables['purchase_order'], $additional_data);
        $this->db->update($this->tables['purchase_order'], $purchase_data, array('purchase_order_no' => $purchase_data['purchase_order_no'], 'shop_id' => $purchase_data['shop_id'] ));
        
        if( !empty($new_purchased_product_list) )
        {
            $this->db->insert_batch($this->tables['product_purchase_order'], $new_purchased_product_list);         
        }
        if( !empty($add_stock_list) )
        {
            $this->db->insert_batch($this->tables['stock_info'], $add_stock_list);            
        }
        if( !empty($supplier_transaction_info_array) )
        {
            $this->db->insert_batch($this->tables['supplier_transaction_info'], $supplier_transaction_info_array);       
        }
        
        foreach($existing_purchased_product_list as $purchased_product_list)
        {
            $this->db->update($this->tables['product_purchase_order'], $purchased_product_list, array('product_id' => $purchased_product_list['product_id'], 'purchase_order_no' => $purchased_product_list['purchase_order_no'], 'shop_id' => $purchased_product_list['shop_id'] ));
        }
        
        foreach($update_stock_list as $stock_info)
        {
            $this->db->update($this->tables['stock_info'], $stock_info, array('product_id' => $stock_info['product_id'], 'purchase_order_no' => $stock_info['purchase_order_no'], 'shop_id' => $stock_info['shop_id'] ));
        }
        $this->db->trans_commit();
        return TRUE;
    }
    
    public function return_purchase_order($additional_data, $existing_purchased_product_list, $update_stock_list, $supplier_transaction_info_array, $return_balance_info)
    {
        $this->trigger_events('pre_return_purchase_order');
        $this->db->trans_begin();
        //filter out any data passed that doesnt have a matching column in the users table
        $purchase_data = $this->_filter_data($this->tables['purchase_order'], $additional_data);
        $this->db->update($this->tables['purchase_order'], $purchase_data, array('purchase_order_no' => $purchase_data['purchase_order_no'], 'shop_id' => $purchase_data['shop_id'] ));
        
        if( !empty($return_balance_info) )
        {
            $return_balance_info = $this->_filter_data($this->tables['supplier_returned_payment_info'], $return_balance_info);
            $this->db->insert($this->tables['supplier_returned_payment_info'], $return_balance_info);         
        }
        if( !empty($supplier_transaction_info_array) )
        {
            $this->db->insert_batch($this->tables['supplier_transaction_info'], $supplier_transaction_info_array);       
        }
        
        foreach($existing_purchased_product_list as $purchased_product_list)
        {
            $this->db->update($this->tables['product_purchase_order'], $purchased_product_list, array('product_id' => $purchased_product_list['product_id'], 'purchase_order_no' => $purchased_product_list['purchase_order_no'], 'shop_id' => $purchased_product_list['shop_id'] ));
        }
        
        foreach($update_stock_list as $stock_info)
        {
            $this->db->update($this->tables['stock_info'], $stock_info, array('product_id' => $stock_info['product_id'], 'purchase_order_no' => $stock_info['purchase_order_no'], 'shop_id' => $stock_info['shop_id'] ));
        }
        $this->db->trans_commit();
        return TRUE;
    }
    
    public function get_purchase_order_info($purchase_id = 0, $purchase_order_no = 0, $shop_id = 0)
    {
        if( $purchase_id != 0 )
        {
            $this->db->where($this->tables['purchase_order'].'.id', $purchase_id);
        }
        if( $purchase_order_no != 0 )
        {
            $this->db->where($this->tables['purchase_order'].'.purchase_order_no', $purchase_order_no);
        }
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }        
        $this->db->where($this->tables['purchase_order'].'.shop_id', $shop_id);        
        return $this->db->select('*')
                    ->from($this->tables['purchase_order'])
                    ->get(); 
    }
    public function get_purchase_order_list($shop_id)
    {
        $this->db->where($this->tables['purchase_order'].'.shop_id', $shop_id);
        return $this->db->select('*')
                    ->from($this->tables['purchase_order'])
                    ->get(); 
    }
    
    public function get_product_list_purchase_order($purchase_order_no, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['purchase_order'].'.purchase_order_no', $purchase_order_no);
        $this->db->where($this->tables['purchase_order'].'.shop_id', $shop_id);
        return $this->db->select($this->tables['product_purchase_order'].'.*')
                    ->from($this->tables['purchase_order'])
                    ->join($this->tables['product_purchase_order'], $this->tables['purchase_order'].'.purchase_order_no='.$this->tables['product_purchase_order'].'.purchase_order_no')
                    ->get();
    }
    
    public function get_purchase_order_no_product_list($purchase_order_no_list, $shop_id)
    {
        $this->db->where($this->tables['purchase_order'].'.shop_id', $shop_id);
        $this->db->where_in($this->tables['purchase_order'].'.purchase_order_no', $purchase_order_no_list);
        return $this->db->select($this->tables['purchase_order'].'.id as purchase_order_id,'.$this->tables['product_purchase_order'].'.id as product_purchase_order_id,'.$this->tables['purchase_order'].'.purchase_order_no as purchase_order_no,'. $this->tables['product_purchase_order'].'.product_id,'. $this->tables['product_purchase_order'].'.available_quantity')
                    ->from($this->tables['purchase_order'])
                    ->join($this->tables['product_purchase_order'], $this->tables['purchase_order'].'.id='.$this->tables['product_purchase_order'].'.purchase_order_id')
                    ->get();  
    }
    
    public function get_total_purchase_price($supplier_id)
    {
        $shop_id = $this->session->userdata('shop_id');
        $this->db->where('shop_id', $shop_id);
        $this->db->where('supplier_id', $supplier_id);
        return $this->db->select('SUM(total) as total_purchase_price')
                            ->from($this->tables['purchase_order'])
                            ->get();
    }
    
    public function get_next_purchase_order_no()
    {
        $query = 'SELECT MAX(purchase_order_no) as purchase_order_no FROM purchase_order';
        return $this->db->query($query);
    }
}
