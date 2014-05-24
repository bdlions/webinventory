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
class Product_model extends Ion_auth_model 
{
    protected $product_identity_column;
    public function __construct() {
        parent::__construct();
        $this->product_identity_column = $this->config->item('product_identity_column', 'ion_auth');        
    }
    /**
     * Product Identity check
     * Product name will be unique under a single shop
     * @return bool
     * @author Nazmul on 22nd November 2014
     * */
    public function product_identity_check($identity = '') {
        $this->trigger_events('product_identity_check');
        if (empty($identity)) {
            return FALSE;
        }
        $shop_id = $this->session->userdata('shop_id');
        $this->db->where('shop_id', $shop_id);
        $this->db->where($this->product_identity_column, $identity);
        return $this->db->count_all_results($this->tables['product_info']) > 0;
    }
    /**
     * @author Nazmul on 22nd January 2014
     * Creating a new product
     * @return false if there is any error, otherwise will return newly created product id
     * 
     * */
    public function create_product($product_name, $additional_data)
    {
        $this->trigger_events('pre_create_product');
        if ($this->product_identity_column == 'name' && $this->product_identity_check($product_name)) 
        {
            $this->set_error('product_creation_duplicate_product_name');
            return FALSE;
        } 
        $shop_id = $this->session->userdata('shop_id');
        $data = array(
            'name' => $product_name,
            'shop_id' => $shop_id,
            'created_on' => now()
        );
        //filter out any data passed that doesnt have a matching column in the users table
        //and merge the product data and the additional data
        $additional_data = array_merge($this->_filter_data($this->tables['product_info'], $additional_data), $data);
        //print_r($additional_data);exit('HI');
        $this->db->insert($this->tables['product_info'], $additional_data);

        $id = $this->db->insert_id();

        $this->trigger_events('post_create_product');

        return (isset($id)) ? $id : FALSE;
    }
    
    /**
     * Update product info
     * @return bool
     * 
     * @author Nazmul on 22nd January 2014
     * 
     * */
    public function update_product($id, $data)
    {
        $product_info = $this->get_product($id)->row();
        if (array_key_exists($this->product_identity_column, $data) && $this->identity_check($data[$this->product_identity_column]) && $product_info->{$this->product_identity_column} !== $data[$this->product_identity_column])
        {
            $this->set_error('product_update_duplicate_product_name');
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['product_info'], $data);
        $this->db->update($this->tables['product_info'], $data, array('id' => $id));
        $this->set_message('product_update_successful');
        return true;
    }
    /**
     * Product Info
     * @param $product_id, product id
     * @return product info
     * @author Nazmul on 22nd November 2014
     * */
    public function get_product($product_id)
    {
        $this->db->where('id', $product_id);
        $this->response = $this->db->get($this->tables['product_info']);
        return $this;
    }
    
    public function get_products($product_id_list)
    {
        $this->db->where_in('id', $product_id_list);
        $this->response = $this->db->get($this->tables['product_info']);
        return $this;
    }
    /**
     * Product List of a shop
     *
     * @return product list of a shop
     * @author Nazmul on 22nd November 2014
     * */
    public function get_all_products($shop_id = '')
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['product_info'].'.shop_id', $shop_id);
        return $this->db->select($this->tables['product_info'].'.id as product_id,'.$this->tables['product_info'].'.*,'.$this->tables['product_unit_category'].'.description as category_unit')
                    ->from($this->tables['product_info'])
                    ->join($this->tables['product_unit_category'],  $this->tables['product_unit_category'].'.id='.$this->tables['product_info'].'.unit_category_id')
                    ->get();
    } 
    /**
     * Product Search
     *
     * @param $key, column name of product table
     * @param $value, search string of product table
     * @return product list
     * @author Nazmul on 22nd November 2014
     * */
    public function search_product($key, $value)
    {
        $shop_id = $this->session->userdata('shop_id');
        $this->db->where($this->tables['product_info'].'.shop_id', $shop_id);
        $this->db->like($key, $value); 
        return $this->db->get($this->tables['product_info']); 
    }
    
    public function create_product_unit_category($additional_data)
    {
        //echo $this->session->userdata('shop_id');
        //$this->trigger_events('pre_create_unit');
        $data = array(
            'shop_id' => $this->session->userdata('shop_id')
        );
        //echo '<pre />';print_r($additional_data); exit('here');
        //filter out any data passed that doesnt have a matching column in the unit table
        $unit_data = array_merge($this->_filter_data($this->tables['product_unit_category'], $additional_data), $data);
        $this->db->insert($this->tables['product_unit_category'], $unit_data);
        $id = $this->db->insert_id();
        if( $id > 0)
        {
            $this->set_message('create_unit_successful');
        }
        else
        {
            $this->set_error('create_unit_unsuccessful');
        }        
        //$this->trigger_events('post_create_unit');
        return (isset($id)) ? $id : FALSE;
    }
    
    public function get_all_product_unit_category($shop_id = 0)
    {
        if( $shop_id == 0 )
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where('shop_id',$shop_id);
        $this->response = $this->db->get($this->tables['product_unit_category']);
        return $this;
    }
}
