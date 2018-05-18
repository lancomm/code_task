<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_crm_user_addresses_table extends CI_Migration
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
            'user_id' => array(
                'type' => 'INT',
                'null' => false,
                'constraint' => '7',
                'unsigned' => true
            ),
            'address_1' => array(
                'type' => 'VARCHAR',
                'constraint' => '60',
                'null' => true,
            ),
            'address_2' => array(
                'type' => 'VARCHAR',
                'null' => true,
                'constraint' => '60'
            ),
             'town' => array(
                'type' => 'VARCHAR',
                'null' => true,
                'constraint' => '255'
            ),
            'county' => array(
                'type' => 'VARCHAR',
                'null' => true,
                'constraint' => '255'
            ),
            'country' => array(
                'type' => 'VARCHAR',
                'null' => true,
                'constraint' => '255'
            ),
            'postcode' => array(
                'type' => 'VARCHAR',
                'null' => true,
                'constraint' => '255'
            ),
            'from_date' => [
                'type'  => 'DATE',
            ],
            'to_date' => [
                'type'  => 'DATE',
            ],
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
        $this->dbforge->create_table('crm_user_addresses');
    }

    public function down() {

    }
}
