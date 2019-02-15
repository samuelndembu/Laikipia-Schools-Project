<?php
// $base_url = "http://localhost/mawingu-downtime/";
class Kaizala
{
    var $application_id;
    var $application_secret;
    var $refresh_token;
    var $access_token_url;
    var $group_id;
    
    public function __construct()
    {
        $this->application_id = "7930b52c-5c44-4f30-bf86-8eb59185a4b2";
        $this->application_secret = "6WPLN1IOCQ";
        $this->refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MjYxNDkzNTFcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiNzkzMGI1MmMtNWM0NC00ZjMwLWJmODYtOGViNTkxODVhNGIyXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcImFsdmFyb0Nvbm5lY3RvclxcXCJ9XCJ9IiwidWlkIjoiTW9iaWxlQXBwc1NlcnZpY2U6ODZmZWI1MmMtMTRkNS00YTdkLTk4ZGEtYmEyYWI0NDBmMDhmIiwidmVyIjoiMiIsIm5iZiI6MTUzOTI2NzY1NiwiZXhwIjoxNTcwODAzNjU2LCJpYXQiOjE1MzkyNjc2NTYsImlzcyI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIiwiYXVkIjoidXJuOm1pY3Jvc29mdDp3aW5kb3dzLWF6dXJlOnp1bW8ifQ.EUbTW2bHFd_7peTIuuADyxktphK33VMF7KdEOawMwbA";
        
        $this->access_token_url = "https://kms.kaiza.la/v1/accessToken";//New Mawingu Customers group
        $this->group_id = "5f35ad9e-8db4-4d2d-a1b4-4dbea41aec5b";
    }

    private function get_access_token()
    {
        // Performing the HTTP request
        $ch = curl_init($this->access_token_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, 
            array(
                'applicationId: ' . $this->application_id,
                'applicationSecret: ' . $this->application_secret,
                'refreshToken: ' . $this->refresh_token,
                'Content-Type: application/json',
            )
        );
        $response_body = curl_exec($ch);
        curl_close($ch);

        $response_json = json_decode($response_body);
        return $response_json->accessToken;
    }

    public function send_action_card($from_date, $to_date, $message, $title)
    {
        $url = "https://kms.kaiza.la/v1/groups/" . $this->group_id . "/actions";
        // echo $device.$sensor.$status.$date; die();
        $access_token = $this->get_access_token();
        $request_data = array(
            "id" => "com.mawingu.new.customer.reg.5",
            "sendToAllSubscribers" => true,
            "actionBody" => array(
                "properties" => array(
                    array(
                        "name" => "title",
                        "value" => $title,
                        "type" => "Text",
                    ),
                    array(
                        "name" => "message",
                        "value" => $message,
                        "type" => "Text",
                    ),
                    array(
                        "name" => "fromDate",
                        "value" => $from_date,
                        "type" => "Text",
                    ),
                    array(
                        "name" => "toDate",
                        "value" => $to_date,
                        "type" => "Text",
                    ),
                ),
            ),
        );
        $data_string = json_encode($request_data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accessToken: ' . $access_token,
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        $result = curl_exec($ch);
        curl_close($ch);

        $response_json = json_decode($result);
        return $response_json->actionId;
    }

    public function fetch_groups()
    {
        $access_token = $this->get_access_token();
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://kms.kaiza.la/v1/groups",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => array(
                "accessToken: ".$access_token 
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) 
        {
            echo "cURL Error #:" . $err;
        } 
        else 
        {
            return $response;
        }
    }

    public function get_single_group_details($group_id)
    {
        $access_token = $this->get_access_token();
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://kms.kaiza.la/v1/groups/".$group_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => array(
            "accessToken: ".$access_token,
            "applicationId: ".$this->application_id
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) 
        {
            echo "cURL Error #:" . $err;
            return FALSE;
        } 
        else 
        {
            $response_obj = json_decode($response);
            
            if(array_key_exists('message', $response_obj))
            {
                return FALSE;
            }
            else
            {
                return $response_obj;
            }
            
        }
    }
}