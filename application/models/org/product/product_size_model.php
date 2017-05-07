<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 
 * Name:  Product Size Model
 * Requirements: PHP5 or above
 *
 */
class Product_size_model extends Ion_auth_model 
{
    protected $product_size_identity_column;
    public function __construct() {
        parent::__construct();   
        $this->product_size_identity_column = $this->config->item('product_size_identity_column', 'ion_auth');
    }
    
    public function product_size_identity_check($identity = '') {
        $this->trigger_events('product_size_identity_check');
        if (empty($identity)) {
            return FALSE;
        }
        $shop_id = $this->session->userdata('shop_id');
        $this->db->where('shop_id', $shop_id);
        $this->db->where($this->product_size_identity_column, $identity);
        return $this->db->count_all_results($this->tables['product_sizes']) > 0;
    }
    
    public function get_all_product_sizes($shop_id = 0)
    {
        if($shop_id == 0)
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['product_sizes'].'.shop_id', $shop_id);
        return $this->db->select($this->tables['product_sizes'].'.id as product_size_id,'.$this->tables['product_sizes'].'.*')
                    ->from($this->tables['product_sizes'])
                    ->get();
    }
    
    public function get_product_size_info($product_size_id)
    {
        $this->db->where($this->tables['product_sizes'].'.id', $product_size_id);
        return $this->db->select($this->tables['product_sizes'].'.id as product_size_id,'.$this->tables['product_sizes'].'.*')
                    ->from($this->tables['product_sizes'])
                    ->get();
    }
    
    public function add_product_size_info($title, $additional_data)
    {
        $current_time = now();
        $this->trigger_events('pre_add_product_size_info');
        $shop_id = 0;
        if(array_key_exists('shop_id', $additional_data) && $additional_data['shop_id'] > 0)
        {
            $shop_id = $additional_data['shop_id'];
        }
        else
        {
            $shop_id = $this->session->userdata('shop_id');
        }        
        if ($this->product_size_identity_column == 'title' && $this->product_size_identity_check($title)) 
        {
            $this->set_error('product_size_creation_duplicate_product_size');
            return FALSE;
        } 
        
        $data = array(
            'title' => $title,
            'shop_id' => $shop_id,
            'created_on' => $current_time,
            'modified_on' => $current_time
        );
        //filter out any data passed that doesnt have a matching column in the product size table
        //and merge the product size data and the additional data
        $product_size_data = array_merge($this->_filter_data($this->tables['product_sizes'], $additional_data), $data);
        $this->db->insert($this->tables['product_sizes'], $product_size_data);

        $id = $this->db->insert_id();
        if ($id !== FALSE) 
        {
            $this->set_message('product_size_creation_successful');
        } 
        else 
        {
            $this->set_error('product_size_creation_unsuccessful');
        }
        
        $this->trigger_events('post_add_product_size_info');

        return (isset($id)) ? $id : FALSE;
    }
    
    public function update_product_size_info($product_size_id, $data)
    {
        $data['modified_on'] = now();
        $product_size_info = $this->get_product_size_info($product_size_id)->row();
        if (array_key_exists($this->product_size_identity_column, $data) && $this->product_size_identity_check($data[$this->product_size_identity_column]) && $product_size_info->{$this->product_size_identity_column} !== $data[$this->product_size_identity_column])
        {
            $this->set_error('product_size_update_duplicate_size');
            return FALSE;
        }
        $update_data = $this->_filter_data($this->tables['product_sizes'], $data);
        $this->db->update($this->tables['product_sizes'], $update_data, array('id' => $product_size_id));
        $this->set_message('product_size_update_successful');
        return true;
    }
    
    public function delete_product_size_info($product_size_id)
    {
        if(!isset($product_size_id) || $product_size_id <= 0)
        {
            $this->set_error('product_size_delete_fail');
            return FALSE;
        }
        
        $product_size_info_array = $this->get_product_size_info($product_size_id)->result_array();
        if(!empty($product_size_info_array))
        {
            $this->db->where('product_size', $product_size_info_array[0]['title']);
            if( $this->db->count_all_results($this->tables['warehouse_stock_info']) > 0)
            {
                $this->set_error('product_size_delete_fail_size_exists');
                return FALSE;
            }
        }
        else
        {
            $this->set_error('product_size_delete_fail');
            return FALSE;
        }
        
        $this->db->where('id', $product_size_id);
        $this->db->delete($this->tables['product_sizes']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('product_size_delete_fail');
            return FALSE;
        }
        $this->set_message('product_size_delete_successful');
        return TRUE;
    }
}
