<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_feedback_type extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'feedback_type_id' => array(
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ),

            'feedback_type_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ),
            'feedback_type_status' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => false,
            ),

        ));

        $this->dbforge->add_field("`created_by` int  NULL ");
        $this->dbforge->add_field("`created_on` datetime  NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`modified_by` int NULL ");
        $this->dbforge->add_field("`modified_on` timestamp  NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`deleted_by` int  NULL");
        $this->dbforge->add_field("`deleted` tinyint  NULL DEFAULT 0");
        $this->dbforge->add_field("`deleted_on` timestamp NULL ");
        $this->dbforge->add_key('feedback_type_id', true);
        $this->dbforge->create_table('feedback_type');
        // $this->db->query('ALTER TABLE `feedback_type` ADD FOREIGN KEY(`feedback_type_type_id`) REFERENCES `feedback_type_type`(`feedback_type_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;');
        $this->db->query('INSERT INTO `feedback_type` (feedback_type_name, feedback_type_status, created_by,  created_on, modified_by, modified_on, deleted_by, deleted, deleted_on) VALUES ("Donor", 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);');
        $this->db->query('INSERT INTO `feedback_type` (feedback_type_name, feedback_type_status, created_by,  created_on, modified_by, modified_on, deleted_by, deleted, deleted_on) VALUES ("feedback", 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);');
    }

    public function down()
    {
        $this->dbforge->drop_table('feedback_type');
    }
}
