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
class Product_model extends CI_Model {

    protected $product_identity;
    
    public $account_status_list = array();
    /**
     * Holds an array of tables used
     *
     * @var array
     * */
    public $tables = array();

    /**
     * activation code
     *
     * @var string
     * */
    public $activation_code;

    /**
     * forgotten password key
     *
     * @var string
     * */
    public $forgotten_password_code;

    /**
     * new password
     *
     * @var string
     * */
    public $new_password;

    /**
     * Identity
     *
     * @var string
     * */
    public $identity;

    /**
     * Where
     *
     * @var array
     * */
    public $_ion_where = array();

    /**
     * Select
     *
     * @var array
     * */
    public $_ion_select = array();

    /**
     * Like
     *
     * @var array
     * */
    public $_ion_like = array();

    /**
     * Limit
     *
     * @var string
     * */
    public $_ion_limit = NULL;

    /**
     * Offset
     *
     * @var string
     * */
    public $_ion_offset = NULL;

    /**
     * Order By
     *
     * @var string
     * */
    public $_ion_order_by = NULL;

    /**
     * Order
     *
     * @var string
     * */
    public $_ion_order = NULL;

    /**
     * Hooks
     *
     * @var object
     * */
    protected $_ion_hooks;

    /**
     * Response
     *
     * @var string
     * */
    protected $response = NULL;

    /**
     * message (uses lang file)
     *
     * @var string
     * */
    protected $messages;

    /**
     * error message (uses lang file)
     *
     * @var string
     * */
    protected $errors;

    /**
     * error start delimiter
     *
     * @var string
     * */
    protected $error_start_delimiter;

    /**
     * error end delimiter
     *
     * @var string
     * */
    protected $error_end_delimiter;

    /**
     * caching of users and their groups
     *
     * @var array
     * */
    public $_cache_user_in_group = array();

    /**
     * caching of groups
     *
     * @var array
     * */
    protected $_cache_groups = array();

    public function __construct() {
        parent::__construct();
        $this->account_status_list = $this->config->item('account_status', 'ion_auth');
        $this->load->database();
        $this->load->config('ion_auth', TRUE);
        $this->load->helper('cookie');
        $this->load->helper('date');
        $this->lang->load('ion_auth');

        //initialize db tables data
        $this->tables = $this->config->item('tables', 'ion_auth');

        //initialize data
        $this->product_identity = $this->config->item('product_identity', 'ion_auth');
        $this->store_salt = $this->config->item('store_salt', 'ion_auth');
        $this->salt_length = $this->config->item('salt_length', 'ion_auth');
        $this->join = $this->config->item('join', 'ion_auth');


        //initialize hash method options (Bcrypt)
        $this->hash_method = $this->config->item('hash_method', 'ion_auth');
        $this->default_rounds = $this->config->item('default_rounds', 'ion_auth');
        $this->random_rounds = $this->config->item('random_rounds', 'ion_auth');
        $this->min_rounds = $this->config->item('min_rounds', 'ion_auth');
        $this->max_rounds = $this->config->item('max_rounds', 'ion_auth');


        //initialize messages and error
        $this->messages = array();
        $this->errors = array();
        $this->message_start_delimiter = $this->config->item('message_start_delimiter', 'ion_auth');
        $this->message_end_delimiter = $this->config->item('message_end_delimiter', 'ion_auth');
        $this->error_start_delimiter = $this->config->item('error_start_delimiter', 'ion_auth');
        $this->error_end_delimiter = $this->config->item('error_end_delimiter', 'ion_auth');

        //initialize our hooks object
        $this->_ion_hooks = new stdClass;

        //load the bcrypt class if needed
        if ($this->hash_method == 'bcrypt') {
            if ($this->random_rounds) {
                $rand = rand($this->min_rounds, $this->max_rounds);
                $rounds = array('rounds' => $rand);
            } else {
                $rounds = array('rounds' => $this->default_rounds);
            }

            $this->load->library('bcrypt', $rounds);
        }

        $this->trigger_events('model_constructor');
    }

    public function limit($limit) {
        $this->trigger_events('limit');
        $this->_ion_limit = $limit;

        return $this;
    }

    public function offset($offset) {
        $this->trigger_events('offset');
        $this->_ion_offset = $offset;

        return $this;
    }

    public function where($where, $value = NULL) {
        $this->trigger_events('where');

        if (!is_array($where)) {
            $where = array($where => $value);
        }

        array_push($this->_ion_where, $where);

        return $this;
    }

    public function like($like, $value = NULL) {
        $this->trigger_events('like');

        if (!is_array($like)) {
            $like = array($like => $value);
        }

        array_push($this->_ion_like, $like);

        return $this;
    }

    public function select($select) {
        $this->trigger_events('select');

        $this->_ion_select[] = $select;

        return $this;
    }

    public function order_by($by, $order = 'desc') {
        $this->trigger_events('order_by');

        $this->_ion_order_by = $by;
        $this->_ion_order = $order;

        return $this;
    }

