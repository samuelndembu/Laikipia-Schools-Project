<?php
class File_model extends CI_Model
{
    public function upload_image($upload_path, $field_name, $resize)
    {
        $config = array(
            "allowed_types" => "JPEG|JPG|jpeg|jpg|png|PNG",
            "upload_path" => $upload_path,
            "quality" => "100%",
            "max_size" => "0",
            "min_width" => "300",
            "min_height" => "300",
            "file_name" => md5(date("Y-m-d H:i:s")),
        );

        $response = [];
        $this->load->library("upload", $config);

        // var_dump($this->input->post($field_name));die();

        if (!$this->upload->do_upload($field_name)) {
            $response["check"] = false;
            $response["message"] = $this->upload->display_errors();
        } else {
            $image_upload_data = $this->upload->data();
            $file_name = $image_upload_data["file_name"];
            $file_path = $image_upload_data["file_path"];

//Resize uploaded image
            $resize_upload = $this->resize_image($image_upload_data["full_path"], $resize);
            if ($resize_upload == true) {
//create thumbnail
                //Thumbnail size
                $resize_thumb = array(
                    "width" => 100,
                    "height" => 100
                );
                //   Thumbnail properties
                $thumb_name = "thumbnail_" . $file_name;
                $thumb_array = array("thumb_path" => $file_path . "thumbnail_" . $file_name);


             $create_thumb = $this->resize_image($image_upload_data["full_path"], $resize_thumb, $thumb_array);
                if ($create_thumb == true) {
                    $response["check"] = true;
                    $response["file_name"] = $file_name;
                    $response["thumb_name"] = $thumb_name;
                } else {
                    $response["check"] = false;
                    $response["message"] = $create_thumb;
                }
            } else {
                $response["check"] = false;
                $response["message"] = $resize_upload;
            }
        }

        return $response;
    }
    // public function multiple_upload($field_name, $cof = array()){
    // $files = $_FILES[$file_name];
    // $file_upload = sizeOf($_FILES[$file_name]['tmp_name];
    // $image = array();
    // $multiple = array();

    // for($i = 0; $i < $file_upload; $i++){
    //     $_FILES[$field_name]['name'] = $files['name'][$i],
    //     $_FILES[$field_name]['type'] = $files['types'][$i];
    //     $_FILES[$field_name]['error'] = $files['error'][$i];
    //     $_FILES[field_name]['size'] = $files['size'][$i];

    //     $upload_path =FCPATH.$conf['upload_path'];
    //     if(!is_dir($upload_path))
    //     mkdir($upload_path, 0777, true);

    //     $config = array(
    //         'upload_path'=> $upload_path'
    //         'allowed_types' => $config['allowed_types'],
    //         'max_size' => 0,
    //         'encrypt' => true
    //     );
    //     $this->Ci->uplod->initialize($config);
    //     if($this->CI->upload->do_upload($field_name)){
    //         $data = $this->CI->upload->data();
    //         chmod(data['fulll_path', 0777]);

    //         $multiple[i] = $data['file_name'];
    //     }
    // // }
    // // return $multiple
    // // }

    public function resize_image($source_image, $resize, $thumbnail = false)
    {
        $resize_config = array(
            "source_image" => $source_image,
            "width" => $resize["width"],
            "height" => $resize["height"],
            "master_dim" => "width",
            "maintain_ratio" => true,
        );
        if ($thumbnail != false) {
            $resize_config["new_image"] = $thumbnail["thumb_path"];
            $resize_config["create_thumb"] = false;

        } 
        $this->image_lib->initialize($resize_config);

        if (!$this->image_lib->resize()) {
            return $this->image_lib->display_errors();
        } else {
            return true;
        }
    }
    
}