<?php
class Laikipiaauth extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->model('auth/auth_model');
        $this->load->model('admin/site_model');
     
    }

  

    /*
     *
     *    Login a user
     *
     */
    public function login_admin()
    {
        // //form validation rules

        //1. form validation rules
        if (($this->input->post('user_email') == 'admin@admin.com') && ($this->input->post('user_password') == '123456')) 
        {
            $this->form_validation->set_rules('user_email', 'Email address', 'required|valid_email');
            $this->form_validation->set_rules('user_password', 'Password', 'required');
        } 
        else 
        {
            $this->form_validation->set_rules('user_email', 'Email address', 'required|valid_email');
            $this->form_validation->set_rules('user_password', 'Password', 'required');
        }

        //2. Check if validaion rules pass
        if ($this->form_validation->run()) {
            //     //login hack
            if (($this->input->post('user_email') == 'admin@admin.com') && ($this->input->post('user_password') == '123456'))  {
                $newdata = array(
                    'login_status' => true,
                    'first_name' => 'Admin',
                    'other_name' => 'Patricia',
                    'username' => 'laikipia-schools',
                    'personnel_type_id' => '1',
                    'personnel_id' => 0,
                );

                $this->session->set_userdata("laikipia_admin",$newdata);

                $personnel_type_id = $this->session->userdata('personnel_type_id');

                if (!empty($personnel_type_id) && ($personnel_type_id != 1)) 
                {
                    redirect('administration/schools');
                   
                } 
                else 
                {
                    redirect('administration/schools');
                   
                }
            } 
            else if ($this->auth_model->validate_personnel()) 
            {
                redirect('administration/schools');
                
            }

            else
            {
                $this->session->set_flashdata('error', 'The Email address or password provided is incorrect. Please try again');
            }
        }

        //3. Condition of validation rules failed
        else {
            $validation_errors = validation_errors();
            if (!empty($validation_errors)) {
                $this->session->set_flashdata("error", $validation_errors);
            }

            $V_data['title'] = 'Admin Login';
            $data = array(
                "title" => "Admin Login",
                "content" => $this->load->view("auth/templates/laikipialogin", $V_data, true),
                "login" => true,
            );

            $this->load->view("auth/layouts/login", $data);
        }
        
    }

    public function logout()
    {
        $personnel_id = $this->session->userdata('laikipia_admin');
        $this->session->sess_destroy();
        redirect('administration/login');
    }

    /*
     *
     *    Dashboard
     *
     */
   

    

    
}
