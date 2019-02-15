<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customers_model extends CI_Model
{
    //FUNCTION SAVES DETAILS
    //function to be called in sellers control
    public function save_customerdetails($save_data)
    {
        if ($this->db->insert("rubicon_customers", $save_data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    //get access code
    public function get_access_code()
    {
        $this->db->select("access_code_name");
        $this->db->where("customer_id IS Null");
        $this->db->limit(1);
        $query = $this->db->get("access_codes");
        if ($query->num_rows() == 1) {
            # code...
            $row = $query->row();
            $access_code_name = $row->access_code_name;
            return $access_code_name;
        }
        return false;
    }

}
