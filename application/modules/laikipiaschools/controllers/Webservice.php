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

        // $json_string = '[
        //     {
        //       "school_name": "Inoro",
        //       "school_boys_number": 0,
        //       "school_girls_number": "180",
        //       "school_zone": "[\"Ngobit\"]",
        //       "school_write_up": "Hahaha ",
        //       "school_image_name": "https://cdn.inc-000.kms.osi.office.net/att/67e6f25ff4bffcf095b332f3cb50527c9c20cfaaa86e18c18704f95874659150.jpg?sv=2015-12-11&sr=b&sig=tB13ug7uXcYNeTXoj42wQghViaus7Nx0TB4gIJSXG0A%3D&st=2019-02-22T13:13:09Z&se=2292-12-07T14:13:09Z&sp=r&mdId=EABo+i2wGydIE+vACkplQX3v4WM1zlF71F/C0OjKFVxm4lYxScoOE2dbqkDhCbCsd+qZF8O3KHj+1KG8JFYe6zDodySeT2IzDwtihJ9xNloFxaM8lfrqX4Yw/Jb/Drp+zf4gxzRE+PfWOyKOhlZmLG/qeGa6ziR09AYWK23hKAZAWfvBVTEuCog7IroqHWd/4ckwhF2gawe9h/ohqlYm1Z5W6asE82zSAasRJ0nIfibNbCmndvijuUKsVt5/ogRBTsQl3UBDeqbcgPuh72F9Jaxs9GXX1kqO0E24+O/NdtS+IQ==",
        //       "school_other_images": "[{\"mediaUrl\":\"https://cdn.inc-000.kms.osi.office.net/att/3059352f6cca06b6160246b7461796fffefa18097abb6c00ca00e2adce6cf603.jpg?sv=2015-12-11&sr=b&sig=Ty6y%2B76ZSvS6w6GgUYey2gu4ChoBL5rMzjDGnq5VFIk%3D&st=2019-02-22T13:13:09Z&se=2292-12-07T14:13:09Z&sp=r&mdId=EAB21QK2G1eRS/KfHCLEElN4TjwDLa7H6H+EsN2lOAfL3d90LjBXzclwQ3GhKZheX5vF2j9/0BehTys1KmZYLLfXThM/J2xT3QyMZ+UqNJnvDbXFNwh7O3NFb/FvBrLlPREeuOSSdc+Dj7GoTU3g0VnCrOVbwPquwOwHwYM5B8uC5qxmJRrfBgviutHrFKpUYYrbD3slm8ng1lhLlRaLSED79NFvaNFHyuIChFKlMYd3KrC3e5yodPgw2FI4GI59CixxaBRv/2p10IBzY3w8Jxq4A8JJSielDl84LUUZKmjMXw==\",\"mediaFileName\":\"IMG_19-02-22_171304232_9.jpg\"},{\"mediaUrl\":\"https://cdn.inc-000.kms.osi.office.net/att/4b95fd48d5153fb09acf8d3d26cfa63db37f12e089ee275798d36e09c1dae6da.jpg?sv=2015-12-11&sr=b&sig=j%2BUkq27Il01oRxortwHp2d75Q8jhyKcoJxm5PVhR2DQ%3D&st=2019-02-22T13:13:10Z&se=2292-12-07T14:13:10Z&sp=r&mdId=EADGpaEUKtSEQNqQKHPOiCjbRaeR7Etd5v2Z3zOg6ztfh4stvE2tYE3vtCWypRKhoyAlrWuh4Wh9Wr4JSe8/Dn70+dm7gbgqRMUzRgQL+wkMiWZFy5Oa9sI0Pcw9VWjLTpqNOBTdz8uPIQzByqsYlI6s/ufyJadNpCeVkbY/amN/DPxoKoZHy6H2D5S1+brc8OAcCdemVLwF0PATpuzIc8IVo1UbW/2MdpTMRtxGm1JXEce+qd0DopfESwGzlbngtMy9j2c2sYhDsrBh9smXdG4HRilVNzkF/wQ9Q7YH1d0WpQ==\",\"mediaFileName\":\"IMG_19-02-22_171304443_10.jpg\"}]",
        //       "school_location": "{\"lt\":0.0182242,\"lg\":37.0741214,\"n\":\"2nd Floor, Cedar Mall, P.O. Box 3168-10400 Nanyuki, Nanyuki-Rumuruti Rd, Nanyuki, Kenya\",\"acc\":19.284999847412109}",
        //       "responder_phone": "+254710967675"
        //     }
        // ]';

        $json_obj = json_decode($json_string);
        // var_dump(count($json_obj));

        if (is_array($json_obj)) {
            $row = $json_obj[0];
            // echo json_encode($row);die();
            $school_name = $row->school_name;
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
                'school_longitude' => $school_longitude,
                'school_latitude' => $school_latitude,
            );

            $result = $this->schools_model->save_school_flow('school', $data);
            if ($result != false) {
                if (is_array($school_other_images_arr) || $school_other_images_arr != null) {

                    $school_id = $result;

                    foreach ($school_other_images_arr as $image) {
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

            } else {
                $message = 'Failed to submit school. Please resubmit!!';
            }

            //send announcement to kaizala
            $response = $this->kaizala_model->send_announcement($message, $responder_phone);

            echo json_encode($response);
        }
    }

}
