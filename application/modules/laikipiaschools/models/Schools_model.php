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
    public function get_all_schools($table, $where, $start, $limit, $page, $order, $order_method)
    {
        $where = "school.deleted = 0";
        $this->db->select("*");
        $this->db->from("$table");
        $this->db->where($where);
        $this->db->limit($limit, $page);
        $this->db->order_by($order, $order_method);
        return $this->db->get();

    }
    public function change_school_status($school_id, $new_school_status)
    {

        $this->db->set('school_status', $new_school_status);
        $this->db->where('school_id', $school_id);
        if ($this->db->update('school')) {
            return true;
        } else {
            return false;
        }
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

    public function get_zones()
    {
        $result = $this->db->select('school_id, school_location_name')->get('zones')->result_array();

        $zone = array();
        foreach ($result as $r) {
            $zone[$r['school_id']] = $r['school_location_name'];
        }
        $zone[''] = 'Select School Zone...';
        return $zone;
    }

    public function get_location_dropdownlist()
    {
        $results = $this->db->select('school_id, school_location_name');
        $this->db->get('school');
        $this->db->result_array();

        return array_column($results, 'school_location_name', 'school_id');
    }

    public function update_school($school_id, $file_name, $thumb_name)
    {
        $data = array(
            "school_name" => $this->input->post("school_name"),
            "school_write_up" => $this->input->post("school_write_up"),
            "school_boys_number" => $this->input->post("school_boys_number"),
            "school_girls_number" => $this->input->post("school_girls_number"),
            "school_location_name" => $this->input->post("school_location_name"),
            "school_latitude" => $this->input->post("school_latitude"),
            "school_longitude" => $this->input->post("school_longitude"),
            "school_image_name" => $file_name,
            "school_thumb_name" => $thumb_name,
            "school_status" => $this->input->post("school_status"),
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