    public function row() {
        $this->trigger_events('row');

        $row = $this->response->row();
        $this->response->free_result();

        return $row;
    }

    public function row_array() {
        $this->trigger_events(array('row', 'row_array'));

        $row = $this->response->row_array();
        $this->response->free_result();

        return $row;
    }

    public function result() {
        $this->trigger_events('result');

        $result = $this->response->result();
        $this->response->free_result();

        return $result;
    }

    public function result_array() {
        $this->trigger_events(array('result', 'result_array'));

        $result = $this->response->result_array();
        $this->response->free_result();

        return $result;
    }

    public function num_rows() {
        $this->trigger_events(array('num_rows'));

        $result = $this->response->num_rows();
        $this->response->free_result();

        return $result;
    }

    /**
     * set_lang
     *
     * @return bool
     * @author Ben Edmunds
     * */
    public function set_lang($lang = 'en') {
        $this->trigger_events('set_lang');

        // if the user_expire is set to zero we'll set the expiration two years from now.
        if ($this->config->item('user_expire', 'ion_auth') === 0) {
            $expire = (60 * 60 * 24 * 365 * 2);
        }
        // otherwise use what is set
        else {
            $expire = $this->config->item('user_expire', 'ion_auth');
        }

        set_cookie(array(
            'name' => 'lang_code',
            'value' => $lang,
            'expire' => $expire
        ));

        return TRUE;
    }

    public function set_hook($event, $name, $class, $method, $arguments) {
        $this->_ion_hooks->{$event}[$name] = new stdClass;
        $this->_ion_hooks->{$event}[$name]->class = $class;
        $this->_ion_hooks->{$event}[$name]->method = $method;
        $this->_ion_hooks->{$event}[$name]->arguments = $arguments;
    }

    public function remove_hook($event, $name) {
        if (isset($this->_ion_hooks->{$event}[$name])) {
            unset($this->_ion_hooks->{$event}[$name]);
        }
    }

    public function remove_hooks($event) {
        if (isset($this->_ion_hooks->$event)) {
            unset($this->_ion_hooks->$event);
        }
    }

    protected function _call_hook($event, $name) {
        if (isset($this->_ion_hooks->{$event}[$name]) && method_exists($this->_ion_hooks->{$event}[$name]->class, $this->_ion_hooks->{$event}[$name]->method)) {
            $hook = $this->_ion_hooks->{$event}[$name];

            return call_user_func_array(array($hook->class, $hook->method), $hook->arguments);
        }

        return FALSE;
    }

    public function trigger_events($events) {
        if (is_array($events) && !empty($events)) {
            foreach ($events as $event) {
                $this->trigger_events($event);
            }
        } else {
            if (isset($this->_ion_hooks->$events) && !empty($this->_ion_hooks->$events)) {
                foreach ($this->_ion_hooks->$events as $name => $hook) {
                    $this->_call_hook($events, $name);
                }
            }
        }
    }

    /**
     * set_message_delimiters
     *
     * Set the message delimiters
     *
     * @return void
     * @author Ben Edmunds
     * */
    public function set_message_delimiters($start_delimiter, $end_delimiter) {
        $this->message_start_delimiter = $start_delimiter;
        $this->message_end_delimiter = $end_delimiter;

        return TRUE;
    }

    /**
     * set_error_delimiters
     *
     * Set the error delimiters
     *
     * @return void
     * @author Ben Edmunds
     * */
    public function set_error_delimiters($start_delimiter, $end_delimiter) {
        $this->error_start_delimiter = $start_delimiter;
        $this->error_end_delimiter = $end_delimiter;

        return TRUE;
    }

    /**
     * set_message
     *
     * Set a message
     *
     * @return void
     * @author Ben Edmunds
     * */
    public function set_message($message) {
        $this->messages[] = $message;

        return $message;
    }

    /**
     * messages
     *
     * Get the messages
     *
     * @return void
     * @author Ben Edmunds
     * */
    public function messages() {
        $_output = '';
        foreach ($this->messages as $message) {
            $messageLang = $this->lang->line($message) ? $this->lang->line($message) : '##' . $message . '##';
            $_output .= $this->message_start_delimiter . $messageLang . $this->message_end_delimiter;
        }

        return $_output;
    }

    /**
     * messages as array
     *
     * Get the messages as an array
     *
     * @return array
     * @author Raul Baldner Junior
     * */
    public function messages_array($langify = TRUE) {
        if ($langify) {
            $_output = array();
            foreach ($this->messages as $message) {
                $messageLang = $this->lang->line($message) ? $this->lang->line($message) : '##' . $message . '##';
                $_output[] = $this->message_start_delimiter . $messageLang . $this->message_end_delimiter;
            }
            return $_output;
        } else {
            return $this->messages;
        }
    }

    /**
     * set_error
     *
     * Set an error message
     *
     * @return void
     * @author Ben Edmunds
     * */
    public function set_error($error) {
        $this->errors[] = $error;

        return $error;
    }

