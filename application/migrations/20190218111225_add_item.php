_<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_item extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'item_id' => array(
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ),
            'item_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ),
            'item_type' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ),
            'item_price' => array(
                'type' => 'int',
                'constraint' => '100',
                'null' => false,
            ),
            'item_quantity' => array(
                'type' => 'int',
                'constraint' => '100',
                'null' => false,
            ),
            'user_item' => array(
                'type' => 'tinyint',
                'constraint' => '1',
                'null' => false,
                'default' => 1,
            ),
        ));
        $this->dbforge->add_field("`created_by` int NOT NULL");
        $this->dbforge->add_field("`created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`modified_by` int NULL ");
        $this->dbforge->add_field("`modified_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`deleted_by` int NULL");
        $this->dbforge->add_field("`deleted` tinyint NOT NULL DEFAULT 0");
        $this->dbforge->add_field("`deleted_on` timestamp NULL DEFAULT NULL");
        $this->dbforge->add_key('item_id', true);
        $this->dbforge->create_table('item');
    }

    public function down()
    {
        $this->dbforge->drop_table('item');
    }
}