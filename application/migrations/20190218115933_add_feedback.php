<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_feedback extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'feedback_id' => array(
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ),

            'feedback_type_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'null' => false,
            ),
            'feedback_title' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ),
            'feedback_phone_number' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ),
            'feedback_email' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ),
            'feedback_status' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => false,
            ),
            'feedback_text' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ),

        ));

        $this->dbforge->add_field("`created_by` int NOT NULL ");
        $this->dbforge->add_field("`created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`modified_by` int  NULL ");
        $this->dbforge->add_field("`modified_on` timestamp  NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`deleted_by` int  NULL");
        $this->dbforge->add_field("`deleted` tinyint NOT NULL DEFAULT 0");
        $this->dbforge->add_field("`deleted_on` timestamp NULL DEFAULT NULL");
        $this->dbforge->add_key('feedback_id', true);
        $this->dbforge->create_table('feedback');
        // $this->db->query('ALTER TABLE `feedback` ADD FOREIGN KEY(`feedback_type_id`) REFERENCES `feedback_type`(`feedback_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;');

    }

    public function down()
    {
        $this->dbforge->drop_table('feedback');
    }
}