    /**
     * errors
     *
     * Get the error message
     *
     * @return void
     * @author Ben Edmunds
     * */
    public function errors() {
        $_output = '';
        foreach ($this->errors as $error) {
            $errorLang = $this->lang->line($error) ? $this->lang->line($error) : '##' . $error . '##';
            $_output .= $this->error_start_delimiter . $errorLang . $this->error_end_delimiter;
        }

        return $_output;
    }
    
    /**
     * errors
     *
     * Get the error message to be used in pop up alert
     *
     * @return void
     * @author Nazmul
     * */
    public function errors_alert() {
        $_output = '';
        foreach ($this->errors as $error) {
            $errorLang = $this->lang->line($error) ? $this->lang->line($error) : '##' . $error . '##';
            $_output .= $errorLang; 
        }

        return $_output;
    }

    /**
     * errors as array
     *
     * Get the error messages as an array
     *
     * @return array
     * @author Raul Baldner Junior
     * */
    public function errors_array($langify = TRUE) {
        if ($langify) {
            $_output = array();
            foreach ($this->errors as $error) {
                $errorLang = $this->lang->line($error) ? $this->lang->line($error) : '##' . $error . '##';
                $_output[] = $this->error_start_delimiter . $errorLang . $this->error_end_delimiter;
            }
            return $_output;
        } else {
            return $this->errors;
        }
    }

    protected function _filter_data($table, $data) {
        $filtered_data = array();
        $columns = $this->db->list_fields($table);

        if (is_array($data)) {
            foreach ($columns as $column) {
                if (array_key_exists($column, $data))
                    $filtered_data[$column] = $data[$column];
            }
        }

        return $filtered_data;
    }

    protected function _prepare_ip($ip_address) {
        if ($this->db->platform() === 'postgre' || $this->db->platform() === 'sqlsrv' || $this->db->platform() === 'mssql') {
            return $ip_address;
        } else {
            return inet_pton($ip_address);
        }
    }
    
    //---------------------------------------------- Product related queries -------------------------------------------
    /**
     * Checks product name
     *
     * @return bool
     * @author Nazmul
     * */
    public function product_name_check($product_name = '') {
        $this->trigger_events('product_name_check');

        if (empty($product_name)) {
            return FALSE;
        }

        $this->trigger_events('extra_where');

        return $this->db->where('name', $product_name)
                        ->count_all_results($this->tables['product_info']) > 0;
    }
    
    /**
     * Checks product code
     *
     * @return bool
     * @author Nazmul
     * */
    public function product_code_check($product_code = '') {
        $this->trigger_events('product_code_check');

        if (empty($product_code)) {
            return FALSE;
        }

        $this->trigger_events('extra_where');

        return $this->db->where('code', $product_code)
                        ->count_all_results($this->tables['product_info']) > 0;
    }
    
    /**
     * Creating a new product
     *
     * @return bool if there is any error, otherwise newly created product id
     * @author Nazmul
     * */
    public function create_product($product_name, $product_code, $additional_data)
    {
        $this->trigger_events('pre_create_product');
        if ($this->product_identity == 'name' && $this->product_name_check($product_name)) 
        {
            $this->set_error('product_creation_duplicate_product_name');
            return FALSE;
        } 
        elseif ($this->product_identity == 'code' && $this->product_code_check($product_code)) 
        {
            $this->set_error('product_creation_duplicate_product_code');
            return FALSE;
        }
        $shop_id = $this->session->userdata('shop_id');
        $data = array(
            'name' => $product_name,
            'code' => $product_code,
            'shop_id' => $shop_id,
            'created_date' => date('Y-m-d H:i:s')
        );
        //filter out any data passed that doesnt have a matching column in the users table
        //and merge the product data and the additional data
        $additional_data = array_merge($this->_filter_data($this->tables['product_info'], $additional_data), $data);
        
        $this->db->insert($this->tables['product_info'], $additional_data);

        $id = $this->db->insert_id();

        $this->trigger_events('post_create_product');

        return (isset($id)) ? $id : FALSE;
    }
    
    public function update_product($product_id, $data)
    {
        $this->db->update($this->tables['product_info'], $data, array('id' => $product_id));
        $this->set_message('product_update_successful');
        return true;
    }
    
    public function get_product($product_id)
    {
        $this->db->where('id', $product_id);
        $this->response = $this->db->get($this->tables['product_info']);
        return $this;
    }
    
    public function get_all_products($shop_id = '')
    {
        if(empty($shop_id))
        {
            $shop_id = $this->session->userdata('shop_id');
        }
        $this->db->where($this->tables['product_info'].'.shop_id', $shop_id);
        $this->response = $this->db->get($this->tables['product_info']);
        return $this;
    }   
    public function search_product($key, $value)
    {
        $shop_id = $this->session->userdata('shop_id');
        $this->db->where($this->tables['product_info'].'.shop_id', $shop_id);
        $this->db->like($key, $value); 
        return $this->db->get($this->tables['product_info']); 
    }
}
