<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_school extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'school_id' => array(
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ),
            'school_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ),
            'school_latitude' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ),
            'school_longitude' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ),
            'school_location_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ),
            'school_girls_number' => array(
                'type' => 'INT',
                'constraint' => '100',
                'null' => false,
            ),
            'school_boys_number' => array(
                'type' => 'INT',
                'constraint' => '100',
                'null' => false,
            ),
            'school_write_up' => array(
                'type' => 'VARCHAR',
                'null' => false,
                'default' => null,
            ),
            'school_write_up' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => null,
            ),
            'school_image_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ),
            'school_thumb_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ),
            'school_status' => array(
                'type' => 'BOOLEAN',
                'null' => false,
                'default' => 0,
            ),
        ));
        $this->dbforge->add_field("`created_by` int NOT NULL");
        $this->dbforge->add_field("`created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`modified_by` int NULL ");
        $this->dbforge->add_field("`modified_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`deleted_by` int NULL");
        $this->dbforge->add_field("`deleted` tinyint NOT NULL DEFAULT 0");
        $this->dbforge->add_field("`deleted_on` timestamp NULL DEFAULT NULL");
        $this->dbforge->add_key('school_id', true);
        $this->dbforge->create_table('school');
    }

    public function down()
    {
        $this->dbforge->drop_table('school');
    }
}
