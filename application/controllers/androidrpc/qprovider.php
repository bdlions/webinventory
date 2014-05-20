<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';
class QProvider extends JsonRPCServer{
     function __construct() {
        parent::__construct();
        $this->load->helper('url');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
     }

     function index(){
        
     }
     function getQList(){
         return '{
                "id": "1",
                "queues": [
                  {
                    "id": "1",
                    "name": "Q1",
                    "noOfMsgs": "10"
                  },
                  {
                    "id": "2",
                    "name": "Q2",
                    "noOfMsgs": "20"
                  },
                  {
                    "id": "3",
                    "name": "Q3",
                    "noOfMsgs": "10"
                  },
                  {
                    "id": "4",
                    "name": "Q4",
                    "noOfMsgs": "50"
                  }
                ]
            }';
        
     }
     
     function getQ(){
         return '{
            "id": "1",
            "name": "Q1",
            "customer": [
              {
                "id": "1",
                "name": "Alamgir Kabir",
                "country": {
                  "name": "Bangladesh",
                  "code": "88"
                },
                "phone": {
                  "phoneNo": "01556898372",
                  "dial": {
                    "status": "0",
                    "statusText": "N/A",
                    "errorCode": "0",
                    "errorText": "N/A",
                    "callCount": "1"
                  },
                  "message": {
                        "content":"This is my first message",
                    "status": "0",
                    "statusText": "N/A",
                    "errorCode": "0",
                    "errorText": "N/A",
                    "sMSCount": "1"
                  }
                }
              },
              {
                "id": "2",
                "name": "Omar farukh",
                "country": {
                  "name": "Bangladesh",
                  "code": "88"
                },
                "phone": {
                  "phoneNo": "01718239477",
                  "dial": {
                    "status": "0",
                    "statusText": "N/A",
                    "errorCode": "0",
                    "errorText": "N/A",
                    "callCount": "1"
                  },
                  "message": {
                    "content":"This is test message1",
                    "status": "0",
                    "statusText": "N/A",
                    "errorCode": "0",
                    "errorText": "N/A",
                    "sMSCount": "1"
                  }
                }
              }
            ]
        }';
     }
}
?>
