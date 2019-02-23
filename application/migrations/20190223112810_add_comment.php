<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_comment extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(array(
            'comment_id' => array(
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ),
            'post_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'null' => false,
            ),
            'comment_title' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ),
            'comment_body' => array(
                'type' => 'VARCHAR',
                'null' => false,
                'constraint' => '200',

            ),
            'comment_email' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ),
            'comment_sender_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ),
        ));

        $this->dbforge->add_field("`created_by` int NOT NULL");
        $this->dbforge->add_field("`created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`modified_by` int  NULL");
        $this->dbforge->add_field("`modified_on` timestamp  NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`deleted_by` int  NULL");
        $this->dbforge->add_field("`deleted` tinyint NOT NULL DEFAULT 0");
        $this->dbforge->add_field("`deleted_on` timestamp NULL DEFAULT NULL");
        $this->dbforge->add_key('comment_id', true);
        $this->dbforge->create_table('comment');
    }

    public function down()
    {
        $this->dbforge->drop_table('comment');
    }
}
