<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class File extends CI_Model
{
    public function __construct()
    {
        $this->tableName = 'school_images';
    }

    /*
     * Fetch files data from the database
     * @param id returns a single record if specified, otherwise all records
     */
    public function getRows($image_id = '')
    {
        $this->db->select('image_id,school_image_name,created_on');
        $this->db->from('files');
        if ($id) {
            $this->db->where('image_id', $image_id);
            $query = $this->db->get();
            $result = $query->row_array();
        } else {
            $this->db->order_by('created_on', 'desc');
            $query = $this->db->get();
            $result = $query->result_array();
        }
        return !empty($result) ? $result : false;
    }

    /*
     * Insert file data into the database
     * @param array the data for inserting into the table
     */
    public function insert($data = array())
    {
        $insert = $this->db->insert_batch('school_images', $data);
        return $insert ? true : false;
    }

}