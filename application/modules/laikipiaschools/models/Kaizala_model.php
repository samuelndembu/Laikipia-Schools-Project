<?php
class Kaizala_model extends CI_Model
{
    public $application_id;
    public $application_secret;
    public $refresh_token;
    public $access_token_url;
    public $group_id;

    public function __construct()
    {
        parent::__construct();
        $this->application_id = "7930b52c-5c44-4f30-bf86-8eb59185a4b2";
        $this->application_secret = "6WPLN1IOCQ";
        $this->refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MjYxNDkzNTFcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiNzkzMGI1MmMtNWM0NC00ZjMwLWJmODYtOGViNTkxODVhNGIyXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcImFsdmFyb0Nvbm5lY3RvclxcXCJ9XCJ9IiwidWlkIjoiTW9iaWxlQXBwc1NlcnZpY2U6ODZmZWI1MmMtMTRkNS00YTdkLTk4ZGEtYmEyYWI0NDBmMDhmIiwidmVyIjoiMiIsIm5iZiI6MTUzOTI2NzY1NiwiZXhwIjoxNTcwODAzNjU2LCJpYXQiOjE1MzkyNjc2NTYsImlzcyI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIiwiYXVkIjoidXJuOm1pY3Jvc29mdDp3aW5kb3dzLWF6dXJlOnp1bW8ifQ.EUbTW2bHFd_7peTIuuADyxktphK33VMF7KdEOawMwbA";

        $this->access_token_url = "https://kms.kaiza.la/v1/accessToken"; //New Mawingu Customers group
        // $this->group_id = "cfd2279b-ef3e-4e6b-934b-5f2785de480b"; //Laikipia schools group
        $this->group_id = "be4384cc-a2f7-438f-adef-9e6dca0bd30f"; //Laikipiaschools group
        
    }

    public function send_announcement($message, $responder_phone)
    {
        // $responder_phone = "+254774834466";

        $curl = curl_init();

        $access_token = $this->generate_access_token();

        $send_data = array(
            "sendToAllSubscribers" => false,
            "subscribers" => array($responder_phone),
            "actionType" => "Announcement",
            "actionBody" => array(
                "title" => "School Submitted",
                "message" => $message,
            ),
        );

        $send_data_str = json_encode($send_data);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://kms.kaiza.la/v1/groups/" . $this->group_id . "/actions",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $send_data_str,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "accessToken: " . $access_token,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    private function generate_access_token()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->access_token_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "applicationId: " . $this->application_id,
                "applicationSecret: " . $this->application_secret,
                "refreshToken: " . $this->refresh_token,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response_obj = json_decode($response);
            return $response_obj->accessToken;
        }
    }

}
