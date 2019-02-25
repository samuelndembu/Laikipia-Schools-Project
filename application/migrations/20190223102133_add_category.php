<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_category extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'category_id' => array(
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ),

            'parent' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ),
            'content_status' => array(
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
        $this->dbforge->add_key('category_id', true);
        $this->dbforge->create_table('category');
        // $this->db->query('ALTER TABLE `feedback_type` ADD FOREIGN KEY(`feedback_type_type_id`) REFERENCES `feedback_type_type`(`feedback_type_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;');
       
    }

    public function down()
    {
        $this->dbforge->drop_table('category');
    }
}
