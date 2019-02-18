<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_document_type extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'document_type_id' => array(
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ),

            'document_type_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ),
            'document_type_status' => array(
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
        $this->dbforge->add_key('document_type_id', true);
        $this->dbforge->create_table('document_type');
        // $this->db->query('ALTER TABLE `document_type` ADD FOREIGN KEY(`document_type_type_id`) REFERENCES `document_type_type`(`document_type_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;');
        $this->db->query('INSERT INTO `document_type` (document_type_name, document_type_status, created_by,  created_on, modified_by, modified_on, deleted_by, deleted, deleted_on) VALUES ("Pamphlet", 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);');
        $this->db->query('INSERT INTO `document_type` (document_type_name, document_type_status, created_by,  created_on, modified_by, modified_on, deleted_by, deleted, deleted_on) VALUES ("Poster", 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);');
    }

    public function down()
    {
        $this->dbforge->drop_table('document_type');
    }
}
