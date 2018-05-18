<?php
/**
 * Part of ci-phpunit-test
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2015 Kenji Suzuki
 * @link       https://github.com/kenjis/ci-phpunit-test
 */

class Users_controller_test extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->resetInstance();
        $CI =& get_instance();

        $this->CI->load->model('Admin_model');
        $this->obj = $this->CI->Admin_model;

        $this->CI->load->model('Common_model');
        $this->common = $this->CI->Common_model;

        $this->db->truncate('crm_users');

        $CI->load->library('Seeder');
        $CI->seeder->call('TestUsersSeeder');
    }

    /**
    * Tears down the fixture, for example, closes a network connection.
    * This method is called after a test is executed.
    */
    public function tearDown()
    {
        $CI =& get_instance();
        $this->db->truncate('crm_users');

        parent::tearDown();
    }



}
