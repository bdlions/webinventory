<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Stock Model
 * Added in Class Diagram
 * Requirements: PHP5 or above
 *
 */
class Stock_model extends Ion_auth_model 
{    
    public function __construct() {
        parent::__construct();        
    }

    /*
     * This method will return current stock info
     * @param $product_id, product id
     * @param $purchase_order_no, purchase order number
     * @param $shop_id, shop id
     * @Author Nazmul
     */
    public function search_stocks($product_id = 0, $purchase_order_no = '', $shop_id = 0)
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
        $this->db->group_by($this->tables['stock_info'].'.purchase_order_no');
        $this->db->group_by($this->tables['stock_info'].'.product_id');
        return $this->db->select($this->tables['stock_info'].'.product_id,'.$this->tables['stock_info'].'.purchase_order_no,'.$this->tables['product_info'].'.name as product_name,'.$this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name,'.$this->tables['product_purchase_order'].'.unit_price,sum(stock_in)-sum(stock_out) as current_stock,'.$this->tables['product_unit_category'].'.description as unit_category')
                    ->from($this->tables['stock_info'])
                    ->join($this->tables['purchase_order'], $this->tables['purchase_order'].'.purchase_order_no='.$this->tables['stock_info'].'.purchase_order_no AND '.$this->tables['purchase_order'].'.shop_id ='.$this->tables['stock_info'].'.shop_id')
                    ->join($this->tables['product_purchase_order'], $this->tables['product_purchase_order'].'.purchase_order_no='.$this->tables['stock_info'].'.purchase_order_no AND '.$this->tables['product_purchase_order'].'.product_id='.$this->tables['stock_info'].'.product_id')
                    ->join($this->tables['product_info'], $this->tables['stock_info'].'.product_id='.$this->tables['product_info'].'.id ')
                    ->join($this->tables['product_unit_category'], $this->tables['product_unit_category'].'.id='.$this->tables['product_info'].'.unit_category_id ')
                    ->join($this->tables['suppliers'], $this->tables['suppliers'].'.id='.$this->tables['purchase_order'].'.supplier_id')
                    ->join($this->tables['users'], $this->tables['users'].'.id='.$this->tables['suppliers'].'.user_id')
                    ->get(); 
    }
    
    /*
     * This method will return current warehouse stock info
     * @param $product_id, product id
     * @param $purchase_order_no, purchase order number
     * @param $shop_id, shop id
     * @Author Nazmul on 18th January 2015
     */
    public function search_warehouse_stocks($product_id = 0, $purchase_order_no = '', $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['warehouse_stock_info'].'.shop_id', $shop_id);
        if( $product_id != 0 )
        {
            $this->db->where($this->tables['warehouse_stock_info'].'.product_id', $product_id);
        }
        if( !empty($purchase_order_no) )
        {
            $this->db->where($this->tables['warehouse_stock_info'].'.purchase_order_no', $purchase_order_no);
        }
        $this->db->group_by($this->tables['warehouse_stock_info'].'.purchase_order_no');
        $this->db->group_by($this->tables['warehouse_stock_info'].'.product_id');
        return $this->db->select($this->tables['warehouse_stock_info'].'.product_id,'.$this->tables['warehouse_stock_info'].'.purchase_order_no,'.$this->tables['product_info'].'.name as product_name,'.$this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name,'.$this->tables['warehouse_product_purchase_order'].'.unit_price,sum(stock_in)-sum(stock_out) as current_stock,'.$this->tables['product_unit_category'].'.description as unit_category')
                    ->from($this->tables['warehouse_stock_info'])
                    ->join($this->tables['purchase_order'], $this->tables['purchase_order'].'.purchase_order_no='.$this->tables['warehouse_stock_info'].'.purchase_order_no AND '.$this->tables['purchase_order'].'.shop_id ='.$this->tables['warehouse_stock_info'].'.shop_id')
                    ->join($this->tables['warehouse_product_purchase_order'], $this->tables['warehouse_product_purchase_order'].'.purchase_order_no='.$this->tables['warehouse_stock_info'].'.purchase_order_no AND '.$this->tables['warehouse_product_purchase_order'].'.product_id='.$this->tables['warehouse_stock_info'].'.product_id')
                    ->join($this->tables['product_info'], $this->tables['warehouse_stock_info'].'.product_id='.$this->tables['product_info'].'.id ')
                    ->join($this->tables['product_unit_category'], $this->tables['product_unit_category'].'.id='.$this->tables['product_info'].'.unit_category_id ')
                    ->join($this->tables['suppliers'], $this->tables['suppliers'].'.id='.$this->tables['purchase_order'].'.supplier_id')
                    ->join($this->tables['users'], $this->tables['users'].'.id='.$this->tables['suppliers'].'.user_id')
                    ->get(); 
    }
    
