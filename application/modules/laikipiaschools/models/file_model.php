<?php class File_model extends Ci_model
{
    public function upload_image($upload_path, $field_name, $resize)
    {
        $config = array(
            "allowed_types" => "JPG|JPEG|jpg|png|PNG",
            "upload_path" => $upload_path,
            "quality" => "100%",
            "max_size" => "0",
            "min_width" => "300",
            "min_height" => "300",
            "file_name" => md5(date("Y-m-dH:i:s")),
        );
        $response = [];
        $this->load->library("upload", $config);

        if (!$this->upload->do_upload($field_name)) {
            $response["check"] = false;
            $response["message"] = $this->upload->display_errors();
        } else {
            $image_upload_data = $this->upload->data();
            $file_name = $image_upload_data["file_name"];
            $file_path = $image_upload_data["file_path"];

            $resize_upload = $this->resize_image($image_upload_data["full_path"]);
            if ($resize_upload == true) {
                //createc thnumbnail
                $resize_thumb = array(
                    "width" => 100,
                    "height" => 100,
                );
                //   Thumbnail properties
                $thmb_name = "thumbnail_" . $file_name;
                $thumb_array = array(
                    "thumbnail" => $file_path . "thumbnail_" . $file_name,
                );
                $create_thumb = $this->resize_image($image_upload_data["full_path"], $resize_thumb);
                if ($create_thumb == true) {
                    $response["check"] = true;
                    $response["file_name"] = $file_name;
                    $response["thumb_name"] = $thumb_name;
                }
            } else {
                $response["check"] = false;
                $response["message"] = $this->upload->$create_thumb;
            }

        }
    }
    public function resize_image($source_image, $resize, $thumbnail = false)
    {
        $resize_config = array(
            "source_image" => $image_upload_data["full_path"],
            "width" => $resize["width"],
            "height" => $resize["height"],
            "master_dim" => "width",
            "maintain_ratio" => true,
        );
        if ($thumbnail != false) {
            $resize_config["new_image"] = $thumbnail["thumb_path"];
            $resize_config["create_thumb"] = false;

        } else {
            $response["check"] = false;
            $response["message"] = $this->upload->$resize_upload;
        }
        $this->image_lib->initialize($resize_config);

        if (!$this->image_lib->resize()) {
            return $this->image_lib->display_errors();
        } else {
            return true;
        }
    }
}
