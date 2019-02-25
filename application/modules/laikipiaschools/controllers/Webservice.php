<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Webservice extends MX_Controller
{
    public $upload_path;
    public $upload_location;
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

        $this->upload_path = realpath(APPPATH . '../assets/uploads/schools');
        $this->upload_location = base_url() . 'assets/uploads/schools/';
        $this->load->model('schools_model');
        $this->load->model('kaizala_model');
    }

    public function get_school_details()
    {
        $json_string = file_get_contents("php://input");

        $json_obj = json_decode($json_string);
        // var_dump(count($json_obj));

        if (is_array($json_obj)) 
        {
            $row = $json_obj[0];
            // echo json_encode($row);die();
            $school_name = json_decode($row->school_name)[0];
            $school_boys_number = $row->school_boys_number;
            $school_girls_number = $row->school_girls_number;
            $school_zone = json_decode($row->school_zone)[0];
            $school_write_up = $row->school_write_up;
            $school_image = $row->school_image_name;
            $school_longitude = json_decode($row->school_location)->lg;
            $school_latitude = json_decode($row->school_location)->lt;
            $school_location_name = json_decode($row->school_location)->n;
            $school_other_images_arr = json_decode($row->school_other_images);
            $responder_phone = $row->responder_phone;

            $school_image_name = $this->schools_model->save_image($school_image, $this->upload_path);

            // echo json_encode($school_other_images_arr);die();

            $data = array(
                'school_name' => $school_name,
                'school_boys_number' => $school_boys_number,
                'school_girls_number' => $school_girls_number,
                'school_zone' => $school_zone,
                'school_write_up' => $school_write_up,
                'school_location_name' => $school_location_name,
                'school_image_name' => $school_image_name,
                'school_thumb_name' => $school_image_name,
                'school_longitude' => $school_longitude,
                'school_latitude' => $school_latitude,
            );

            $result = $this->schools_model->save_school_flow('school', $data);

            if ($result != false) 
            {
                if (is_array($school_other_images_arr) || $school_other_images_arr != null) 
                {

                    $school_id = $result;

                    foreach ($school_other_images_arr as $image) 
                    {
                        //download image and save to uploads folder
                        //return the image name
                        $school_other_image_name = $this->schools_model->save_image($image->mediaUrl, $this->upload_path);

                        $other_image_data = array(
                            'school_image_name' => $school_other_image_name,
                            'school_id' => $school_id,
                        );

                        $images_result = $this->schools_model->save_school_flow('school_images', $other_image_data);
                        // echo json_encode($school_other_image_name);die();
                    }

                }

                $message = 'School submitted successfully! Thank you';

            } 
            else 
            {

                $message = 'Failed to submit school. Please resubmit!!';
                
            }

            //send announcement to kaizala
            $response = $this->kaizala_model->send_announcement($message, $responder_phone);

            echo json_encode($response);
        }
    }

}
