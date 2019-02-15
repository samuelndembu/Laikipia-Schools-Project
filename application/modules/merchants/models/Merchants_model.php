<?php
class Merchants_model extends CI_Model 
{
    function fetch_merchant($phone, $password)
    {
        $this->db->select('*');
        $this->db->from('agents');
        $this->db->where("agent_password", md5($password));
        $this->db->like('cell', $phone, 'before');
        $merchant_details = $this->db->get();
        
        return $merchant_details;
    }

    function get_merchant_customers($merchant_id){
        $this->db->select('*');
        $this->db->from('mpesa_customer_register');
        $this->db->where('merchant_id', $merchant_id);
        $this->db->order_by('created_at',"DESC"); 
        return $this->db->get()->result();
    }

    function get_all_merchants(){
        $this->db->select('*');
        $this->db->from('agents');
        $this->db->limit(100);
        $query = $this->db->get();

        return $query->result();
    }
    // This function saves to the database.But before saving, 2 conditions have to be passed
    // 1. Confirm if they are a mawingu customer. if they are not, alert them that they are not a mawingu customer.
    // 2. If they are a mawingu customer, check if they have already been registered before in the system by another merchant.
    function save_customer($data,$phone_number)
    {
        //Verify if customer is a Mawingu customer
        $this->db->select("*");
        $this->db->where('username', $phone_number);
        $query = $this->db->get('customers');
        if(($query->num_rows() > 0))
        {
            //Verify if customer has already been saved
            $this->db->where('phone_number', $phone_number);
            $query2 = $this->db->get('mpesa_customer_register');
            if(($query2->num_rows() == 0))
            {
                //Verify if customer has transacted by M-Pesa
                if($this->check_transaction($phone_number))
                {
                    foreach($query->result() as $row){
                        $first_name = $row->firstName;
                        $last_name = $row->lastName;
                        $customer_name = $first_name . " " . $last_name;
                    }
                    $data['full_name'] = $customer_name;
                    // var_dump($data);die();
                    if( $this->db->insert("mpesa_customer_register", $data)){
                        return array(
                            "status" => "success",
                            "message" => "Customer successfully submitted"
                        );
                    }
                    else{
                        return array(
                            "status" => "error",
                            "message" => "Customer submission failed"
                        );
                    }
                }
                else{
                    return array(
                        "status" => "error",
                        "message" => "Customer has not yet transacted by M-Pesa"
                    );
                }
            }
            else{
                return array(
                    "status" => "error",
                    "message" => "Customer already registered by another merchant"
                );
            }

        }
        else{
            return array(
                "status" => "error",
                "message" => "Not a mawingu customer"
            );
        }

    }

    public function check_transaction($number)
    {
        // $number = ltrim($number, '+');
        // var_dump($number);die();
        // $where = array("msisdn" => $number, "resultCode" => "0");
        $where = "mpesalipatransaction.customerId = customers.id AND customers.username = '".$number."' AND resultCode = '0'";
        $this->db->select("mpesalipatransaction.*");
        $this->db->where($where);
        $query = $this->db->get("mpesalipatransaction, customers");

        if($query->num_rows() > 0)
        {
            return TRUE;
        }

        else
        {
            return FALSE;
        }
    }

    public function update_password($merchant_phone, $new_password){
        $this->db->where("cell", $merchant_phone);
        if($this->db->update("agents", array("agent_password" => md5($new_password)))){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
}