<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_crm_params_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'null' => false,
                'constraint' => '6',
                'unsigned' => true,
                'auto_increment' => true
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'null' => false,
                'constraint' => '255'
            ),
            'description' => array(
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
        $this->dbforge->create_table('crm_params');
        
        $data = array(
            array("name"       => "Mr",
                "description"=> "honorifics"),
            array("name"       => "Mrs",
                "description"=> "honorifics"),
            array("name"       => "Miss",
                "description"=> "honorifics"),
            array("name"       => "Ms",
                "description"=> "honorifics"),
            array("name"       => "Dr",
                "description"=> "honorifics"),
                array("name"       => "Male",
                "description"=> "gender"),
                array("name"       => "Female",
                "description"=> "gender"),
                array("name"       => "Not Specified",
                "description"=> "gender"),
                
        );
        $this->db->insert_batch('crm_params', $data);
        
    }

    public function down() {

    }
}
