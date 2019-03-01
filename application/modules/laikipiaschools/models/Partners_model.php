<?php
class Partners_model extends CI_Model
{
    public function add_partners($file_name, $thumb_name)
    {
        $data = array(
            "partner_type_id" => $this->input->post("partner_type"),
            "partner_name" => $this->input->post("partner_name"),
            "partner_email" => $this->input->post("partner_email"),
            "partner_logo" => $file_name,
            "partner_thumb" => $thumb_name,

        );

        if ($this->db->insert("partner", $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }

    }

    public function get_partners($table, $where, $limit, $start, $order, $order_method)
    {
        // $where = "partner.deleted=0";
        $this->db->select("*");
        $this->db->from($table);
        $this->db->where($where);
        $this->db->limit($limit, $start);
        $this->db->join("partner_type", "partner.partner_type_id=partner_type.partner_type_id");

        $this->db->order_by($order, $order_method);

        return $this->db->get();
    }

    public function get_single_partner($partner_id)
    {
        $this->db->where("partner_id", $partner_id);
        return $this->db->get("partner");
    }
    public function all_partner_types()
    {
        $this->db->select("*");
        $this->db->from("partner_type");
        return $this->db->get();

    }
    //import function
   public function save_data( $save_data ){
        $this->db->insert('partner', $save_data ); #edited here
        echo $this->db->last_query();
        return 1;
    }

    public function change_partner_status($partner_id, $new_partner_status)
    {

        $this->db->set('partner_status', $new_partner_status);
        $this->db->where('partner_id', $partner_id);
        if ($this->db->update('partner')) {
            return true;
        } else {
            return false;
        }
    }

    //  public function deletepartner($partner_id){
    //     {
    //         $this->db->where('partner_id', $partner_id);
    //         $this->db->delete('partner');
    //     }

    public function get_partner_types()
    {
        $this->db->select("*");
        $this->db->from("partner_type");
        return $this->db->get();
    }

    public function update_partner($partner_id)
    {
        $data = array(
            "partner_type_id" => $this->input->post("partner_type"),
            "partner_name" => $this->input->post("partner_name"),
            "partner_email" => $this->input->post("partner_email"),

        );
        $this->db->set($data);
        $this->db->where('partner_id', $partner_id);

        if ($this->db->update('partner')) {
            return true;
        } else {
            return false;
        }

    }
    public function delete_partners($partner_id)
    {
        $data = array(
            'deleted' => 1,
            'deleted_by' => 1,
            'deleted_on' => date("Y-m-d H:i:s"),
        );

        $this->db->set($data);
        $this->db->where('partner_id', $partner_id);
        if ($this->db->update('partner')) {
            return true;
        } else {
            return false;
        }
    }

}
