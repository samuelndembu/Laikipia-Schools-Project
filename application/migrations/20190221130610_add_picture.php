<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_picture extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'picture_id' => array(
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ),
            'picture_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ),
            'picture_status' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
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
        $this->dbforge->add_key('picture_id', true);
        $this->dbforge->create_table('picture');
    }

    public function down()
    {
        $this->dbforge->drop_table('picture');
    }
}