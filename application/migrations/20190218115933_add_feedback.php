<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_feedback extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'feedback_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
           
            'feedback_type_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'null' => FALSE,
            ),
            'feedback_title' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE,
            ),
            'feedback_phone_number' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
            ),
            'feedback_email' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
            ),
            'feedback_status' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => FALSE,
            ),
            'feedback_text' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE,
            ),
            
           
        ));
       
        $this->dbforge->add_field("`created_by` int NOT NULL ");
        $this->dbforge->add_field("`created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`modified_by` int  NULL ");
        $this->dbforge->add_field("`modified_on` timestamp  NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`deleted_by` int  NULL");
        $this->dbforge->add_field("`deleted` tinyint NOT NULL DEFAULT 0");
        $this->dbforge->add_field("`deleted_on` timestamp NULL DEFAULT NULL");
        $this->dbforge->add_key('feedback_id', TRUE);
        $this->dbforge->create_table('feedback');
       // $this->db->query('ALTER TABLE `feedback` ADD FOREIGN KEY(`feedback_type_id`) REFERENCES `feedback_type`(`feedback_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;');
       
    }

    public function down()
    {
            $this->dbforge->drop_table('feedback');
    }
}