<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_supply extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'supply_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
           
            'supply_date' => array(
                'type' => 'DATETIME',
                 'null' => FALSE,
            ),
            'quantity' => array(
                'type' => 'INT',
                'constraint' => '11',
                'null' => FALSE,
            ),
            'dignity_pack_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'null' => FALSE,
            ),
            'school_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'null' => FALSE,
            ),
            'supply_status' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => FALSE,
            ),
        
            
        ));
       
        $this->dbforge->add_field("`created_by` int  NULL ");
        $this->dbforge->add_field("`created_on` datetime  NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`modified_by` int NULL ");
        $this->dbforge->add_field("`modified_on` timestamp  NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`deleted_by` int  NULL");
        $this->dbforge->add_field("`deleted` tinyint  NULL DEFAULT 0");
        $this->dbforge->add_field("`deleted_on` timestamp NULL ");
        $this->dbforge->add_key('supply_id', TRUE);
        $this->dbforge->create_table('supply');
       
    }

    public function down()
    {
            $this->dbforge->drop_table('supply');
    }
}