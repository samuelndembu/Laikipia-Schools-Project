<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_dignity_pack extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'dignity_pack_id' => array(
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ),

            'dignity_pack_type' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ),
            'dignity_pack_status' => array(
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
        $this->dbforge->add_key('dignity_pack_id', true);
        $this->dbforge->create_table('dignity_pack');
        // $this->db->query('ALTER TABLE `dignity_pack` ADD FOREIGN KEY(`dignity_pack_type_id`) REFERENCES `dignity_pack_type`(`dignity_pack_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;');

    }

    public function down()
    {
        $this->dbforge->drop_table('dignity_pack');
    }
}
