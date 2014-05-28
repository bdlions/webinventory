<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Ion Auth
 *
 * Author: Ben Edmunds
 * 		  ben.edmunds@gmail.com
 *         @benedmunds
 *
 * Added Awesomeness: Phil Sturgeon
 *
 * Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
 *
 * Created:  10.01.2009
 *
 * Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
 * Original Author name has been kept but that does not mean that the method has not been modified.
 *
 * Requirements: PHP5 or above
 *
 */
class Manage_queue_library {
    /**
     * __construct
     *
     * @return void
     * @author Ben
     * */
    protected $manage_queue_type_list = array();
    public function __construct() {
        $this->load->config('ion_auth', TRUE);
        $this->load->model('org/manage_queue/manage_queue_model');

        // Load the session, CI2 as a library, CI3 uses it as a driver
        if (substr(CI_VERSION, 0, 1) == '2') {
            $this->load->library('session');
        } else {
            $this->load->driver('session');
        }
        $this->manage_queue_type_list = $this->config->item('manage_queue_type', 'ion_auth');
        // Load IonAuth MongoDB model if it's set to use MongoDB,
        // We assign the model object to "ion_auth_model" variable.
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->model('ion_auth_mongodb_model', 'ion_auth_model') :
                        $this->load->model('ion_auth_model');

        $this->manage_queue_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->manage_queue_model, $method)) {
            throw new Exception('Undefined method Expense::' . $method . '() called');
        }

        return call_user_func_array(array($this->manage_queue_model, $method), $arguments);
    }

    /**
     * __get
     *
     * Enables the use of CI super-global without having to define an extra variable.
     *
     * I can't remember where I first saw this, so thank you if you are the original author. -Militis
     *
     * @access	public
     * @param	$var
     * @return	mixed
     */
    public function __get($var) {
        return get_instance()->$var;
    }
    
    public function get_queue_info_by_id($id) {
        $results = $this->manage_queue_library->get_queue_by_id($id)->row();

        $phone_number_list=array();
        $customer_array=array();
        $queue_name = $results->name;
        $queue_id = $results->id;
        $phone_upload_list_id = $results->phone_upload_list_id;
        $results->unprocess_list;
        
        $final_queue = new stdClass();
        $final_queue->id = $queue_id;
        $final_queue->name = $queue_name;
        //echo '<pre / >'; print_r(json_decode($results->unprocess_list));
        
        foreach (json_decode($results->unprocess_list) as $key => $jsonObj) {
            
            //array_push($phone_number_list, $jsonObj->id);

            $customer_info = $this->manage_queue_library->get_user_info($jsonObj->id)->row();
            
            // customer obj
            $customer_obj = new stdClass();
            $customer_obj->id = $customer_info->id;
            $customer_obj->name = $customer_info->name;
            
            //country boject
            $country = new stdClass();
            $country->name = "Bangladesh";
            $country->code= "88";

            //phone_object
            $phone = new stdClass();
            $phone->phoneNo = $jsonObj->number;
            
            // dial object
            $dial = new stdClass();
            $dial->status = "0";
            $dial->statusText = "PENDING";
            $dial->errorCode = "0";
            $dial->errorText = "N/A";
            $dial->callCount = "1";
            
            // create message object
            $message = new stdClass();
            $message->content = $jsonObj->message;
            $message->status = "0";
            $message->statusText = "PENDING";
            $message->errorCode = "0";
            $message->errorText = "N/A";
            $message->sMSCount = "1";
            
            // set this dial object in phone object as a dial attribute
            $phone->dial = $dial;
            // set the message object in phone object as a message attribute
            $phone->message = $message;
            
            // set country obj in customer obj
            $customer_obj->country = $country;
            // set country obj in customer obj
            $customer_obj->phone = $phone;

            array_push($customer_array, $customer_obj);
        }
        
        $final_queue->customer = $customer_array;
        
        //echo '<pre / >'; print_r($final_queue);exit;
        
        $data = array('json_data' => json_encode($final_queue));
        $this->manage_queue_library->test_queue_insert($data);
        
        //$all_phone_no = $this->manage_queue_library->get_user_info_by_ids($phone_number_list)->result_array();

        //echo '<pre / >'; print_r($all_phone_no);exit(' i m here liff');
    }
    
    
}
