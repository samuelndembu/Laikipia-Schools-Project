<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Kaizala_model extends CI_Model
{
    public function send_announcement($customer_name, $customer_phone, $access_code)
    {
        # code...
        $group_id = "5ee58876-7820-468b-881e-e38be059c7e6";
        $refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MjYxNDkzNTFcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiMWZhMGNkNTMtYTczNi00NDc2LTk0ZDEtN2ZkOTEwODEyOTg4XCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiVGVuYW50SWRcXFwiOlxcXCI5ZjgxZjMzNC02OTk5LTQ5ZTctYThlMC0zNTM1Njg0ZWJiMzFcXFwiLFxcXCJPMzY1VXNlcklkXFxcIjpcXFwiMWNhNDMyZmUtODQ3OS00YTI2LWIzOTktNjYwMWIzY2ViNzZiXFxcIixcXFwiSXNUZW5hbnRBZG1pblxcXCI6XFxcIkZhbHNlXFxcIixcXFwiTzM2NVVzZXJFbWFpbElkXFxcIjpcXFwiYXBwZmFjdG9yeUBNQVdJTkdVTkVUV09SS1MuQ09NXFxcIixcXFwiQXBwTmFtZVxcXCI6XFxcIkFwcEZhY3RvcnlcXFwifVwifSIsInVpZCI6Ik1vYmlsZUFwcHNTZXJ2aWNlOjg2ZmViNTJjLTE0ZDUtNGE3ZC05OGRhLWJhMmFiNDQwZjA4ZiIsInZlciI6IjIiLCJuYmYiOjE1NDk5NjY3ODMsImV4cCI6MTU4MTUwMjc4MywiaWF0IjoxNTQ5OTY2NzgzLCJpc3MiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyIsImF1ZCI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIn0.iaGDABdHM75SxLZ3WxZcYFf3IfJ6ozZg1LrAG7cPOhM";
        $application_id = "1fa0cd53-a736-4476-94d1-7fd910812988";
        $application_secret = "1XJQ78AD0Q";

        $access_token = $this->get_access_token($application_id, $application_secret, $refresh_token);
        $post_field = array(
            "actiontype" =>"Announcement",
            "actionBody" => array(
                "title" => "Success",
                "message" => "Name:".$customer_name."  Phone:". $customer_phone."Access code:". $access_code

            )
            );
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://kms.kaiza.la/v1/groups/".$group_id."/actions",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($post_field),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "accessToken:" . $access_token,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    private function get_access_token($application_id, $application_secret, $refresh_token)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://kms.kaiza.la/v1/accessToken",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "applicationId: " . $application_id,
                "applicationSecret:" . $application_secret,
                "refreshToken:" . $refresh_token,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
          $response_array = json_decode($response);
          return $response_array->accessToken;
            
        }
    }
}
