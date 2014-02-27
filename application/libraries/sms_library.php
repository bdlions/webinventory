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
class Sms_library {
    public function __construct() {
        $this->load->config('ion_auth', TRUE);
        $this->load->library('email');
        $this->load->library('org/common/sms_configuration');
        $this->lang->load('ion_auth');
        $this->load->helper('cookie');

        // Load the session, CI2 as a library, CI3 uses it as a driver
        if (substr(CI_VERSION, 0, 1) == '2') {
            $this->load->library('session');
        } else {
            $this->load->driver('session');
        }
        
        require_once(str_replace("\\","/",APPPATH).'libraries/nusoaplib/nusoap'.EXT); //If we are executing this script on a Windows server
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        throw new Exception('Undefined method Sms_library::' . $method . '() called');
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
    
    public function send_sms($phoneNumber, $message)
    {
        $sms_configuration_shop_array = $this->sms_configuration->get_sms_configuration_shop()->result_array();
        if(!empty($sms_configuration_shop_array))
        {
            $status = $sms_configuration_shop_array[0]['status'];
            if($status == 0)
            {
                return 0;
            }
        }
        else
        {
            return 0;
        }
        /*if($phoneNumber == "" || $message == ""){
                return 0;
        }
        else{
            $execution_time = 5 * 60;//3 minutes
            @set_time_limit($execution_time);
            $url = $this->config->item('sms_sender_server_url', 'ion_auth').'?mobileNo='.urlencode($phoneNumber).'&message='.urlencode($message);
            $result = @file_get_contents($url);
            if($result == 1){
                    return 1;
            }
            else{
                    return 0;
            }
        }*/
        $client = new nusoap_client("http://cmp.robi.com.bd/WS/CMPWebService.asmx?wsdl", true);
        //print_r($client);
        $params = array(
        'Username' => 'apurbo',
        'Password' => '654321',
        'From' => '8801841104245',
        'To' => $phoneNumber,
        'Message' => $message
        );
        $result = $client->call('SendTextMessage', $params);
        //echo "Result: ";
        //echo "<pre>";
        //print_r($result);
        //echo "</pre>";
    }
}
