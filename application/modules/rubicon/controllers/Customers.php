<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customers extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();

        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400'); // cache for 1 day
        }

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            }

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }

            exit(0);
        }
        $this->load->model("customers_model"); //CONNECT/USEMODEL
        $this->load->model("kaizala_model");// ""
    }

    public function get_details()
    { //details entered
        //receive json post
        // $json_string = '[
        //                     {
        //                         "firstname": "Cecilia",
        //                         "lastname": "Gitahi",
        //                         "phone": "{\"cc\":91,\"pn\":\"0708105327\"}",
        //                         "email": "cessygitahi57@gmail.com",
        //                         "location": "{\"lt\":0.0181571,\"lg\":37.0740454,\"n\":\"\",\"acc\":18.570999145507812}",
        //                         "createdbyname": "Cecila",
        //                         "createdbyphone": "+254708105327"
        //                     }
        //                 ]';
        
        $json_string = file_get_contents("php://input");

        //convert json string  to array
        $json_object = json_decode($json_string);

        //validate
        if (is_array($json_object) && (count($json_object) > 0)) {
            //retieve data
            $row = $json_object[0];
            $location_obj = json_decode($row->location);
            $phone_obj = json_decode($row->phone);
            $phone = $phone_obj->pn;
            if($phone[0] == '7')
            {
                $phone = '+254'.$phone;
            }
            elseif($phone[0] == '0' && $phone[1] == '7')
            {
              $phone_number = substr($phone,1,10);
                $phone = "+254".$phone_number;
            }
            //var_dump($phone_obj);
            $access_code = $this->customers_model->get_access_code();
            //$access_code = "xfnfu44";
            if ($access_code != false) {
                $current_time = date('Y-m-d H:i:s');
                $data = array(
                    "customer_firstname" => $row->firstname,
                    "customer_lastname" => $row->lastname,
                    "customer_phone" => $phone,
                    "customer_email" => $row->email,
                    "access_code" => $access_code,
                    "created" => $current_time,
                    "created_by_name" => $row->createdbyname,
                    "created_by_phone" => $row->createdbyphone,
                    "latitude" => $location_obj->lt,
                    "longitude" => $location_obj->lg,

                );
                //request to submit /request to save data
                $customer_id = $this->customers_model->save_customerdetails($data);
                if ($customer_id > 0) {
                    $this->kaizala_model->send_announcement($row->firstname . ' ' .$row->lastname, $phone, $access_code);

                }
            }
            else{
                echo "accessCode cannot be null!!";
            }
        }

    }
}
