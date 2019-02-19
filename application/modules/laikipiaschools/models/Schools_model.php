<?php
class Schools_model extends CI_Model
{
    public function add_school($file_name, $thumb_name)
    {
        // create an array of The data to save
        $data = array(
            "school_name" => $this->input->post("school_name"),
            "school_write_up" => $this->input->post("school_write_up"),
            "school_boys_number" => $this->input->post("school_boys_number"),
            "school_girls_number" => $this->input->post("school_girls_number"),
            "school_location_name" => $this->input->post("school_location_name"),
            "school_image_name" => $file_name,
            "school_thumb_name" => $thumb_name,

            "school_latitude" => $this->input->post("school_latitude"),
            "school_longitude" => $this->input->post("school_longitude"),
            "school_status" => $this->input->post("school_status"),

        );

        if ($this->db->insert("school", $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    public function get_all_schools()
    {
        $this->db->order_by("created_on ", "DESC");
        // var_dump($this->db->get("school")->result());die();
        return $this->db->get("school");
    }
    public function get_single_school($school_id)
    {
        $this->db->where("school_id", $school_id);
        return $this->db->get("school");
    }
    public function countAll()
    {
        return $this->db->get("school")->num_rows();
    }
    public function delete_school($school_id)
    {
        $data = array(
            'deleted' => 1,
            'deleted_by' => 1,
            'deleted_on' => date("Y-m-d H:i:s"),
        );

        $this->db->set($data);
        $this->db->where('school_id', $school_id);
        if ($this->db->update('school')) {
            return true;
        } else {
            return false;
        }
    }
    public function update_school($school_id)
    {
        $data = array(
            "school_name" => $this->input->post("school_name"),
            "school_write_up" => $this->input->post("school_write_up"),
            "school_boys_number" => $this->input->post("school_boys_number"),
            "school_girls_number" => $this->input->post("school_girls_number"),
            "school_location_name" => $this->input->post("school_location_name"),
            "school_latitude" => $this->input->post("school_latitude"),
            "school_longitude" => $this->input->post("school_longitude"),
            "school_status" => 1,
        );

        $this->db->set($data);
        $this->db->where('school_id', $school_id);
        if ($this->db->update('school')) {
            return true;
        } else {
            return false;
        }
    }

}
