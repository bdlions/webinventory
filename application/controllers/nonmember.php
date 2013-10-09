<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class NonMember extends CI_Controller {

    function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->template->load(NON_MEMBER_TEMPLATE, 'nonmember/home');
    }
}
?>