    /*
     * This method will return supplier purchase list
     * @param $supplier_id, supplier id
     * @param $shop_id, shop id
     * @Author Nazmul on 27th January 2015
     */
    public function get_supplier_purchase_list($supplier_id, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['warehouse_stock_info'].'.shop_id', $shop_id);
        $this->db->where($this->tables['suppliers'].'.id', $supplier_id);
        $this->db->where_in($this->tables['warehouse_stock_info'].'.transaction_category_id', array(WAREHOUSE_STOCK_PURCHASE_IN, WAREHOUSE_STOCK_PURCHASE_PARTIAL_IN, WAREHOUSE_STOCK_PURCHASE_PARTIAL_OUT));
        $this->db->group_by($this->tables['warehouse_stock_info'].'.purchase_order_no');
        $this->db->group_by($this->tables['warehouse_stock_info'].'.product_id');
        return $this->db->select($this->tables['warehouse_stock_info'].'.product_id,'.$this->tables['warehouse_stock_info'].'.purchase_order_no,'.$this->tables['product_info'].'.name as product_name,'.$this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name,'.$this->tables['warehouse_product_purchase_order'].'.unit_price,sum(stock_in)-sum(stock_out) as total_purchased')
                    ->from($this->tables['warehouse_stock_info'])
                    ->join($this->tables['purchase_order'], $this->tables['purchase_order'].'.purchase_order_no='.$this->tables['warehouse_stock_info'].'.purchase_order_no AND '.$this->tables['purchase_order'].'.shop_id ='.$this->tables['warehouse_stock_info'].'.shop_id')
                    ->join($this->tables['warehouse_product_purchase_order'], $this->tables['warehouse_product_purchase_order'].'.purchase_order_no='.$this->tables['warehouse_stock_info'].'.purchase_order_no AND '.$this->tables['warehouse_product_purchase_order'].'.product_id='.$this->tables['warehouse_stock_info'].'.product_id')
                    ->join($this->tables['product_info'], $this->tables['warehouse_stock_info'].'.product_id='.$this->tables['product_info'].'.id ')
                    ->join($this->tables['suppliers'], $this->tables['suppliers'].'.id='.$this->tables['purchase_order'].'.supplier_id')
                    ->join($this->tables['users'], $this->tables['users'].'.id='.$this->tables['suppliers'].'.user_id')
                    ->get(); 
    }
    /*
     * This method will return customer purchase list
     * @param $customer_id, customer id
     * @param $shop_id, shop id
     * @Author Nazmul on 27th January 2015
     */
    public function get_customer_purchase_list($customer_id, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['stock_info'].'.shop_id', $shop_id);
        $this->db->where($this->tables['customers'].'.id', $customer_id);
        $this->db->where_in($this->tables['stock_info'].'.transaction_category_id', array(STOCK_SALE_IN, STOCK_SALE_PARTIAL_OUT, STOCK_SALE_DELETE));
        $this->db->group_by($this->tables['stock_info'].'.sale_order_no');
        $this->db->group_by($this->tables['stock_info'].'.purchase_order_no');
        $this->db->group_by($this->tables['stock_info'].'.product_id');
        return $this->db->select($this->tables['stock_info'].'.product_id,'.$this->tables['stock_info'].'.purchase_order_no,'.$this->tables['stock_info'].'.sale_order_no,'.$this->tables['product_info'].'.name as product_name,'.$this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name,'.$this->tables['product_sale_order'].'.unit_price,sum(stock_out)-sum(stock_in) as total_sale')
                    ->from($this->tables['stock_info'])
                    ->join($this->tables['sale_order'], $this->tables['sale_order'].'.sale_order_no='.$this->tables['stock_info'].'.sale_order_no AND '.$this->tables['sale_order'].'.shop_id ='.$this->tables['stock_info'].'.shop_id')
                    ->join($this->tables['product_sale_order'], $this->tables['product_sale_order'].'.purchase_order_no='.$this->tables['stock_info'].'.purchase_order_no AND '.$this->tables['product_sale_order'].'.sale_order_no='.$this->tables['stock_info'].'.sale_order_no AND '.$this->tables['product_sale_order'].'.product_id='.$this->tables['stock_info'].'.product_id')
                    ->join($this->tables['product_info'], $this->tables['stock_info'].'.product_id='.$this->tables['product_info'].'.id ')
                    ->join($this->tables['customers'], $this->tables['customers'].'.id='.$this->tables['sale_order'].'.customer_id')
                    ->join($this->tables['users'], $this->tables['users'].'.id='.$this->tables['customers'].'.user_id')
                    ->get(); 
    }
    
