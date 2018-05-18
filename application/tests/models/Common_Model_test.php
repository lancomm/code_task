<?php
/**
 * Part of ci-phpunit-test
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2015 Kenji Suzuki
 * @link       https://github.com/kenjis/ci-phpunit-test
 */

class Common_Model_test extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->resetInstance();
        $CI =& get_instance();
        $CI->load->library('session');
        $CI->load->library('Seeder');
        $CI->seeder->call('TestUsersSeeder');

        $this->CI->load->model('Common_model');
        $this->common = $this->CI->Common_model;
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




    public function testIsLiveServer() {
        $this->assertTrue($this->common->isLiveServer() === false);
    }


    public function testGetDateDiff() {
        $diff = $this->common->get_date_diff('01/01/2020', '01/10/2020');
        $this->assertEquals('+9 days', $diff);
    }



    public function testAddRecord() {
        $_SESSION['SESS_USERID'] = 10;

        $this->common->add_record(
            'crm_notes', [
                'table'             => 'crm_users',
                'object_id'         => 4,
                'notes'             => 'Great Prices',
                'created_by'        => 1
            ]
        );

        $hist = $this->common->fetch_all(
            'crm_history_log',
            [],
            [
                'table_name'     => 'crm_notes',
                'row_id'         => 1,
                'user_id'        => 10
            ],null, null, null, true, false
        );

        $rec = $this->common->fetch_all(
            'crm_notes', ['id'], [], null, null, null, true, false
        );

        $this->assertTrue($rec->id == 1);
        $this->assertTrue($hist->row_type == 'ADD');
    }

    public function testUpdateRecord() {
        $_SESSION['SESS_USERID'] = 10;

        $this->common->add_record(
            'crm_notes', [
                'table'             => 'crm_users',
                'object_id'         => 4,
                'notes'             => 'Great Prices',
                'created_by'        => 1
            ]
        );

        $this->common->update_record(
            'crm_notes', [
                'id'     => 1,
                'notes'  => 'NOT SO GREAT PRICES',
            ]
        );

        $hist = $this->common->fetch_all(
            'crm_history_log',
            [],
            [
                'table_name'     => 'crm_notes',
                'row_id'         => 1,
                'user_id'        => 10,
                'row_type'       => 'UPDATE'
            ],null, null, null, true, false
        );

        $rec = $this->common->fetch_all(
            'crm_notes',
            [],
            [
                'object_id'         => 4,
                'table'             => 'crm_users',
                'created_by'        => 1
            ],
            null, null, null, true, false
        );

        $this->assertTrue($rec->notes == 'NOT SO GREAT PRICES');
        $this->assertTrue($hist->to == '{"notes":"NOT SO GREAT PRICES"}');
    }

    public function testDelete() {
        $_SESSION['SESS_USERID'] = 10;

        $this->common->add_record(
            'crm_notes', [
                'table'             => 'crm_users',
                'object_id'         => 4,
                'notes'             => 'Great Prices',
                'created_by'        => 1
            ]
        );

        $hist = $this->common->delete(
            'notes',
            [
                'id' => 1
            ]
        );

        $rec = $this->common->fetch_all(
            'crm_notes', ['deleted'], ['id' => 1], null, null, null, true, false
        );

        $this->assertTrue($rec->deleted == 1);
    }


}
