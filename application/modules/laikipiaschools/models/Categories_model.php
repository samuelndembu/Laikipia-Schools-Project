<?php
class Categories_model extends CI_Model
{
    public function get_categories($table, $where, $limit, $start, $order, $order_method)
    {
        // $where = "category.deleted=0";
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
     public function fetch_all_categories()
     {
         $this->db->select("category_parent");
         $this->db->from("category");
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
            "category_name" => $this->input->post("category_name"),

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
    //import function
    function import_record($record)
    {
        // echo json_encode($record);die();
      if(count($record) > 0){
          
        // Check partner
        $this->db->select('*');
        $this->db->where('partner_name', $record[1]);
        $q = $this->db->get('partner');
        $response = $q->result_array();
   
        // Insert record
        if(count($response) == 0){
          $newpartner = array(
            "partner_type_id" => trim($record[0]),
            "partner_name" => trim($record[1]),
            "partner_email" => trim($record[2]),
           
          );
          return $this->db->insert('partner', $newpartner);
        }
        else
        {
            return FALSE;
        }
   
      }
   
    }
    
    
}
?>