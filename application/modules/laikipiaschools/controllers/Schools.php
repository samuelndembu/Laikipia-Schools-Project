<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once "./application/modules/admin/controllers/Admin.php";

class Schools extends admin
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("laikipiaschools/schools_model");
        // $this->load->model("laikipiaschools/payments_model");
    }
    public function index($start = null)
    {
        // echo 1;die();

        $this->form_validation->set_rules("school_name", "School Name", "required");
        $this->form_validation->set_rules("school_write_up", "School Write Up", "required");
        $this->form_validation->set_rules("school_boys_number", "Number of Boys", "required");
        $this->form_validation->set_rules("school_girls_number", "Number of Girls", "required");
        $this->form_validation->set_rules("school_location_name", "Location", "required");
        $this->form_validation->set_rules("school_latitude", "Latitude", "required");
        $this->form_validation->set_rules("school_longitude", "Longitude", "required");
        // $this->form_validation->set_rules("school_status", "Status", "required");

        //  validate
        $form_errors = "";

        if ($this->form_validation->run()) {
            // echo 1;die();
            $data["form_errors"] = validation_errors();

            $school_id = $this->schools_model->add_school();
            // echo $school_id;die();
            if ($school_id > 0) {
                $this->session->flashdata("success_message", "New school ID" . $school_id . "has been added");

                redirect("laikipiaschools/schools");
            } else {
                $this->session->flashdata("error_message", "Unable to add  school");
                redirect("laikipiaschools/schools");

            }
        } else {
//             echo validation_errors();
            // ;die();

            $config["base_url"] = base_url() . "schools/schools/index";
            $config["total_rows"] = $this->schools_model->countAll();
            $config["per_page"] = 4;

            $v_data["all_schools"] = $this->schools_model->get_all_schools($config["per_page"], $start);

            $this->pagination->initialize($config);

            $v_data['links'] = $this->pagination->create_links();
            $v_data['counter'] = $start;

            $data = array(
                "title" => $this->site_model->display_page_title(),
                "content" => $this->load->view("schools/all_schools", $v_data, true),
            );

            $this->load->view("laikipiaschools/layouts/layout", $data);

        }

    }

    public function singleSchool($school_id)
    {
        $school = $this->schools_model->get_single_school($school_id);
        if ($school->num_rows() > 0) {
            //  $age, $gender, $hobby
            $row = $school->row();
            $school_name = $row->school_name;
            $School_write_up = $row->School_write_up;
            $school_boys_number = $row->school_boys_number;
            $school_girls_number = $row->school_girls_number;
            $school_location_name = $row->school_location_name;
            $school_latitude = $row->school_latitude;
            $school_longitude = $row->school_longitude;
            $school_status = $row->school_status;
            $data = array(
                'school_name' => $school_name,
                'School_write_up' => $School_write_up,
                'school_boys_number' => $school_boys_number,
                'school_girls_number' => $school_girls_number,
                'school_location_name' => $school_location_name,
                'school_latitude' => $school_latitude,
                'school_longitude' => $school_longitude,
                'school_status' => $school_status,
            );
            $this->load->view('welcome_here', $data);

        } else {
            $this->session->set_flashdata("error_message, could not find your school");
            redirect("schools");
        }
        //  pass the date
    }
    public function add_school()
    {
        $this->form_validation->set_rules("school_name", "School Name", "required");
        $this->form_validation->set_rules("School_write_up", "School Write Up", "required");
        $this->form_validation->set_rules("school_boys_number", "Number of Boys", "required");
        $this->form_validation->set_rules("school_girls_number", "Number of Girls", "required");
        $this->form_validation->set_rules("school_location_name", "Location", "required");
        $this->form_validation->set_rules("school_latitude", "Latitude", "required");
        $this->form_validation->set_rules("school_longitude", "Longitude", "required");
        $this->form_validation->set_rules("school_status", "Status", "required");

        //  validate
        $form_errors = "";

        if ($this->form_validation->run()) {
            $school_id = $this->schools_model->add_school();
            if ($school_id > 0) {
                $this->session->flashdata("success_message", "New school ID" . $school_id . "has been added");

                redirect("schools");
            } else {
                $this->session->flashdata("error_message", "Unable to add  school");

            }
        } else {
            $data["form_errors"] = validation_errors();
            $this->load->view("schools/add_school", $data);
        }
    }
    public function edit_school($school_id)
    {
        $this->form_validation->set_rules("school_name", "School Name", "required");
        $this->form_validation->set_rules("school_write_up", "school Write Up", "required");
        $this->form_validation->set_rules("school_boys_number", "Number of Boys", "required");
        $this->form_validation->set_rules("school_girls_number", "Number of Girls", "required");
        $this->form_validation->set_rules("school_location_name", "Location", "required");
        $this->form_validation->set_rules("school_latitude", "Latitude", "required");
        $this->form_validation->set_rules("school_longitude", "Longitude", "required");
        // $this->form_validation->set_rules("school_status", "Status", "required");

        if ($this->form_validation->run()) {
            if ($this->schools_model->update_school($school_id)) {
                $this->session->set_flashdata('success', 'school ID: ' . $school_id . ' updated successfully');

                redirect('laikipiaschools/schools');
            } else {
                $this->session->set_flashdata('error', 'Unable to update: ' . $school_id);

                // $v_data['schools'] = $this->schools_model->all_schools();

                $v_data['title'] = "Edit school";
                $data['content'] = $this->load->view('schools/edit_school', $v_data, true);

                $this->load->view("laikipiaschools/layouts/layout", $data);
            }
        } else {
            $school = $this->schools_model->get_single_school($school_id);

            $row = $school->row();
            $v_data['school_name'] = $row->school_name;
            $v_data['school_write_up'] = $row->school_write_up;
            $v_data['school_boys_number'] = $row->school_boys_number;
            $v_data['school_girls_number'] = $row->school_girls_number;
            $v_data['school_location_name'] = $row->school_location_name;
            $v_data['school_latitude'] = $row->school_latitude;
            $v_data['school_longitude'] = $row->school_longitude;
            $v_data['school_status'] = $row->school_status;

            $v_data['query'] = $this->schools_model->get_single_school($school_id);
            // $v_data['schools'] = $this->schools_model->all_schools();

            $v_data['title'] = "Edit school";
            $data['content'] = $this->load->view('schools/edit_school', $v_data, true);

            $this->load->view("laikipiaschools/layouts/layout", $data);
        }

    }

    public function single_school($school_id)
    {
        $v_data['query'] = $this->schools_model->get_single_school($school_id);
        $v_data['title'] = "View";
        $query = $this->schools_model->get_single_school($school_id);

        $data['content'] = $this->load->view('schools/single_school', $v_data, true);

        $this->load->view("laikipiaschools/layouts/layout", $data);
    }
    public function delete_school($school_id)
    {
        if ($this->schools_model->delete_school($school_id)) {
            $this->session->set_flashdata('success', 'Deleted successfully');
            redirect('laikipiaschools/schools');
        } else {
            $this->session->set_flashdata('error', 'Unable to delete, Try again!!');
            redirect('laikipiaschools/schools');
        }
    }
    public function bulk_actions()
    {
        $this->form_validation->set_rules('action_name', 'Action', 'required');

        //if form conatins invalid data
        if ($this->form_validation->run()) {
            $school_id_array = $_POST['school_id'];
            $action_name = $this->input->post('action_name');

            $total_schools = count($school_id_array);

            if ($total_schools > 0) {
                foreach ($school_id_array as $key => $value) {
                    if ($action_name == "delete") {
                        $this->schools_model->delete_school($value);
                    } else {

                    }
                }

                $schools = "schools";
                if ($total_schools == 1) {
                    $schools = "school";
                }
                $this->session->set_userdata('success_message', $action_name . " of " . $total_schools . " " . $schools . "  successfull");
            } else {
                $this->session->set_userdata('error_message', "No schools have been selected");
            }
        } else {
            $validation_errors = validation_errors();
            if (!empty($validation_errors)) {
                $this->session->set_userdata("error_message", $validation_errors);
            }
        }

        redirect("laikipiaschools/schools");
    }
}
