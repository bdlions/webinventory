<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Purchase Model
 * Added in Class Diagram
 * Requirements: PHP5 or above
 *
 */
class Purchase_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Purchase Order No of a shop is checked
     * purchase order no will be unique for a shop
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
    
    public function purchase_identity_check($purchase_order_no = '', $product_category1 = '', $product_size = '') {
        $this->trigger_events('purchase_order_no_check');
        if (empty($purchase_order_no) || empty($product_category1) || empty($product_size)) {
            return FALSE;
        }
        $shop_id = $this->session->userdata('shop_id');
        $this->db->where('shop_id', $shop_id);
        $this->db->where('purchase_order_no', $purchase_order_no);
        $this->db->where('product_category1', $product_category1);
        $this->db->where('product_size', $product_size);
        return $this->db->count_all_results($this->tables['purchase_order']) > 0;
    }

    /*
     * This method will add warehouse purchase order
     * @Author Nazmul on 14th January 2015
     */

    public function add_warehouse_purchase_order($additional_data, $warehouse_purchased_product_list, $add_warehouse_stock_list, $forward_warehouse_stock_list, $supplier_payment_data, $supplier_transaction_info_array, $forward_showroom = 0) {
        $this->trigger_events('pre_add_purchase_order');
        if ($this->purchase_identity_check($additional_data['purchase_order_no'], $additional_data['product_category1'], $additional_data['product_size'])) {
            $this->set_error('add_purchase_order_duplicate_purchase_order_no');
            return FALSE;
        }
        $this->db->trans_begin();
        //filter out any data passed that doesnt have a matching column in the users table
        $purchase_data = $this->_filter_data($this->tables['purchase_order'], $additional_data);

        $this->db->insert($this->tables['purchase_order'], $purchase_data);

        $id = $this->db->insert_id();
        if ($id > 0) {
            if ($supplier_payment_data['amount'] > 0) {
                $this->db->insert($this->tables['supplier_payment_info'], $supplier_payment_data);
            }
            $this->db->insert_batch($this->tables['supplier_transaction_info'], $supplier_transaction_info_array);
            $this->db->insert_batch($this->tables['warehouse_product_purchase_order'], $warehouse_purchased_product_list);
            if (!empty($add_warehouse_stock_list)) {
                $this->db->insert_batch($this->tables['warehouse_stock_info'], $add_warehouse_stock_list);
            }
            if ($forward_showroom == 1) {
                $this->db->insert_batch($this->tables['product_purchase_order'], $warehouse_purchased_product_list);
                if (!empty($add_warehouse_stock_list)) {
                    $stock_list = array();
                    foreach ($add_warehouse_stock_list as $stock_info) {
                        $stock_info['transaction_category_id'] = STOCK_PURCHASE_IN;
                        $stock_list[] = $stock_info;
                    }
                    $this->db->insert_batch($this->tables['stock_info'], $stock_list);
                    if (!empty($forward_warehouse_stock_list)) {
                        $this->db->insert_batch($this->tables['warehouse_stock_info'], $forward_warehouse_stock_list);
                    }
                }
            }
        }
        $this->trigger_events('post_add_purchase_order');
        $this->db->trans_commit();
        return (isset($id)) ? $id : FALSE;
    }

    public function warehouse_purchase_product_check($purchase_order_no, $product_category1, $product_size, $product_id) {
        $this->db->where($this->tables['warehouse_product_purchase_order'] . '.purchase_order_no', $purchase_order_no);
        $this->db->where($this->tables['warehouse_product_purchase_order'] . '.product_category1', $product_category1);
        $this->db->where($this->tables['warehouse_product_purchase_order'] . '.product_size', $product_size);
        $this->db->where($this->tables['warehouse_product_purchase_order'] . '.product_id', $product_id);
        $qr_result = $this->db->select('*')
                ->from($this->tables['warehouse_product_purchase_order'])
                ->get()
                ->result_array();
        return !(empty($qr_result));
    }
    /*
     * This method will raise warehouse purchase order
     * @Author Nazmul on 14th January 2015
     */

    public function warehouse_purchase_product_order_no_check($purchase_order_no, $product_id) {
        $this->db->where($this->tables['warehouse_product_purchase_order'] . '.purchase_order_no', $purchase_order_no);
        $this->db->where($this->tables['warehouse_product_purchase_order'] . '.product_id', $product_id);
        $qr_result = $this->db->select('*')
                ->from($this->tables['warehouse_product_purchase_order'])
                ->get()
                ->result_array();
        return !(empty($qr_result));
    }

    public function raise_warehouse_purchase_order($additional_data, $new_warehouse_purchased_product_list, $add_warehouse_stock_list, $supplier_transaction_info_array, $forward_showroom = 0) {
        $this->trigger_events('pre_raise_purchase_order');
        $this->db->trans_begin();
        //filter out any data passed that doesnt have a matching column in the users table
        $purchase_data = $this->_filter_data($this->tables['purchase_order'], $additional_data);
        $this->db->update($this->tables['purchase_order'], $purchase_data, array('purchase_order_no' => $purchase_data['purchase_order_no'], 'shop_id' => $purchase_data['shop_id']));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }
        foreach ($new_warehouse_purchased_product_list as $warehouse_product_data) {
            if ($this->warehouse_purchase_product_check($warehouse_product_data['purchase_order_no'], $warehouse_product_data['product_category1'], $warehouse_product_data['product_size'], $warehouse_product_data['product_id'])) {
                continue;
            }
            $this->db->insert($this->tables['warehouse_product_purchase_order'], $warehouse_product_data);
        }
        if ($forward_showroom == 1) {
            foreach ($new_warehouse_purchased_product_list as $product_data) {
                if ($this->purchase_product_check($product_data['purchase_order_no'], $product_data['product_category1'], $product_data['product_size'], $product_data['product_id'])) {
                    continue;
                }
                $this->db->insert($this->tables['product_purchase_order'], $product_data);
            }
            if (!empty($add_warehouse_stock_list)) {
                $stock_list = array();
                foreach ($add_warehouse_stock_list as $stock_info) {
                    $stock_info['transaction_category_id'] = STOCK_PURCHASE_PARTIAL_IN;
                    $stock_list[] = $stock_info;
                }
                $this->db->insert_batch($this->tables['stock_info'], $stock_list);
            }
        }
        if (!empty($add_warehouse_stock_list)) {
            $this->db->insert_batch($this->tables['warehouse_stock_info'], $add_warehouse_stock_list);
        }
        if (!empty($supplier_transaction_info_array)) {
            $this->db->insert_batch($this->tables['supplier_transaction_info'], $supplier_transaction_info_array);
        }
        $this->db->trans_commit();
        return TRUE;
    }

    /*
     * This method will return warehouse purchase order
     * @Author Nazmul on 14th January 2015
     */

    public function return_warehouse_purchase_order($additional_data, $stock_out_list, $supplier_transaction_info_array, $return_balance_info) {
        $this->trigger_events('pre_return_purchase_order');
        $this->db->trans_begin();
        //filter out any data passed that doesnt have a matching column in the users table
        $purchase_data = $this->_filter_data($this->tables['purchase_order'], $additional_data);
        $this->db->update($this->tables['purchase_order'], $purchase_data, array('purchase_order_no' => $purchase_data['purchase_order_no'], 'shop_id' => $purchase_data['shop_id']));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }
        if (!empty($return_balance_info)) {
            $return_balance_info = $this->_filter_data($this->tables['supplier_returned_payment_info'], $return_balance_info);
            $this->db->insert($this->tables['supplier_returned_payment_info'], $return_balance_info);
        }
        if (!empty($supplier_transaction_info_array)) {
            $this->db->insert_batch($this->tables['supplier_transaction_info'], $supplier_transaction_info_array);
        }
        if (!empty($stock_out_list)) {
            $this->db->insert_batch($this->tables['warehouse_stock_info'], $stock_out_list);
        }

        $this->db->trans_commit();
        return TRUE;
    }

    public function get_warehouse_purchase_order_info($purchase_order_no, $shop_id = 0, $product_category1 = '', $product_size = '') {
        if ($shop_id == 0) {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['purchase_order'] . '.purchase_order_no', $purchase_order_no);
        if(!empty($product_category1))
        {
            $this->db->where($this->tables['purchase_order'] . '.product_category1', $product_category1);
        }
        if(!empty($product_size))
        {
            $this->db->where($this->tables['purchase_order'] . '.product_size', $product_size);
        }
        $this->db->where($this->tables['purchase_order'] . '.shop_id', $shop_id);
        return $this->db->select('*')
                        ->from($this->tables['purchase_order'])
                        ->get();
    }

    /*
     * This method will return product list under a purchase order
     * @param $purchase_order_no, purchase order no
     * @param $shop_id, shop id
     * @Author Nazmul on 14th January 2015
     */

    public function get_warehouse_purchased_product_list($purchase_order_no, $shop_id = 0, $product_category1 = '', $product_size = '') {
        if ($shop_id == 0) {
            $shop_id = $this->session->userdata('shop_id');
        }
        if(!empty($product_category1))
        {
            $this->db->where($this->tables['warehouse_product_purchase_order'] . '.product_category1', $product_category1);
        }
        if(!empty($product_size))
        {
            $this->db->where($this->tables['warehouse_product_purchase_order'] . '.product_size', $product_size);
        }
        $this->db->where($this->tables['warehouse_product_purchase_order'] . '.purchase_order_no', $purchase_order_no);
        $this->db->where($this->tables['warehouse_product_purchase_order'] . '.shop_id', $shop_id);
        return $this->db->select($this->tables['warehouse_product_purchase_order'] . '.product_id,' . $this->tables['warehouse_product_purchase_order'] . '.unit_price,' . $this->tables['product_info'] . '.name as product_name')
                        ->from($this->tables['warehouse_product_purchase_order'])
                        ->join($this->tables['product_info'], $this->tables['product_info'] . '.id=' . $this->tables['warehouse_product_purchase_order'] . '.product_id')
                        ->get();
    }

    public function purchase_product_check($purchase_order_no, $product_category1, $product_size, $product_id) {
        $this->db->where($this->tables['product_purchase_order'] . '.purchase_order_no', $purchase_order_no);
        $this->db->where($this->tables['product_purchase_order'] . '.product_category1', $product_category1);
        $this->db->where($this->tables['product_purchase_order'] . '.product_size', $product_size);
        $this->db->where($this->tables['product_purchase_order'] . '.product_id', $product_id);
        $qr_result = $this->db->select('*')
                ->from($this->tables['product_purchase_order'])
                ->get()
                ->result_array();
        return !(empty($qr_result));
    }
    /**
     * Storing purchase order, product purchase order and stock into the database
     *
     * @return bool
     * @author Nazmul on 22nd November 2014
     * */
    public function purchase_product_order_no_check($purchase_order_no, $product_id) {
        $this->db->where($this->tables['product_purchase_order'] . '.purchase_order_no', $purchase_order_no);
        $this->db->where($this->tables['product_purchase_order'] . '.product_id', $product_id);
        $qr_result = $this->db->select('*')
                ->from($this->tables['product_purchase_order'])
                ->get()
                ->result_array();
        return !(empty($qr_result));
    }

    public function add_purchase_order($purchased_product_list, $add_stock_list, $out_stock_list) {
        foreach ($purchased_product_list as $product_data) {
            if ($this->purchase_product_check($product_data['purchase_order_no'], $product_data['product_category1'], $product_data['product_size'], $product_data['product_id'])) {
                continue;
            }
            $this->db->insert($this->tables['product_purchase_order'], $product_data);
        }
        if (!empty($add_stock_list)) {
            $this->db->insert_batch($this->tables['stock_info'], $add_stock_list);
        }
        
        if (!empty($out_stock_list)) {
            $this->db->insert_batch($this->tables['warehouse_stock_info'], $out_stock_list);
        }
    }

    public function raise_purchase_order($additional_data, $new_purchased_product_list, $add_stock_list, $supplier_transaction_info_array) {
        $this->trigger_events('pre_raise_purchase_order');
        $this->db->trans_begin();
        //filter out any data passed that doesnt have a matching column in the users table
        $purchase_data = $this->_filter_data($this->tables['purchase_order'], $additional_data);
        $this->db->update($this->tables['purchase_order'], $purchase_data, array('purchase_order_no' => $purchase_data['purchase_order_no'], 'shop_id' => $purchase_data['shop_id']));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }
        if (!empty($new_purchased_product_list)) {
            $this->db->insert_batch($this->tables['product_purchase_order'], $new_purchased_product_list);
        }
        if (!empty($add_stock_list)) {
            $this->db->insert_batch($this->tables['stock_info'], $add_stock_list);
        }
        if (!empty($supplier_transaction_info_array)) {
            $this->db->insert_batch($this->tables['supplier_transaction_info'], $supplier_transaction_info_array);
        }
        $this->db->trans_commit();
        return TRUE;
    }

    public function return_purchase_order($stock_out_list, $stock_in_list) {
        $this->trigger_events('pre_return_purchase_order');
        $this->db->trans_begin();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }
        if (!empty($stock_out_list)) {
            $this->db->insert_batch($this->tables['stock_info'], $stock_out_list);
        }
        if(!empty($stock_in_list))
        {
            $this->db->insert_batch($this->tables['warehouse_stock_info'], $stock_in_list);
        }

        $this->db->trans_commit();
        return TRUE;
    }

    /*
     * This method will return largest purchase order no of a shop
     * @Author Nazmul on 14th January 2015
     */

    public function get_next_purchase_order_no($shop_id = 0) {
        if ($shop_id == 0) {
            $shop_id = $this->session->userdata('shop_id');
        }
        $query = 'SELECT purchase_order_no FROM purchase_order where shop_id =' . $shop_id . ' order by id desc limit 1';
        return $this->db->query($query);
    }

    /*
     * This method will return purchase order info
     * @param $purchase_order_no, purchase order no
     * @param $shop_id, shop id
     * @Author Nazmul on 14th January 2015
     */

    public function get_purchase_order_info($purchase_order_no, $shop_id = 0) {
        if ($shop_id == 0) {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['purchase_order'] . '.purchase_order_no', $purchase_order_no);
        $this->db->where($this->tables['purchase_order'] . '.shop_id', $shop_id);
        return $this->db->select('*')
                        ->from($this->tables['purchase_order'])
                        ->get();
    }

    /*
     * This method will return product list under a purchase
     * @param $purchase_order_no, purchase order no
     * @param $shop_id, shop id
     * @Author Nazmul on 14th January 2015
     */

    public function get_purchased_product_list($purchase_order_no, $shop_id = 0, $product_category1 = '', $product_size = '') {
        if ($shop_id == 0) {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['product_purchase_order'] . '.purchase_order_no', $purchase_order_no);
        if(!empty($product_category1))
        {
            $this->db->where($this->tables['product_purchase_order'] . '.product_category1', $product_category1);
        }
        if(!empty($product_size))
        {
            $this->db->where($this->tables['product_purchase_order'] . '.product_size', $product_size);
        }
        $this->db->where($this->tables['product_purchase_order'] . '.shop_id', $shop_id);
        return $this->db->select($this->tables['product_purchase_order'] . '.product_id,' . $this->tables['product_purchase_order'] . '.unit_price,' . $this->tables['product_info'] . '.name as product_name')
                        ->from($this->tables['product_purchase_order'])
                        ->join($this->tables['product_info'], $this->tables['product_info'] . '.id=' . $this->tables['product_purchase_order'] . '.product_id')
                        ->get();
    }

    public function get_supplier_transaction_info($lot_no) {
        $this->db->where($this->tables['supplier_transaction_info'] . '.lot_no', $lot_no);
        return $this->db->select('*')
                        ->from($this->tables['supplier_transaction_info'])
                        ->get();
    }

}
