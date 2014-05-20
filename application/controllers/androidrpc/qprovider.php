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
                  }
                ]
            }';
        
     }
     
     function getQ($q_id){
	 if($q_id == 1)
         return '{
            "id": "1",
            "name": "Q1",
            "customer": [
              {
                "id": "1",
                "name": "Alamgir",
                "country": {
                  "name": "Bangladesh",
                  "code": "88"
                },
                "phone": {
                  "phoneNo": "01556898372",
                  "dial": {
                    "status": "0",
                    "statusText": "PENDING",
                    "errorCode": "0",
                    "errorText": "N/A",
                    "callCount": "1"
                  },
                  "message": {
                        "content":"This is first",
                    "status": "0",
                    "statusText": "PENDING",
                    "errorCode": "0",
                    "errorText": "N/A",
                    "sMSCount": "1"
                  }
                }
              }
            ]
        }';
		else if($q_id == 2){
		return '{
            "id": "2",
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
                  "phoneNo": "01725724068",
                  "dial": {
                    "status": "0",
                    "statusText": "PENDING",
                    "errorCode": "0",
                    "errorText": "N/A",
                    "callCount": "1"
                  },
                  "message": {
                        "content":"This is to you",
                    "status": "0",
                    "statusText": "PENDING",
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
                    "statusText": "PENDING",
                    "errorCode": "0",
                    "errorText": "N/A",
                    "callCount": "1"
                  },
                  "message": {
                    "content":"This is test message1",
                    "status": "0",
                    "statusText": "PENDING",
                    "errorCode": "0",
                    "errorText": "N/A",
                    "sMSCount": "1"
                  }
                }
              }
            ]
        }';
     }else
		return '{
            "id": "2",
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
                  "phoneNo": "01671800187",
                  "dial": {
                    "status": "0",
                    "statusText": "PENDING",
                    "errorCode": "0",
                    "errorText": "N/A",
                    "callCount": "1"
                  },
                  "message": {
                        "content":"This is my second message",
                    "status": "0",
                    "statusText": "PENDING",
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
                    "statusText": "PENDING",
                    "errorCode": "0",
                    "errorText": "N/A",
                    "callCount": "1"
                  },
                  "message": {
                    "content":"This is test message1",
                    "status": "0",
                    "statusText": "PENDING",
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
                    "statusText": "PENDING",
                    "errorCode": "0",
                    "errorText": "N/A",
                    "callCount": "1"
                  },
                  "message": {
                    "content":"This is test message1",
                    "status": "0",
                    "statusText": "PENDING",
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
