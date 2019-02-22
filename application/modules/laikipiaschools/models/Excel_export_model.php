<?php
class Excel_export_model extends CI_Model
{
    public function fetch_data()
    {
        $this->db->order_by('school_id', DESC);
        $query = $this->db->get("school");
        return $query->result();
    }
}