<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Name:  Utils
 * Added in Class Diagram
 * Requirements: PHP5 or above
 */
class Utils {
    /**
     * __construct
     *
     * @return void
     * @author Ben
     * */
    public function __construct() {
        $this->load->config('ion_auth', TRUE);
        // Load the session, CI2 as a library, CI3 uses it as a driver
        if (substr(CI_VERSION, 0, 1) == '2') {
            $this->load->library('session');
        } else {
            $this->load->driver('session');
        }

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
    /*
     * This time will convert unix time to human format time
     * @param $time, unix time
     * @Author Nazmul on 18th January 2015
     */
    public function process_time($time)
    {
        /*$time_zone_array = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, 'BD');
        $dateTimeZone = new DateTimeZone($time_zone_array[0]);
        $dateTime = new DateTime("now", $dateTimeZone);
        return unix_to_human($time + $dateTime->getOffset());*/
        return unix_to_human($time);
    }    
    /*
     * This method will return unix time of a human date
     * @param $date, date
     * @Author Nazmul on 18th January 2015
     */
    public function get_human_to_unix($date)
    {
        //adding default hour, minute and AM/PM if date is YYYY-MM-DD format
        $date_array = explode(" ", $date);
        if(count($date_array) == 1)
        {
            $date = $date.' 00:00 AM';
        }
        //return human_to_unix($date)-21600;
        return human_to_unix($date);
    }    
    /*
     * This method will return server current date start time in unix 
     * Author Nazmul on 18th January 2015
     */
    public function get_current_date_start_time()
    {
        $unix_current_time = now();
        $human_current_time = unix_to_human($unix_current_time);
        $human_current_time_array= explode(" ", $human_current_time);
        $human_current_date = $human_current_time_array[0];
        $human_current_date_start_time = $human_current_date.' 00:00 AM';
        $unix_current_date_start_time = human_to_unix($human_current_date_start_time);
        return $unix_current_date_start_time;
    }
    
    /*
     * This method will return current date
     * @Author Nazmul on 18th January 2015
     */
    public function get_current_date()
    {
        $unix_current_time = now();
        $human_current_time = unix_to_human($unix_current_time);
        $human_current_time_array= explode(" ", $human_current_time);
        return $human_current_time_array[0];
    }
}
