<?php

class Migrate_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function migrateTablesForTests()
    {
        $this->load->library('migration');
        if ($this->migration->latest() === false) {
            show_error($this->migration->error_string());
        }
    }

    public function seedTestRFI() {
        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('TestRFISeeder');
    }

    public function seedTestIRS() {
        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('TestIRSSeeder');
    }

    public function seedTestSubcontractorOrder() {
        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('TestSubcontractorOrderSeeder');
    }

    public function seedTestProject() {
        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('TestProjectSeeder');
    }

    public function seedTestProjectPermissions() {
        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('TestProjectPermissionsSeeder');
    }

    public function seedTestPayment() {
        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('TestPaymentSeeder');
    }

    public function seedTestPaymentCertificate() {
        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('TestProjectSeeder');
        $CI->seeder->call('TestUsersSeeder');
        $CI->seeder->call('TestSubcontractorOrderSeeder');
        $CI->seeder->call('TestPaymentCertificateSeeder');
        $CI->seeder->call('TestSubcontractorInvoicesSeeder');
    }

    public function seedTestUsers() {
        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('TestUsersSeeder');
    }

    public function seedTestData() {
        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('TestProjectSeeder');
        $CI->seeder->call('TestUsersSeeder');
    }

    public function seedTestPurchaseOrder() {
        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('TestPurchaseOrderSeeder');
    }

    public function seed()
    {
        $CI =& get_instance();
		$CI->load->library('Seeder');
		$CI->seeder->call('MenuSeeder');
        $CI->seeder->call('ProfessionSeeder');
        $CI->seeder->call('TradeSeeder');
        $CI->seeder->call('UomSeeder');
        $CI->seeder->call('GroupSeeder');
        $CI->seeder->call('CostCodeSeeder');
        $CI->seeder->call('FilesSeeder');
        $CI->seeder->call('UsersSeeder');
        $CI->seeder->call('AdminSettingsSeeder');
        $CI->seeder->call('CostPlanSeeder');
        $CI->seeder->call('PackagesSeeder');
        $CI->seeder->call('ParamsSeeder');
    }

}
