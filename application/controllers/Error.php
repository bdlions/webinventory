<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Error extends CI_Controller {

    function __construct() {
        parent::__construct();
    }
    function error_404(){
        $this->load->view("error_404");
    }
}
?>
