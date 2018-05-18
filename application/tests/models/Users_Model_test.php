<?php
/**
 * Part of ci-phpunit-test
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2015 Kenji Suzuki
 * @link       https://github.com/kenjis/ci-phpunit-test
 */

class Users_Model_test extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->resetInstance();
        $CI =& get_instance();
        $CI->load->library('session');
        $CI->load->library('Seeder');
        $this->CI->load->model('Users_model');
        $this->users = $this->CI->Users_model;
    }

    /**
    * Tears down the fixture, for example, closes a network connection.
    * This method is called after a test is executed.
    */
    public function tearDown()
    {
        $CI =& get_instance();
        $this->db = $CI->load->database('default', TRUE);;
        parent::tearDown();
    }

    public function testCheckDuplicateUserEmail() {

    }
}
