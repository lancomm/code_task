<?php

class TestCase extends CIPHPUnitTestCase
{
    public function setUp()
    {
        $this->resetInstance();
        $CI =& get_instance();
        $this->db = $CI->load->database('default', TRUE);
        $this->db->query('drop database itrm_test;');
        $this->db->query('create database itrm_test;');
        $this->db->query('use itrm_test;');
        $this->CI->load->model('Migrate_model');
        $this->migrate = $this->CI->Migrate_model;
        $this->migrate->migrateTablesForTests();
        $this->migrate->seed();
        $CI->seeder->call('TestUsersSeeder');
        $_SERVER['HTTP_USER_AGENT'] = 'Firefox 1221';
        set_is_cli(FALSE);
    }

    public function tearDown() {
        $this->resetInstance();
        $CI =& get_instance();
        $this->db = $CI->load->database('default', TRUE);
        $this->db->query('drop database itrm_test;');
        $this->db->query('create database itrm_test;');
        set_is_cli(TRUE);
    }
}
