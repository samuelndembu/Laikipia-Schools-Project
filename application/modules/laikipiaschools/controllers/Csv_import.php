<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Csv_import extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('csv_import_model');
        $this->load->library('csvimport');
    }

    public function index()
    {
        $this->load->view('csv_import');
    }

    public function load_data()
    {
        $result = $this->csv_import_model->select();
        $output = '
		 <h3 align="center">Imported User Details from CSV File</h3>
        <div class="table-responsive">
        	<table class="table table-bordered table-striped">
				<tr>

        			<th>School Name</th>
        			<th>School Zone</th>
        			<th>Latitude</th>
        			<th>Longitude</th>
					<th>Location Name</th>
					<th>Number of Girls</th>
					<th>Number of Boys</th>
        		</tr>
		';
        $count = 0;
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $count = $count + 1;
                $output .= '
				<tr>
					<td>' . $count . '</td>
					<td>' . $row->school_name . '</td>
					<td>' . $row->school_zone . '</td>
					<td>' . $row->school_latitude . '</td>
					<td>' . $row->school_longitude . '</td>
				</tr>
				';
            }
        } else {
            $output .= '
			<tr>
	    		<td colspan="5" align="center">Data not Available</td>
	    	</tr>
			';
        }
        $output .= '</table></div>';
        echo $output;
    }

    public function import()
    {
        $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
        foreach ($file_data as $row) {
            $data[] = array(
                'school_name' => $row["School Name"],
                'last_name' => $row["Last Name"],
                'school_zone' => $row["School Zone"],
                'school_latitude' => $row["school latitude"],
                'school_longitude' => $row["school_longitude"],
            );
        }
        $this->csv_import_model->insert($data);
    }

}