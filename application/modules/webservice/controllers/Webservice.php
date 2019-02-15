<?php 

defined('BASEPATH') OR exit('No direct script access allowed');  
  
class Webservice extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('webservice_model');
        $this->load->model('postgres_model');
    }

    public function index()
    {
        echo "Hello world";
    }

    public function update_customers()
    {
        //1. Get max id from Nanyukiappfactory
        $max_id = $this->webservice_model->get_customer_max_id();
        $to_date = date("Y-m-d H:i:s");
        $from_date = date('Y-m-d H:i:s', strtotime('-5 minutes'));
        $message;
        
        if($max_id != FALSE)
        {
            //2. Select all customers with greater ids than $max_id from Postgres
            $sql = "SELECT * FROM customers WHERE id > ".$max_id." LIMIT 100";
            
            $customers_array = $this->postgres_model->select_items($sql);
            
            if(is_array($customers_array))
            {
                $total_customers = count($customers_array);
                $count = $total_customers;

                //3. Insert new customers
                if($total_customers > 0)
                {
                    for($r = 0; $r < $total_customers; $r++)
                    {
                        $row = $customers_array[$r];

                        if($this->webservice_model->save_new_customer($row))
                        {
                            $message = $count . " customer(s) saved";
                            echo $row["firstName"]." ".$row["lastName"]." ".$row["id"]." saved <br/>";
                        }

                        else
                        {
                            $message =  $count . " customer(s) not saved";
                            echo"<span style='color:red;'>".$row["firstName"]." ".$row["lastName"]." ".$row["id"]." not saved </span><br/>";
                        }
                    }
                }

                else
                {
                    $message =  "No new customers found";
                    echo"<span style='color:red;'>No new customers found </span><br/>";
                }
            }

            else
            {
                $message =  "No new customers found";
                echo"<span style='color:red;'>No new customers found </span><br/>";
            }
        }

        else
        {
            $message =  "No new customers found";
            echo"<span style='color:red;'>No new customers found </span><br/>";
        }

       // $id = $this->sendActionCard($from_date, $to_date, $message);
        // echo "ActionId: ". $id;
    }

    private function getAccessToken()
    {
        // Connector details (Connector ID and secret)
        $applicationId = '7930b52c-5c44-4f30-bf86-8eb59185a4b2';
        $applicationSecret = '6WPLN1IOCQ';

        // From Kaizala auth 1.1
        $refreshToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MjYxNDkzNTFcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiNzkzMGI1MmMtNWM0NC00ZjMwLWJmODYtOGViNTkxODVhNGIyXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcImFsdmFyb0Nvbm5lY3RvclxcXCJ9XCJ9IiwidWlkIjoiTW9iaWxlQXBwc1NlcnZpY2U6ODZmZWI1MmMtMTRkNS00YTdkLTk4ZGEtYmEyYWI0NDBmMDhmIiwidmVyIjoiMiIsIm5iZiI6MTUzOTI2NzY1NiwiZXhwIjoxNTcwODAzNjU2LCJpYXQiOjE1MzkyNjc2NTYsImlzcyI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIiwiYXVkIjoidXJuOm1pY3Jvc29mdDp3aW5kb3dzLWF6dXJlOnp1bW8ifQ.EUbTW2bHFd_7peTIuuADyxktphK33VMF7KdEOawMwbA';

        // URL to fetch
        $CURL_URL = "https://kms.kaiza.la/v1/accessToken";

        // Performing the HTTP request
        $ch = curl_init($CURL_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'applicationId: ' . $applicationId,
            'applicationSecret: ' . $applicationSecret,
            'refreshToken: ' . $refreshToken,
            'Content-Type: application/json',
        )
        );
        $response_body = curl_exec($ch);
        curl_close($ch);

        $response_json = json_decode($response_body);
        return $response_json->accessToken;
    }

    private function sendActionCard($from_date, $to_date, $message)
    {
        $group_id = "5f35ad9e-8db4-4d2d-a1b4-4dbea41aec5b"; // Device Mo
        $url = "https://kms.kaiza.la/v1/groups/" . $group_id . "/actions";
        // echo $device.$sensor.$status.$date; die();
        $access_token = $this->getAccessToken();
        $request_data = array(
            "id" => "com.mawingu.new.customer.reg.3",
            "sendToAllSubscribers" => true,
            "actionBody" => array(
                "properties" => array(
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
        // var_dump($result);die();

        $response_json = json_decode($result);
        return $response_json->actionId;
    }
}