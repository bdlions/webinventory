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
        $this->load->library('org/manage_queue/manage_queue_library');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
     }

     function index(){
       
     }
     function getQList(){
         
        $list = array();
        $results = $this->manage_queue_library->getAllUnprocessedQlist()->result_array();
        //echo '<pre/>';print_r($results);exit('here');
         
        foreach ($results as $key => $value) {
            $queue_list = new stdClass();
            $queue_list->id = $value['id'];
            $queue_list->name = $value['name'];
            $queue_list->noOfMsgs = count(json_decode($value['unprocess_list']));
            array_push($list,$queue_list);
        }
        
        $queues = new stdClass();
        $queues->id = 1;
        $queues->queues = $list;
       
        //$data = array('json_data' => json_encode($queues));
        //echo '<pre/>'; print_r($queues);exit('i m here');
        return $queues;
        
        /*return '{
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
            }';*/
        
     }
     
     function getQ($q_id){
        $results = $this->manage_queue_library->get_queue_info_by_id($q_id);
        //echo '<pre/>';print_r($results);exit('dddd');
        return json_encode($results);
        //return '{"id":"6","name":"Q2","customer":[{"id":"25","name":"Mahmud Emon","country":{"name":"Bangladesh","code":"88"},"phone":{"phoneNo":"5434533453\r\n","dial":{"status":"0","statusText":"PENDING","errorCode":"0","errorText":"N\/A","callCount":"1"},"message":{"content":"gfdg dfgd dffdg","status":"0","statusText":"PENDING","errorCode":"0","errorText":"N\/A","sMSCount":"1"}}},{"id":"26","name":"Eid collection","country":{"name":"Bangladesh","code":"88"},"phone":{"phoneNo":"43451345335\r\n","dial":{"status":"0","statusText":"PENDING","errorCode":"0","errorText":"N\/A","callCount":"1"},"message":{"content":"gfdg dfgd dffdg","status":"0","statusText":"PENDING","errorCode":"0","errorText":"N\/A","sMSCount":"1"}}},{"id":"27","name":"Pronov Rasel","country":{"name":"Bangladesh","code":"88"},"phone":{"phoneNo":"0116895874\r\n","dial":{"status":"0","statusText":"PENDING","errorCode":"0","errorText":"N\/A","callCount":"1"},"message":{"content":"gfdg dfgd dffdg","status":"0","statusText":"PENDING","errorCode":"0","errorText":"N\/A","sMSCount":"1"}}},{"id":"28","name":"Redwan","country":{"name":"Bangladesh","code":"88"},"phone":{"phoneNo":"02355441378\r\n","dial":{"status":"0","statusText":"PENDING","errorCode":"0","errorText":"N\/A","callCount":"1"},"message":{"content":"gfdg dfgd dffdg","status":"0","statusText":"PENDING","errorCode":"0","errorText":"N\/A","sMSCount":"1"}}},{"id":"29","name":"jecket","country":{"name":"Bangladesh","code":"88"},"phone":{"phoneNo":"02154789654\r\n","dial":{"status":"0","statusText":"PENDING","errorCode":"0","errorText":"N\/A","callCount":"1"},"message":{"content":"gfdg dfgd dffdg","status":"0","statusText":"PENDING","errorCode":"0","errorText":"N\/A","sMSCount":"1"}}},{"id":"30","name":"Mahmud Emon","country":{"name":"Bangladesh","code":"88"},"phone":{"phoneNo":"543045345653\r\n","dial":{"status":"0","statusText":"PENDING","errorCode":"0","errorText":"N\/A","callCount":"1"},"message":{"content":"gfdg dfgd dffdg","status":"0","statusText":"PENDING","errorCode":"0","errorText":"N\/A","sMSCount":"1"}}},{"id":"31","name":"Rasel Rahman","country":{"name":"Bangladesh","code":"88"},"phone":{"phoneNo":"9454665664\r\n","dial":{"status":"0","statusText":"PENDING","errorCode":"0","errorText":"N\/A","callCount":"1"},"message":{"content":"gfdg dfgd dffdg","status":"0","statusText":"PENDING","errorCode":"0","errorText":"N\/A","sMSCount":"1"}}},{"id":"32","name":"Mahmud Emon","country":{"name":"Bangladesh","code":"88"},"phone":{"phoneNo":"5430453453","dial":{"status":"0","statusText":"PENDING","errorCode":"0","errorText":"N\/A","callCount":"1"},"message":{"content":"gfdg dfgd dffdg","status":"0","statusText":"PENDING","errorCode":"0","errorText":"N\/A","sMSCount":"1"}}}]}';
        
        /*if($q_id == 1)
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
        }';*/
     }
}
?>
