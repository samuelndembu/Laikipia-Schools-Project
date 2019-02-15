<?php

class Donations_model extends CI_Model
{
    /*
     *    Retrieve all sections
     *    @param string $table
     *     @param string $where
     *
     */
    public function get_all_donations($table, $where, $per_page, $page, $order = 'created_on', $order_method = 'DESC')
    {
        $this->db->from($table);
        $this->db->where($where);
        $this->db->order_by($order, $order_method);
        $query = $this->db->get('', $per_page, $page);

        return $query;
    }

    public function all_schools()
    {
        $where = "deleted=0";
        $this->db->select("*");
		$this->db->from("school");
		$this->db->where($where);
        return $this->db->get();
    }

    public function all_partners()
    {
		$where = "deleted=0";
        $this->db->select("*");
		$this->db->from("partner");
		$this->db->where($where);
        return $this->db->get();
    }

    public function get_single_donation($donation_id)
    {
        $where = 'donation_id=' . $donation_id;
        $this->db->select("*");
        $this->db->from("donation");
        $this->db->where($where);
        return $this->db->get();
    }

    public function update_donation($donation_id)
    {
        $data = array(
            'donation_amount' => $this->input->post("donation_amount"),
            'partner_id' => $this->input->post("partner_id"),
            'school_id' => $this->input->post("school_id"),
        );

        $this->db->set($data);
        $this->db->where('donation_id', $donation_id);
        if ($this->db->update('donation')) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_donation($donation_id)
    {
        $data = array(
            'deleted' => 1,
            'deleted_by' => 1,
            'deleted_on' => date("Y-m-d H:i:s"),
        );

        $this->db->set($data);
        $this->db->where('donation_id', $donation_id);
        if ($this->db->update('donation')) {
            return true;
        } else {
            return false;
        }
    }

    public function create_donation()
    {
        $data = array(
            'donation_amount' => $this->input->post("donation_amount"),
            'partner_id' => $this->input->post("partner_id"),
            'school_id' => $this->input->post("school_id"),
        );

        if ($this->db->insert('donation', $data)) {
            return true;
        } else {
            return false;
        }
    }
}
