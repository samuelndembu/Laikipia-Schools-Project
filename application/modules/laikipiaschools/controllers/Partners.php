    <?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
    }

    require_once "./application/modules/admin/controllers/Admin.php";

    class Partners extends admin
    {
    public $upload_path;
    public $upload_location;

    public function __construct()
    {
    parent::__construct();
    $this->load->model("laikipiaschools/partners_model");
    $this->load->model("laikipiaschools/file_model");
    // $this->load->model("reports/payments_model");
   
    $this->upload_path = realpath(APPPATH. "../assets/uploads");
    $this->upload_location = base_url()."assets/uploads";

    $this->load->library("image_lib");
    }

    /*
    *
    *    Default action is to show all the transactions
    *
    */
    public function index()
    {

    $v_data["query"] = $this->partners_model->get_partners();
    $v_data["partner_types"] = $this->partners_model->get_partner_types();

    $data = array("title" => "Partner",
    "content" => $this->load->view("partners/all_partners", $v_data, true),

    );
    $this->load->view("laikipiaschools/layouts/layout", $data);
    }
    public function read_partner($partner_id)
    {
    $my_partner = $this->partners_model->get_single_partner($partner_id);
    if ($my_partner->num_rows() > 0) {
    $row = $my_partner->row();
    $partner_type_id = $row->partner_type_id;
    $partner_name = $row->partner_name;
    $partner_email = $row->partner_email;
    $partner_logo = $row->partner_logo;
    $partner_thumb = $row->partner_thumb;

    $v_data["partner_type_id"] = $partner_type_id;
    $v_data["partner_name"] = $partner_name;
    $v_data["partner_email"] = $partner_email;
    $v_data["partner_logo"] = $partner_logo;
    $v_data["partner_thumb"] = $partner_thumb;
    $v_data["partner_types"] = $this->partners_model->all_partner_types();

    
    $data = array("title" => "partner",
        "content" => $this->load->view("partners/new_partner", $v_data, true));
    // $this->load->view("welcome_here", $data);
    $this->load->view("laikipiaschools/layouts/layout", $data);
    } else {
    $this->session->set_flashdata("error_message", "could not find partner");
    redirect("partners");

    }
    }

    public function create_partner()
    {
    $this->form_validation->set_rules("partner_type", "partner_type", "required");
    $this->form_validation->set_rules("partner_name", "partner_name", "required");
    $this->form_validation->set_rules("partner_email", "partner_email", "required");
    //$this->form_validation->set_rules("partner_logo", "partner_logo", "required");


    if ($this->form_validation->run()) {
    $resize=array(
        "width" =>600,
        "height" =>600
    );
    
    $upload_response = $this->file_model->upload_image($this->upload_path,"partner_logo",$resize);

                if($upload_response["check"]==FALSE)
                {
                
                    $this->session->set_flashdata("error",$upload_response['message']);
                    // $this->session->set_flashdata("error", " unable to add partner");
                    redirect('administration/partners');
                
                }
                else
                 {
                    // var_dump('13');die();
                        if($this->partners_model->add_partners($upload_response['file_name'],$upload_response['thumb_name']))
                        {
                            $this->session->set_flashdata("success", " added partner");
                            redirect('administration/partners');
                        }  
                        else
                        {
                            // var_dump('13');die();
                            $this->session->set_flashdata("error_message", "unable to add school"); 
                        }
                }
    }
    else{
       //put pagination, 
    $v_data["query"] = $this->partners_model->get_partners();
    $v_data["partner_types"] = $this->partners_model->get_partner_types();

    $data = array("title" => "Partner",
    "content" => $this->load->view("partners/all_partners", $v_data, true),

    );
    
    $this->load->view("laikipiaschools/layouts/layout", $data);
    }
    }
    // $partner_id = $this->partners_model->add_partners();
    // if ($partner_id > 0) {
    //     $this->session->set_flashdata("success_message", "New partner ID" . $partner_name . " has been added");
    // } else {
    //     $this->session->set_flashdata
    //         ("error_message", "unable to add partner");
    // }
    // redirect("laikipiaschools/partners");
    // }

    // redirect("laikipiaschools/partners");

    // $data["form_error"] = validation_errors();
    // // $data["partner_types"] = $this->partners_model->get_partner_types();
    // // $data = array("title" => "Add partner",
    // //     "content" => $this->load->view("partners/add_partner", $data, true));
    // // // $this->load->view("welcome_here", $data);
    // // $this->load->view("laikipiaschools/layouts/layout", $data);

    // //  $this->load->view("partners/add_partner",$data);

    

    // //update
    public function edit($partner_id)
    {
    $this->form_validation->set_rules("partner_type", "Partner Type", "required");
    $this->form_validation->set_rules("partner_name", "Partner Name", "required");
    $this->form_validation->set_rules("partner_email", "Partner Email", "required");


    if ($this->form_validation->run()) {
    $update_status = $this->partners_model->update_partner($partner_id);
    if ($update_status) {
        redirect("administration/partners");
    }
    } else {
    //name from form is the unique identifier
    $my_partner = $this->partners_model->get_single_partner($partner_id);
    if ($my_partner->num_rows() > 0) {
        $row = $my_partner->row();
        $partner_type_id = $row->partner_type_id;
        $partner_name = $row->partner_name;
        $partner_email = $row->partner_email;
        $partner_logo = $row->partner_logo;

        $v_data["partner_type_id"] = $partner_type_id;
        $v_data["partner_name"] = $partner_name;
        $v_data["partner_email"] = $partner_email;
        $v_data["partner_logo"] = $partner_logo;
        // $v_data["partners"] = $my_partner;
        $v_data["partner_types"] = $this->partners_model->all_partner_types();

        $data = array("title" => "Update partner",
            "content" => $this->load->view("partners/edit_partners", $v_data, true)
        );
        // var_dump($data);die();
        $this->load->view("laikipiaschools/layouts/layout", $data);

    } else {
        $this->session->set_flashdata("error_message", "couldnt");
        redirect("partners");
    }

    }

    }
    //uploading image
  //delete image
    public function delete_partner($partner_id)
    {
    if($this->partners_model->delete_partners($partner_id))
    {
    $this->session->set_flashdata('success', 'Partner Deleted successfully');
    redirect('administration/partners');
    }
    else 
    {
    $this->session->set_flashdata('error', 'Unable to delete partner, Try again!!');
    redirect('administration/partners');
    }
    }
    }
