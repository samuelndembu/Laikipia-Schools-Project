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

            'category_parent' => array(
                'type' => 'INT',
                'constraint' => '11',
                'null' => false,
            ),
            'category_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ),
            'category_status' => array(
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
        
      }

    public function down()
    {
        $this->dbforge->drop_table('category');
    }
}
