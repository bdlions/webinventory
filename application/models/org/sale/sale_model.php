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
    public function add_sale_order($additional_data, $sale_product_list, $stock_out_list, $customer_payment_data_array, $customer_transaction_info_array)
    {
        $this->trigger_events('pre_add_sale_order');
        //filter out any data passed that doesnt have a matching column in the users table
        $sale_data = $this->_filter_data($this->tables['sale_order'], $additional_data);
        $this->db->trans_begin();
        $this->db->insert($this->tables['sale_order'], $sale_data);

        $id = $this->db->insert_id();
        if($id > 0)
        {
            if(!empty($customer_payment_data_array))
            {
                $this->db->insert_batch($this->tables['customer_payment_info'], $customer_payment_data_array);
            }
            if(!empty($customer_transaction_info_array))
            {
                $this->db->insert_batch($this->tables['customer_transaction_info'], $customer_transaction_info_array);
            }
            if(!empty($sale_product_list))
            {
                $this->db->insert_batch($this->tables['product_sale_order'], $sale_product_list);
            }
            if( !empty($stock_out_list) )
            {
                $this->db->insert_batch($this->tables['stock_info'], $stock_out_list);            
            }
        }
        $this->db->trans_commit();
        $this->trigger_events('post_add_sale_order');
        return (isset($id)) ? $id : FALSE;
    }
    
    public function return_sale_order($additional_data, $add_stock_list, $customer_transaction_info_array, $return_balance_info)
    {
        $this->trigger_events('pre_return_sale_order');
        $this->db->trans_begin();
        //filter out any data passed that doesnt have a matching column in the users table
        $sale_data = $this->_filter_data($this->tables['sale_order'], $additional_data);
        $this->db->update($this->tables['sale_order'], $sale_data, array('sale_order_no' => $sale_data['sale_order_no'], 'shop_id' => $sale_data['shop_id'] ));
        if ($this->db->trans_status() === FALSE) 
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        if( !empty($return_balance_info) )
        {
            $return_balance_info = $this->_filter_data($this->tables['customer_returned_payment_info'], $return_balance_info);
            $this->db->insert($this->tables['customer_returned_payment_info'], $return_balance_info);         
        }
        if( !empty($customer_transaction_info_array) )
        {
            $this->db->insert_batch($this->tables['customer_transaction_info'], $customer_transaction_info_array);       
        }
        if( !empty($add_stock_list) )
        {
            $this->db->insert_batch($this->tables['stock_info'], $add_stock_list);            
        }        
        $this->db->trans_commit();
        return TRUE;
    }
    
    public function get_sale_info($sale_order_no, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['sale_order'].'.sale_order_no', $sale_order_no);
        $this->db->where($this->tables['sale_order'].'.shop_id', $shop_id);
        return $this->db->select('*')
                    ->from($this->tables['sale_order'])
                    ->get();
    }
    
    public function get_sale_product_list($sale_order_no, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['product_sale_order'].'.sale_order_no', $sale_order_no);
        $this->db->where($this->tables['product_sale_order'].'.shop_id', $shop_id);
        return $this->db->select($this->tables['product_sale_order'].'.product_id,'.$this->tables['product_sale_order'].'.purchase_order_no,'.$this->tables['product_sale_order'].'.unit_price,'.$this->tables['product_info'].'.name as product_name')
                    ->from($this->tables['product_sale_order'])
                    ->join($this->tables['product_info'], $this->tables['product_info'].'.id='.$this->tables['product_sale_order'].'.product_id')
                    ->get();
    }
    
    public function get_sale_current_product_quantity_list($sale_order_no, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['stock_info'].'.shop_id', $shop_id);
        $this->db->where($this->tables['stock_info'].'.sale_order_no', $sale_order_no);
        $this->db->group_by($this->tables['stock_info'].'.sale_order_no');
        $this->db->group_by($this->tables['stock_info'].'.product_id');
        return $this->db->select($this->tables['stock_info'].'.product_id,'.$this->tables['stock_info'].'.sale_order_no, sum(stock_out)-sum(stock_in) as sale_quantity')
                    ->from($this->tables['stock_info'])
                    ->join($this->tables['product_sale_order'], $this->tables['product_sale_order'].'.sale_order_no='.$this->tables['stock_info'].'.sale_order_no AND '.$this->tables['product_sale_order'].'.product_id='.$this->tables['stock_info'].'.product_id')
                    ->get();
    }
    
    public function get_sale_detail($sale_order_no, $shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['stock_info'].'.shop_id', $shop_id);
        $this->db->where($this->tables['stock_info'].'.sale_order_no', $sale_order_no);
        $this->db->where_in($this->tables['stock_info'].'.transaction_category_id', array(STOCK_SALE_IN, STOCK_SALE_PARTIAL_OUT, STOCK_SALE_DELETE));
        $this->db->group_by($this->tables['stock_info'].'.sale_order_no');
        $this->db->group_by($this->tables['stock_info'].'.product_id');
        return $this->db->select($this->tables['stock_info'].'.product_id,'.$this->tables['stock_info'].'.purchase_order_no,'.$this->tables['stock_info'].'.sale_order_no,'.$this->tables['product_info'].'.name as product_name,'.$this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name,'.$this->tables['product_sale_order'].'.unit_price,sum(stock_out)-sum(stock_in) as total_sale,'.$this->tables['customers'].'.id as customer_id')
                    ->from($this->tables['stock_info'])
                    ->join($this->tables['product_info'], $this->tables['stock_info'].'.product_id='.$this->tables['product_info'].'.id ')
                    ->join($this->tables['sale_order'], $this->tables['sale_order'].'.sale_order_no='.$this->tables['stock_info'].'.sale_order_no AND '.$this->tables['sale_order'].'.shop_id='.$shop_id)
                    ->join($this->tables['product_sale_order'], $this->tables['product_sale_order'].'.sale_order_no='.$this->tables['stock_info'].'.sale_order_no AND '.$this->tables['product_sale_order'].'.product_id='.$this->tables['stock_info'].'.product_id')
                    ->join($this->tables['customers'], $this->tables['customers'].'.id='.$this->tables['sale_order'].'.customer_id')
                    ->join($this->tables['users'], $this->tables['users'].'.id='.$this->tables['customers'].'.user_id')
                    ->get(); 
    }
    
    /*public function get_all_sales($shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        return $this->db->select($this->tables['product_info'].'.name,'. $this->tables['product_sale_order'].'.quantity,'. $this->tables['product_sale_order'].'.unit_price as sale_unit_price,'.$this->tables['product_sale_order'].'.discount,'.$this->tables['product_sale_order'].'.sub_total as total_sale_price,'.$this->tables['product_purchase_order'].'.unit_price as purchase_unit_price,'.$this->tables['product_purchase_order'].'.purchase_order_no')
                    ->from($this->tables['product_sale_order'])
                    ->join($this->tables['product_info'], $this->tables['product_info'].'.id='.$this->tables['product_sale_order'].'.product_id')
                    ->join($this->tables['product_purchase_order'], $this->tables['product_purchase_order'].'.purchase_order_no='.$this->tables['product_sale_order'].'.purchase_order_no AND '.$this->tables['product_purchase_order'].'.product_id='.$this->tables['product_sale_order'].'.product_id')
                    ->where($this->tables['product_sale_order'].'.shop_id',$shop_id)
                    ->get();  
    }*/
    
    public function get_daily_sales($time, $product_id = 0, $shop_id = 0 )
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['stock_info'].'.shop_id', $shop_id);
        $this->db->where($this->tables['sale_order'].'.created_on >=',$time);
        if( $product_id != 0 )
        {
            $this->db->where($this->tables['stock_info'].'.product_id', $product_id);
        }
        $this->db->where_in($this->tables['stock_info'].'.transaction_category_id', array(STOCK_SALE_IN, STOCK_SALE_PARTIAL_OUT, STOCK_SALE_DELETE));
        $this->db->group_by($this->tables['stock_info'].'.sale_order_no');
        $this->db->group_by($this->tables['stock_info'].'.purchase_order_no');
        $this->db->group_by($this->tables['stock_info'].'.product_id');
        $this->db->order_by($this->tables['sale_order'].'.created_on','desc');
        $this->db->order_by($this->tables['stock_info'].'.purchase_order_no');
        return $this->db->select($this->tables['sale_order'].'.created_on,'.$this->tables['product_sale_order'].'.purchase_order_no,'.$this->tables['product_info'].'.name as product_name,sum(stock_out)-sum(stock_in) as total_sale,'.$this->tables['product_sale_order'].'.unit_price as sale_unit_price,'.$this->tables['product_purchase_order'].'.unit_price as purchase_unit_price,'.$this->tables['sale_order'].'.created_by, users_salesman.first_name as salesman_first_name, users_salesman.last_name as salesman_last_name, users_customers.first_name as customer_first_name, users_customers.last_name as customer_last_name,'.$this->tables['customers'].'.card_no,'.$this->tables['customers'].'.id as customer_id,'.$this->tables['stock_info'].'.sale_order_no,'.$this->tables['product_unit_category'].'.description as category_unit')
                    ->from($this->tables['stock_info'])
                    ->join($this->tables['sale_order'], $this->tables['sale_order'].'.sale_order_no='.$this->tables['stock_info'].'.sale_order_no')
                    ->join($this->tables['product_sale_order'], $this->tables['product_sale_order'].'.purchase_order_no='.$this->tables['stock_info'].'.purchase_order_no AND '.$this->tables['product_sale_order'].'.sale_order_no='.$this->tables['stock_info'].'.sale_order_no AND '.$this->tables['product_sale_order'].'.product_id='.$this->tables['stock_info'].'.product_id')
                    ->join($this->tables['product_purchase_order'], $this->tables['product_purchase_order'].'.purchase_order_no='.$this->tables['stock_info'].'.purchase_order_no AND '.$this->tables['product_purchase_order'].'.product_id='.$this->tables['stock_info'].'.product_id')
                    ->join($this->tables['product_info'], $this->tables['stock_info'].'.product_id='.$this->tables['product_info'].'.id ')
                    ->join($this->tables['product_unit_category'], $this->tables['product_unit_category'].'.id='.$this->tables['product_info'].'.unit_category_id ')
                    ->join($this->tables['customers'], $this->tables['customers'].'.id='.$this->tables['sale_order'].'.customer_id')
                    ->join($this->tables['users'].' AS users_customers', 'users_customers.id='.$this->tables['customers'].'.user_id')
                    ->join($this->tables['users'].' AS users_salesman', 'users_salesman.id='.$this->tables['sale_order'].'.created_by')
                    ->get();        
    }
    
    /*public function get_daily_sales($time, $shop_id = 0, $product_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        if( $product_id != 0)
        {
            $this->db->where($this->tables['product_sale_order'].'.product_id',$product_id);
        }
        $this->db->where($this->tables['product_sale_order'].'.created_on >=',$time);
        $this->db->where($this->tables['product_sale_order'].'.shop_id',$shop_id);
        return $this->db->select($this->tables['product_sale_order'].'.created_on,'.$this->tables['product_sale_order'].'.purchase_order_no,'.$this->tables['product_sale_order'].'.sale_order_no,'.$this->tables['product_info'].'.name as product_name,'. $this->tables['product_sale_order'].'.quantity,'. $this->tables['product_sale_order'].'.unit_price as sale_unit_price,'.$this->tables['product_sale_order'].'.sub_total as total_sale_price,'.$this->tables['product_purchase_order'].'.unit_price as purchase_unit_price,'.$this->tables['customers'].'.card_no,'.$this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name')
                    ->from($this->tables['product_sale_order'])
                    ->join($this->tables['product_info'], $this->tables['product_info'].'.id='.$this->tables['product_sale_order'].'.product_id')
                    ->join($this->tables['product_purchase_order'], $this->tables['product_purchase_order'].'.purchase_order_no='.$this->tables['product_sale_order'].'.purchase_order_no AND '.$this->tables['product_purchase_order'].'.product_id='.$this->tables['product_sale_order'].'.product_id')
                    ->join($this->tables['sale_order'], $this->tables['sale_order'].'.sale_order_no='.$this->tables['product_sale_order'].'.sale_order_no')
                    ->join($this->tables['customers'], $this->tables['customers'].'.id='.$this->tables['sale_order'].'.customer_id')
                    ->join($this->tables['users'], $this->tables['users'].'.id='.$this->tables['sale_order'].'.created_by')
                    ->get();  
    }*/
    
    /*public function get_user_sales($start_date, $end_date, $user_id = '' , $product_id = '', $shop_id = '')
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
    }*/
    public function get_user_sales($start_time, $end_time, $user_id = 0 , $product_id = '', $shop_id = '')
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['stock_info'].'.shop_id', $shop_id);
        if( $user_id > 0)
        {
            $this->db->where($this->tables['sale_order'].'.created_by', $user_id);
        }
        if(!empty($product_id) && $product_id > 0)
        {
            $this->db->where($this->tables['stock_info'].'.product_id', $product_id);
        }
        $this->db->where($this->tables['sale_order'].'.created_on >=', $start_time);
        $this->db->where($this->tables['sale_order'].'.created_on <=', $end_time);
        
        
        $this->db->where_in($this->tables['stock_info'].'.transaction_category_id', array(STOCK_SALE_IN, STOCK_SALE_PARTIAL_OUT, STOCK_SALE_DELETE));
        $this->db->group_by($this->tables['stock_info'].'.sale_order_no');
        $this->db->group_by($this->tables['stock_info'].'.product_id');
        $this->db->order_by($this->tables['sale_order'].'.created_on','desc');
        return $this->db->select($this->tables['sale_order'].'.created_on,'.$this->tables['product_sale_order'].'.purchase_order_no,'.$this->tables['product_info'].'.name as product_name,sum(stock_out)-sum(stock_in) as total_sale,'.$this->tables['product_sale_order'].'.unit_price as sale_unit_price,'.$this->tables['product_purchase_order'].'.unit_price as purchase_unit_price,'.$this->tables['sale_order'].'.created_by, users_salesman.first_name as salesman_first_name, users_salesman.last_name as salesman_last_name, users_customers.first_name as customer_first_name, users_customers.last_name as customer_last_name,'.$this->tables['customers'].'.card_no,'.$this->tables['customers'].'.id customer_id,'.$this->tables['stock_info'].'.sale_order_no,'.$this->tables['product_unit_category'].'.description as category_unit')
                    ->from($this->tables['stock_info'])
                    ->join($this->tables['product_info'], $this->tables['stock_info'].'.product_id='.$this->tables['product_info'].'.id ')
                    ->join($this->tables['product_unit_category'], $this->tables['product_unit_category'].'.id='.$this->tables['product_info'].'.unit_category_id ')
                    ->join($this->tables['sale_order'], $this->tables['sale_order'].'.sale_order_no='.$this->tables['stock_info'].'.sale_order_no AND '.$this->tables['sale_order'].'.shop_id='.$shop_id)
                    ->join($this->tables['product_sale_order'], $this->tables['product_sale_order'].'.sale_order_no='.$this->tables['stock_info'].'.sale_order_no AND '.$this->tables['product_sale_order'].'.product_id='.$this->tables['stock_info'].'.product_id')
                    ->join($this->tables['product_purchase_order'], $this->tables['product_purchase_order'].'.purchase_order_no='.$this->tables['stock_info'].'.purchase_order_no AND '.$this->tables['product_purchase_order'].'.product_id='.$this->tables['stock_info'].'.product_id')
                    ->join($this->tables['customers'], $this->tables['customers'].'.id='.$this->tables['sale_order'].'.customer_id')
                    ->join($this->tables['users'].' AS users_customers', 'users_customers.id='.$this->tables['customers'].'.user_id')
                    ->join($this->tables['users'].' AS users_salesman', 'users_salesman.id='.$this->tables['sale_order'].'.created_by')
                    ->get();
    }
    
    public function get_user_sales_by_purchase_order_no($start_time, $end_time, $purchase_order_no = 0 , $shop_id = '')
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['stock_info'].'.shop_id', $shop_id);
        if( $purchase_order_no > 0)
        {
            $this->db->where($this->tables['product_sale_order'].'.purchase_order_no', $purchase_order_no);
        }
        $this->db->where($this->tables['sale_order'].'.created_on >=', $start_time);
        $this->db->where($this->tables['sale_order'].'.created_on <=', $end_time);
        
        
        $this->db->where_in($this->tables['stock_info'].'.transaction_category_id', array(STOCK_SALE_IN, STOCK_SALE_PARTIAL_OUT, STOCK_SALE_DELETE));
        $this->db->group_by($this->tables['stock_info'].'.sale_order_no');
        $this->db->group_by($this->tables['stock_info'].'.product_id');
        $this->db->order_by($this->tables['sale_order'].'.created_on','desc');
        return $this->db->select($this->tables['sale_order'].'.created_on,'.$this->tables['product_sale_order'].'.purchase_order_no,'.$this->tables['product_info'].'.name as product_name,sum(stock_out)-sum(stock_in) as total_sale,'.$this->tables['product_sale_order'].'.unit_price as sale_unit_price,'.$this->tables['product_purchase_order'].'.unit_price as purchase_unit_price,'.$this->tables['sale_order'].'.created_by, users_salesman.first_name as salesman_first_name, users_salesman.last_name as salesman_last_name, users_customers.first_name as customer_first_name, users_customers.last_name as customer_last_name,'.$this->tables['customers'].'.card_no,'.$this->tables['customers'].'.id customer_id,'.$this->tables['stock_info'].'.sale_order_no,'.$this->tables['product_unit_category'].'.description as category_unit')
                    ->from($this->tables['stock_info'])
                    ->join($this->tables['product_info'], $this->tables['stock_info'].'.product_id='.$this->tables['product_info'].'.id ')
                    ->join($this->tables['product_unit_category'], $this->tables['product_unit_category'].'.id='.$this->tables['product_info'].'.unit_category_id ')
                    ->join($this->tables['sale_order'], $this->tables['sale_order'].'.sale_order_no='.$this->tables['stock_info'].'.sale_order_no AND '.$this->tables['sale_order'].'.shop_id='.$shop_id)
                    ->join($this->tables['product_sale_order'], $this->tables['product_sale_order'].'.sale_order_no='.$this->tables['stock_info'].'.sale_order_no AND '.$this->tables['product_sale_order'].'.product_id='.$this->tables['stock_info'].'.product_id')
                    ->join($this->tables['product_purchase_order'], $this->tables['product_purchase_order'].'.purchase_order_no='.$this->tables['stock_info'].'.purchase_order_no AND '.$this->tables['product_purchase_order'].'.product_id='.$this->tables['stock_info'].'.product_id')
                    ->join($this->tables['customers'], $this->tables['customers'].'.id='.$this->tables['sale_order'].'.customer_id')
                    ->join($this->tables['users'].' AS users_customers', 'users_customers.id='.$this->tables['customers'].'.user_id')
                    ->join($this->tables['users'].' AS users_salesman', 'users_salesman.id='.$this->tables['sale_order'].'.created_by')
                    ->get();
    }
    
    public function get_sale_order_info($sale_id = 0, $sale_order_no = 0)
    {
        if( $sale_id != 0)
        {
            $this->db->where($this->tables['sale_order'].'.id', $sale_id);
        }
        if( $sale_order_no != 0)
        {
            $this->db->where($this->tables['sale_order'].'.sale_order_no', $sale_order_no);
        }
        
        return $this->db->select('*')
                    ->from($this->tables['sale_order'])
                    ->get(); 
    }
    
    /*public function get_user_sales_by_card_no($start_date, $end_date, $card_no = '' , $shop_id = '')
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        if(!empty($card_no))
        {
            $this->db->where($this->tables['customers'].'.card_no', $card_no);
        }
        $end_date = date('Y-m-d', strtotime('+1 day', strtotime($end_date)));
        $this->db->where($this->tables['product_sale_order'].'.created_date >=', $start_date);
        $this->db->where($this->tables['product_sale_order'].'.created_date <=', $end_date);
        return $this->db->select($this->tables['product_info'].'.name,'. $this->tables['product_sale_order'].'.quantity,'. $this->tables['product_sale_order'].'.unit_price as sale_unit_price,'.$this->tables['product_sale_order'].'.discount,'.$this->tables['product_sale_order'].'.sub_total as total_sale_price,'.$this->tables['product_purchase_order'].'.unit_price as purchase_unit_price,'.$this->tables['product_purchase_order'].'.purchase_order_no')
                    ->from($this->tables['product_sale_order'])
                    ->join($this->tables['product_info'], $this->tables['product_info'].'.id='.$this->tables['product_sale_order'].'.product_id')
                    ->join($this->tables['product_purchase_order'], $this->tables['product_purchase_order'].'.purchase_order_no='.$this->tables['product_sale_order'].'.purchase_order_no AND '.$this->tables['product_purchase_order'].'.product_id='.$this->tables['product_sale_order'].'.product_id')
                    ->join($this->tables['sale_order'], $this->tables['sale_order'].'.sale_order_no='.$this->tables['product_sale_order'].'.sale_order_no')
                    ->join($this->tables['customers'], $this->tables['customers'].'.id='.$this->tables['sale_order'].'.customer_id')
                    ->where($this->tables['product_sale_order'].'.shop_id',$shop_id)
                    ->get();  
    }*/
    
    public function get_user_sales_by_card_no($card_no = '' , $shop_id = '')
    {        
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['stock_info'].'.shop_id', $shop_id);
        if(!empty($card_no))
        {
            $this->db->where($this->tables['customers'].'.card_no', $card_no);
        }
        
        $this->db->where_in($this->tables['stock_info'].'.transaction_category_id', array(STOCK_SALE_IN, STOCK_SALE_PARTIAL_OUT, STOCK_SALE_DELETE));
        $this->db->group_by($this->tables['stock_info'].'.sale_order_no');
        $this->db->group_by($this->tables['stock_info'].'.product_id');
        $this->db->order_by($this->tables['sale_order'].'.created_on','desc');
        return $this->db->select($this->tables['sale_order'].'.created_on,'.$this->tables['product_sale_order'].'.purchase_order_no,'.$this->tables['product_info'].'.name as product_name,sum(stock_out)-sum(stock_in) as total_sale,'.$this->tables['product_sale_order'].'.unit_price as sale_unit_price,'.$this->tables['product_purchase_order'].'.unit_price as purchase_unit_price,'.$this->tables['sale_order'].'.created_by, users_salesman.first_name as salesman_first_name, users_salesman.last_name as salesman_last_name, users_customers.first_name as customer_first_name, users_customers.last_name as customer_last_name,'.$this->tables['customers'].'.card_no,'.$this->tables['customers'].'.id as customer_id,'.$this->tables['stock_info'].'.sale_order_no')
                    ->from($this->tables['stock_info'])
                    ->join($this->tables['product_info'], $this->tables['stock_info'].'.product_id='.$this->tables['product_info'].'.id ')
                    ->join($this->tables['sale_order'], $this->tables['sale_order'].'.sale_order_no='.$this->tables['stock_info'].'.sale_order_no AND '.$this->tables['sale_order'].'.shop_id='.$shop_id)
                    ->join($this->tables['product_sale_order'], $this->tables['product_sale_order'].'.sale_order_no='.$this->tables['stock_info'].'.sale_order_no AND '.$this->tables['product_sale_order'].'.product_id='.$this->tables['stock_info'].'.product_id')
                    ->join($this->tables['product_purchase_order'], $this->tables['product_purchase_order'].'.purchase_order_no='.$this->tables['stock_info'].'.purchase_order_no AND '.$this->tables['product_purchase_order'].'.product_id='.$this->tables['stock_info'].'.product_id')
                    ->join($this->tables['customers'], $this->tables['customers'].'.id='.$this->tables['sale_order'].'.customer_id')
                    ->join($this->tables['users'].' AS users_customers', 'users_customers.id='.$this->tables['customers'].'.user_id')
                    ->join($this->tables['users'].' AS users_salesman', 'users_salesman.id='.$this->tables['sale_order'].'.created_by')
                    ->get();
    }
    
    public function get_user_sales_by_name($name , $shop_id = '')
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['stock_info'].'.shop_id', $shop_id);
        $this->db->like('users_customers.first_name', $name);
        $this->db->or_like('users_customers.last_name', $name); 
        
        $this->db->where_in($this->tables['stock_info'].'.transaction_category_id', array(STOCK_SALE_IN, STOCK_SALE_PARTIAL_OUT, STOCK_SALE_DELETE));
        $this->db->group_by($this->tables['stock_info'].'.sale_order_no');
        $this->db->group_by($this->tables['stock_info'].'.product_id');
        $this->db->order_by($this->tables['sale_order'].'.created_on','desc');
        return $this->db->select($this->tables['sale_order'].'.created_on,'.$this->tables['product_sale_order'].'.purchase_order_no,'.$this->tables['product_info'].'.name as product_name,sum(stock_out)-sum(stock_in) as total_sale,'.$this->tables['product_sale_order'].'.unit_price as sale_unit_price,'.$this->tables['product_purchase_order'].'.unit_price as purchase_unit_price,'.$this->tables['sale_order'].'.created_by, users_salesman.first_name as salesman_first_name, users_salesman.last_name as salesman_last_name, users_customers.first_name as customer_first_name, users_customers.last_name as customer_last_name,'.$this->tables['customers'].'.card_no,'.$this->tables['customers'].'.id as customer_id,'.$this->tables['stock_info'].'.sale_order_no,'.$this->tables['product_unit_category'].'.description as category_unit')
                    ->from($this->tables['stock_info'])
                    ->join($this->tables['product_info'], $this->tables['stock_info'].'.product_id='.$this->tables['product_info'].'.id ')
                    ->join($this->tables['product_unit_category'],  $this->tables['product_unit_category'].'.id='.$this->tables['product_info'].'.unit_category_id')
                    ->join($this->tables['sale_order'], $this->tables['sale_order'].'.sale_order_no='.$this->tables['stock_info'].'.sale_order_no AND '.$this->tables['sale_order'].'.shop_id='.$shop_id)
                    ->join($this->tables['product_sale_order'], $this->tables['product_sale_order'].'.sale_order_no='.$this->tables['stock_info'].'.sale_order_no AND '.$this->tables['product_sale_order'].'.product_id='.$this->tables['stock_info'].'.product_id')
                    ->join($this->tables['product_purchase_order'], $this->tables['product_purchase_order'].'.purchase_order_no='.$this->tables['stock_info'].'.purchase_order_no AND '.$this->tables['product_purchase_order'].'.product_id='.$this->tables['stock_info'].'.product_id')
                    ->join($this->tables['customers'], $this->tables['customers'].'.id='.$this->tables['sale_order'].'.customer_id')
                    ->join($this->tables['users'].' AS users_customers', 'users_customers.id='.$this->tables['customers'].'.user_id')
                    ->join($this->tables['users'].' AS users_salesman', 'users_salesman.id='.$this->tables['sale_order'].'.created_by')
                    ->get();
    }
    
    public function get_user_sales_by_phone($phone , $shop_id = '')
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['stock_info'].'.shop_id', $shop_id);
        $this->db->like('users_customers.phone', $phone); 
        
        $this->db->where_in($this->tables['stock_info'].'.transaction_category_id', array(STOCK_SALE_IN, STOCK_SALE_PARTIAL_OUT, STOCK_SALE_DELETE));
        $this->db->group_by($this->tables['stock_info'].'.sale_order_no');
        $this->db->group_by($this->tables['stock_info'].'.product_id');
        $this->db->order_by($this->tables['sale_order'].'.created_on','desc');
        return $this->db->select($this->tables['sale_order'].'.created_on,'.$this->tables['product_sale_order'].'.purchase_order_no,'.$this->tables['product_info'].'.name as product_name,sum(stock_out)-sum(stock_in) as total_sale,'.$this->tables['product_sale_order'].'.unit_price as sale_unit_price,'.$this->tables['product_purchase_order'].'.unit_price as purchase_unit_price,'.$this->tables['sale_order'].'.created_by, users_salesman.first_name as salesman_first_name, users_salesman.last_name as salesman_last_name, users_customers.first_name as customer_first_name, users_customers.last_name as customer_last_name, users_customers.phone as customer_phone,'.$this->tables['customers'].'.card_no,'.$this->tables['customers'].'.id as customer_id,'.$this->tables['stock_info'].'.sale_order_no,'.$this->tables['product_unit_category'].'.description as unit_category')
                    ->from($this->tables['stock_info'])
                    ->join($this->tables['product_info'], $this->tables['stock_info'].'.product_id='.$this->tables['product_info'].'.id ')
                    ->join($this->tables['product_unit_category'], $this->tables['product_unit_category'].'.id='.$this->tables['product_info'].'.unit_category_id')
                    ->join($this->tables['sale_order'], $this->tables['sale_order'].'.sale_order_no='.$this->tables['stock_info'].'.sale_order_no AND '.$this->tables['sale_order'].'.shop_id='.$shop_id)
                    ->join($this->tables['product_sale_order'], $this->tables['product_sale_order'].'.sale_order_no='.$this->tables['stock_info'].'.sale_order_no AND '.$this->tables['product_sale_order'].'.product_id='.$this->tables['stock_info'].'.product_id')
                    ->join($this->tables['product_purchase_order'], $this->tables['product_purchase_order'].'.purchase_order_no='.$this->tables['stock_info'].'.purchase_order_no AND '.$this->tables['product_purchase_order'].'.product_id='.$this->tables['stock_info'].'.product_id')
                    ->join($this->tables['customers'], $this->tables['customers'].'.id='.$this->tables['sale_order'].'.customer_id')
                    ->join($this->tables['users'].' AS users_customers', 'users_customers.id='.$this->tables['customers'].'.user_id')
                    ->join($this->tables['users'].' AS users_salesman', 'users_salesman.id='.$this->tables['sale_order'].'.created_by')
                    ->get();
    }
    
    public function get_total_sale_price($customer_id)
    {
        $shop_id = $this->session->userdata('shop_id');
        $this->db->where('shop_id', $shop_id);
        $this->db->where('customer_id', $customer_id);
        return $this->db->select('SUM(total) as total_sale_price')
                            ->from($this->tables['sale_order'])
                            ->get();
    }
    
    public function get_sale_orders_today($time, $shop_id = '')
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id', $shop_id);
        $this->db->where('sale_date >=', $time);
        return $this->db->select('*')
                            ->from($this->tables['sale_order'])
                            ->get();
    }
    
    public function get_due_list_today($time, $shop_id = '')
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['sale_order'].'.shop_id', $shop_id);
        $this->db->where($this->tables['sale_order'].'.sale_date >=', $time);
        $this->db->where('('.$this->tables['sale_order'].'.total - '.$this->tables['sale_order'].'.paid) >', 0);
        return $this->db->select($this->tables['sale_order'].'.*,'.$this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name,'.$this->tables['customers'].'.card_no')
                            ->from($this->tables['sale_order'])
                            ->join($this->tables['customers'], $this->tables['customers'].'.id='.$this->tables['sale_order'].'.customer_id')
                            ->join($this->tables['users'], $this->tables['users'].'.id='.$this->tables['customers'].'.user_id')
                            ->get();
    }
    
    public function get_previous_sale_amount($current_date, $shop_id = 0)
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id', $shop_id);
        $this->db->where('created_on <', $current_date);
        return $this->db->select('sum(paid) as total_previous_sale_amount')
                            ->from($this->tables['sale_order'])
                            ->get();
    }
    
    public function get_product_sale_orders($sale_order_no, $shop_id = 0)
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id', $shop_id);
        $this->db->where('sale_order_no', $sale_order_no);
        return $this->db->select('*')
                            ->from($this->tables['product_sale_order'])
                            ->get();
    }
    
    public function get_product_list_sale_order($sale_order_no, $shop_id = 0)
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['product_info'].'.shop_id', $shop_id);
        $this->db->where('sale_order_no', $sale_order_no);
        return $this->db->select($this->tables['product_sale_order'].'.*,'.$this->tables['product_info'].'.name as product_name')
                            ->from($this->tables['product_sale_order'])
                            ->join($this->tables['product_info'], $this->tables['product_info'].'.id='.$this->tables['product_sale_order'].'.product_id')
                            ->get();
    }
    
    public function get_sale_order($sale_order_no, $shop_id = 0)
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id', $shop_id);
        $this->db->where('sale_order_no', $sale_order_no);
        return $this->db->select('*')
                            ->from($this->tables['sale_order'])
                            ->get();
    }
    
    public function delete_product_sale_order($sale_order_no, $shop_id = 0)
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id', $shop_id);
        $this->db->where('sale_order_no', $sale_order_no);
        return $this->db->delete($this->tables['product_sale_order']);
    }
    
    public function delete_sale_order($sale_order_no, $shop_id = 0)
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id', $shop_id);
        $this->db->where('sale_order_no', $sale_order_no);
        return $this->db->delete($this->tables['sale_order']);
    }
    
    public function get_all_sales($shop_id = '')
    {
        /*if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->group_by($this->tables['customers'].'.id');
        return $this->db->select($this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name,'.$this->tables['users'].'.phone,'.$this->tables['users'].'.address,'.$this->tables['customers'].'.card_no, sum('.$this->tables['product_sale_order'].'.quantity) as total_quantity')
                    ->from($this->tables['product_sale_order'])
                    ->join($this->tables['sale_order'], $this->tables['sale_order'].'.sale_order_no='.$this->tables['product_sale_order'].'.sale_order_no')
                    ->join($this->tables['customers'], $this->tables['customers'].'.id='.$this->tables['sale_order'].'.customer_id')
                    ->join($this->tables['users'], $this->tables['users'].'.id='.$this->tables['customers'].'.user_id')
                    ->where($this->tables['product_sale_order'].'.shop_id',$shop_id)
                    ->get();*/  
        
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['stock_info'].'.shop_id', $shop_id);        
        
        $this->db->where_in($this->tables['stock_info'].'.transaction_category_id', array(STOCK_SALE_IN, STOCK_SALE_PARTIAL_OUT, STOCK_SALE_DELETE));
        $this->db->group_by($this->tables['stock_info'].'.sale_order_no');
        $this->db->group_by($this->tables['stock_info'].'.product_id');
        return $this->db->select($this->tables['sale_order'].'.created_on,'.$this->tables['product_sale_order'].'.purchase_order_no,'.$this->tables['product_info'].'.name as product_name,sum(stock_out)-sum(stock_in) as total_sale,'.$this->tables['product_sale_order'].'.unit_price as sale_unit_price,'.$this->tables['product_purchase_order'].'.unit_price as purchase_unit_price,'.$this->tables['sale_order'].'.created_by, users_salesman.first_name as salesman_first_name, users_salesman.last_name as salesman_last_name, users_customers.first_name as customer_first_name, users_customers.last_name as customer_last_name,'.$this->tables['customers'].'.card_no,'.$this->tables['customers'].'.id as customer_id,'.$this->tables['stock_info'].'.sale_order_no')
                    ->from($this->tables['stock_info'])
                    ->join($this->tables['product_info'], $this->tables['stock_info'].'.product_id='.$this->tables['product_info'].'.id ')
                    ->join($this->tables['sale_order'], $this->tables['sale_order'].'.sale_order_no='.$this->tables['stock_info'].'.sale_order_no AND '.$this->tables['sale_order'].'.shop_id='.$shop_id)
                    ->join($this->tables['product_sale_order'], $this->tables['product_sale_order'].'.sale_order_no='.$this->tables['stock_info'].'.sale_order_no AND '.$this->tables['product_sale_order'].'.product_id='.$this->tables['stock_info'].'.product_id')
                    ->join($this->tables['product_purchase_order'], $this->tables['product_purchase_order'].'.purchase_order_no='.$this->tables['stock_info'].'.purchase_order_no AND '.$this->tables['product_purchase_order'].'.product_id='.$this->tables['stock_info'].'.product_id')
                    ->join($this->tables['customers'], $this->tables['customers'].'.id='.$this->tables['sale_order'].'.customer_id')
                    ->join($this->tables['users'].' AS users_customers', 'users_customers.id='.$this->tables['customers'].'.user_id')
                    ->join($this->tables['users'].' AS users_salesman', 'users_salesman.id='.$this->tables['sale_order'].'.created_by')
                    ->get();
    }
    
    public function get_test_sales($time, $product_id = 0, $shop_id = 0 )
    {
        $drop_query = 'DROP TABLE IF EXISTS temp_sale_info_today';
        $this->db->query($drop_query);
        $query = "CREATE TEMPORARY TABLE IF NOT EXISTS temp_sale_info_today(
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `first_name` varchar(50) DEFAULT NULL,
        `last_name` varchar(50) DEFAULT NULL,
        `card_no` varchar(200) DEFAULT NULL, 
        `product_id` INT(11),        
	`total_sale` double DEFAULT 0,
	`sale_unit_price` double DEFAULT 0,
        `sale_order_no` varchar(200),
	PRIMARY KEY (`id`)
        );";
        $this->db->query($query);
        
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['stock_info'].'.shop_id', $shop_id);
        $this->db->where($this->tables['sale_order'].'.created_on >=',$time);
        if( $product_id != 0 )
        {
            $this->db->where($this->tables['stock_info'].'.product_id', $product_id);
        }
        $this->db->where_in($this->tables['stock_info'].'.transaction_category_id', array(STOCK_SALE_IN, STOCK_SALE_PARTIAL_OUT, STOCK_SALE_DELETE));
        $this->db->group_by($this->tables['stock_info'].'.sale_order_no');
        $this->db->group_by($this->tables['stock_info'].'.product_id');
        $this->db->insert_batch('temp_sale_info_today',$this->db->select($this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name,'.$this->tables['customers'].'.card_no,'.$this->tables['product_info'].'.id as product_id, sum(stock_out)-sum(stock_in) as total_sale,'.$this->tables['product_sale_order'].'.unit_price as sale_unit_price, '.$this->tables['sale_order'].'.sale_order_no')
                    ->from($this->tables['stock_info'])
                    ->join($this->tables['product_info'], $this->tables['stock_info'].'.product_id='.$this->tables['product_info'].'.id ')
                    ->join($this->tables['sale_order'], $this->tables['sale_order'].'.sale_order_no='.$this->tables['stock_info'].'.sale_order_no AND '.$this->tables['sale_order'].'.shop_id='.$shop_id)
                    ->join($this->tables['product_sale_order'], $this->tables['product_sale_order'].'.sale_order_no='.$this->tables['stock_info'].'.sale_order_no AND '.$this->tables['product_sale_order'].'.product_id='.$this->tables['stock_info'].'.product_id')
                    ->join($this->tables['product_purchase_order'], $this->tables['product_purchase_order'].'.purchase_order_no='.$this->tables['stock_info'].'.purchase_order_no AND '.$this->tables['product_purchase_order'].'.product_id='.$this->tables['stock_info'].'.product_id')
                    ->join($this->tables['customers'], $this->tables['customers'].'.id='.$this->tables['sale_order'].'.customer_id')
                    ->join($this->tables['users'], $this->tables['users'].'.id='.$this->tables['customers'].'.user_id')
                    ->get()->result_array());
        
        
        $drop_query = 'DROP TABLE IF EXISTS temp_sale_summary_info_today';
        $this->db->query($drop_query);
        $query = "CREATE TEMPORARY TABLE IF NOT EXISTS temp_sale_summary_info_today(
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `first_name` varchar(50) DEFAULT NULL,
        `last_name` varchar(50) DEFAULT NULL,
        `card_no` varchar(200) DEFAULT NULL, 
        `product_id` INT(11),        
	`total_sale` double DEFAULT 0,
	`sale_unit_price` double DEFAULT 0,
        `sale_order_no` varchar(200),
	PRIMARY KEY (`id`)
        );";
        $this->db->query($query);
        
        $this->db->where($this->tables['customer_payment_info'].'.payment_category_id', 1);
        $this->db->group_by('temp_sale_info_today.sale_order_no');
        return $this->db->select('sum(total_sale * sale_unit_price) as total_sale_price, sum(amount) as total_payment')
                ->from('temp_sale_info_today')
                ->join($this->tables['customer_payment_info'], $this->tables['customer_payment_info'].'.sale_order_no = temp_sale_info_today.sale_order_no AND '.$this->tables['customer_payment_info'].'.shop_id='.$shop_id)
                ->get();
    }
}
