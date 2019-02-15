<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Registers extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('auth/auth_model');
        $this->load->model('merchants_model');
        $this->load->model('admin/site_model');
		
		if(!$this->auth_model->check_merchant_login())
		{
			redirect('merchants/login');
		}
    }
	
    public function save_client()
    {
        $merchant_first_name = $this->input->post('firstName');
        $merchant_cell = $this->input->post('cell');
        //$full_name = $this->input->post('fullName');
        $location = $this->input->post('location');
        //var_dump( $this->input->post()); die();
        $phone_number = $this->input->post('phoneNumber');
        //validation details
        if ($phone_number[1] == 2 && $phone_number[2] == 5 && $phone_number[3] == 4) {
            $validated_number = $phone_number;
        } else {
            $validated_number = $phone_number[0] == 0 ? "+254" . substr($phone_number, 1, 9) : ($phone_number[0] == 7 ? "+254" . $phone_number : ($phone_number[0] == 2 && $phone_number[1] == 5 && $phone_number[2] == 4 ? "+" . $phone_number : $phone_number));
        }

        $merchant_id = $this->input->post('merchantId');
        $data = array(
            'merchant_location' => $location,
            'phone_number' => $validated_number,
            'agent_firstName' => $this->session->userdata("firstName"),
            'agent_lastName' => $this->session->userdata("lastName"),
            'agent_phoneNumber' => $this->session->userdata("cell"),
            "merchant_id" => $merchant_id,
            "created_at" => date('Y-m-d H:i:s'),
        );
        
        //var_dump($data["fullName"]);
        $array_message = $this->load->merchants_model->save_customer($data, $validated_number);
        $this->session->set_flashdata($array_message['status'], $array_message['message']);
        redirect('mpesa/profile');
        // $this->load->view('merchant',$result);

    }

    public function merchant_profile()
    {
        $merchant_id = $this->session->userdata('merchantId');
        $data = array(
            "cell" => $this->session->userdata('cell'),
            "firstName" => $this->session->userdata('firstName'),
            "merchantId" => $merchant_id,
            "customers" => $this->merchants_model->get_merchant_customers($merchant_id),
        );

        $this->load->view('merchant', $data);
    }
    //creating a client
    public function create_client()
    {
        $this->load->view('create_customer');
    }

    //return human readable format of time
    // private function getTime($secs)
    // {
    //     $timeBits = array(
    //         'y' => $secs / 31556926 % 12,
    //         'w' => $secs / 604800 % 52,
    //         'd' => $secs / 86400 % 7,
    //         'h' => $secs / 3600 % 24,
    //         'm' => $secs / 60 % 60,
    //         's' => $secs % 60,
    //     );

    //     foreach ($timeBits as $timeName => $value) {
    //         if ($value > 0) {
    //             $time[] = $value . $timeName;
    //         }
    //     }

    //     return join(' ', $time);
    // }

    public function logout()
    {
        $this->session->unset_userdata("phoneNumber");
        redirect(base_url() . 'mpesa/login');
    }

    public function encrypt()
    {
        echo md5(123456);
    }

    public function change_password()
    {
        $this->form_validation->set_rules('current_password', 'Current Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|matches[confirm_password]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required');

        if ($this->form_validation->run()) {
            $merchant_phone = $this->session->userdata('cell');
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password');

            $merchant_customers = $this->merchants_model->fetch_merchant($merchant_phone, $current_password);

            if ($merchant_customers) {

                if ($this->merchants_model->update_password($merchant_phone, $new_password)) {
                    $this->session->set_flashdata('success', 'Password changed successfully');
                    redirect("merchant/profile");
                } else {
                    $this->session->set_flashdata('error', 'Unable to change your password');
                }
            } else {
                $this->session->set_flashdata('error', 'Your current password is invalid');
            }
        } else {
            $validation_errors = validation_errors();
            if (!empty($validation_errors)) {
                $this->session->set_flashdata('error', $validation_errors);
            }
        }
        $data["title"] = "Change Password";
        $this->load->view('change_password', $data);
    }
}
