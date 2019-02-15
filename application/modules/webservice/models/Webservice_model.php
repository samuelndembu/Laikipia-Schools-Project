<?php
class Webservice_model extends CI_Model 
{
    public function get_customer_max_id()
    {
        $this->db->select_max("id");
        $query = $this->db->get("customers");

        if($query->num_rows() > 0)
        {
            $row = $query->row();
            $max_id = $row->id;

            return $max_id;
        }

        else
        {
            return FALSE;
        }
    }

    public function save_new_customer($row)
    {
        //1. Check if customer exists
        if($this->customer_exists($row["id"]))
        {
            return FALSE;
        }

        else
        {
            //Save if customer does not exist
            if($this->db->insert("customers", $row))
            {
                return TRUE;
            }
    
            else
            {
                return FALSE;
            }
        }
    }

    private function customer_exists($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get("customers");

        if($query->num_rows() > 0)
        {
            return TRUE;
        }

        else
        {
            return FALSE;
        }
    }
}