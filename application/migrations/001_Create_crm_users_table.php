<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_crm_users_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'null' => false,
                'constraint' => '9',
                'unsigned' => true,
                'auto_increment' => true
            ),
             'title_id' => array(
                'type' => 'INT',
                'null' => true,
                'constraint' => '3'
            ),
            'forename' => array(
                'type' => 'VARCHAR',
                'null' => false,
                'constraint' => '255'
            ),
            'surname' => array(
                'type' => 'VARCHAR',
                'null' => true,
                'constraint' => '255'
            ),
             'gender_id' => array(
                'type' => 'INT',
                'null' => true,
                'constraint' => '3'
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '255'
            ),
            'dob' => [
                'type'  => 'DATE',
            ],
            'password' => array(
                'type' => 'VARCHAR',
                'null' => false,
                'default'   => 'asd7897hkjaslkjklsaklHJKHDSKJHbn,m90289&*()',
                'constraint' => '255'
            ),
            'change_password_token' => array(
                'type' => 'VARCHAR',
                'null' => true,
                'constraint' => '255'
            ),
            'change_password_token_creation' => array(
                'type' => 'VARCHAR',
                'null' => true,
                'constraint' => '255'
            ),
            'deleted' => array(
                'type' => 'INT',
                'null' => false,
                'constraint' => '1',
                'default' => '0'
            ),
        ));


        $this->dbforge->add_field('modified TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->dbforge->add_field('created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');

        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('crm_users');
    }

    public function down() {

    }
}