    /*
     * This method will return all showroom transactions under a lot no
     * @param $purchase_order_no, purchase order no
     * @param $shop_id, shop id
     * @Author Nazmul on 27th January 2015
     */
    public function get_showroom_purchase_transactions($purchase_order_no, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['stock_info'].'.purchase_order_no', $purchase_order_no);
        $this->db->where($this->tables['stock_info'].'.shop_id', $shop_id);
        $this->db->where_in($this->tables['stock_info'].'.transaction_category_id', array(STOCK_PURCHASE_PARTIAL_IN, STOCK_PURCHASE_PARTIAL_OUT));
        $this->db->order_by($this->tables['stock_info'].'.created_on','desc');
        return $this->db->select($this->tables['stock_info'].'.product_id,'.$this->tables['stock_info'].'.purchase_order_no,'.$this->tables['stock_info'].'.stock_in,'.$this->tables['stock_info'].'.stock_out,'.$this->tables['stock_info'].'.transaction_category_id,'.$this->tables['stock_info'].'.created_on,'.$this->tables['stock_transaction_category'].'.description as transaction_type,'.$this->tables['product_info'].'.name as product_name,'.$this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name,'.$this->tables['product_purchase_order'].'.unit_price')
                    ->from($this->tables['stock_info'])
                    ->join($this->tables['stock_transaction_category'], $this->tables['stock_info'].'.transaction_category_id='.$this->tables['stock_transaction_category'].'.id')
                    ->join($this->tables['purchase_order'], $this->tables['purchase_order'].'.purchase_order_no='.$this->tables['stock_info'].'.purchase_order_no AND '.$this->tables['purchase_order'].'.shop_id ='.$this->tables['stock_info'].'.shop_id')
                    ->join($this->tables['product_purchase_order'], $this->tables['product_purchase_order'].'.purchase_order_no='.$this->tables['stock_info'].'.purchase_order_no AND '.$this->tables['product_purchase_order'].'.product_id='.$this->tables['stock_info'].'.product_id')
                    ->join($this->tables['product_info'], $this->tables['stock_info'].'.product_id='.$this->tables['product_info'].'.id ')
                    ->join($this->tables['suppliers'], $this->tables['suppliers'].'.id='.$this->tables['purchase_order'].'.supplier_id')
                    ->join($this->tables['users'], $this->tables['users'].'.id='.$this->tables['suppliers'].'.user_id')
                    ->get(); 
    }
}
