<?php
class Categories_model extends CI_Model
{
    public function get_categories($table, $where, $limit, $start, $order, $order_method)
    {
        $where = "category.deleted=0";
        $this->db->select("*");
        $this->db->from($table);
        $this->db->where($where);
        $this->db->limit($limit, $start);
        //$this->db->join("partner_type", "partner.partner_type_id=partner_type.partner_type_id");
        $this->db->order_by($order, $order_method);

        return $this->db->get();
    }

    
    public function add_category()
    {
        $data = array(
        "category_parent" => $this->input->post("category_parent"),
        "category_name" => $this->input->post("category_name"),
        "category_status" => 1
        );
         
        if($this->db->insert("category",$data))
        {
        return $this->db->insert_id();
        }else
        {
        return FALSE;
        }
         
     }
     public function get_single_category($category_id)
     {
         $this->db->where("category_id", $category_id);
         return $this->db->get("category");
     }
     public function all_categories()
     {
         $this->db->select("*");
         $this->db->from("partner_type");
         return $this->db->get();
 
     }


     public function change_category_status($category_id, $new_category_status)
    {

        $this->db->set('category_status', $new_category_status);
        $this->db->where('category_id', $category_id);
        if ($this->db->update('category')) {
            return true;
        } else {
            return false;
        }
    }

    public function update_category($category_id)
    {
        $data = array(
            "category_parent" => $this->input->post("category_parent"),
            "categoy_name" => $this->input->post("category_name"),

        );
        $this->db->set($data);
        $this->db->where('category_id', $category_id);

        if ($this->db->update('category')) {
            return true;
        } else {
            return false;
        }

    }

    public function delete_categories($category_id)
    {
        $data = array(
            'deleted' => 1,
            'deleted_by' => 1,
            'deleted_on' => date("Y-m-d H:i:s"),
        );

        $this->db->set($data);
        $this->db->where('category_id', $category_id);
        if ($this->db->update('category')) {
            return true;
        } else {
            return false;
        }
    }
    
    
}
?>