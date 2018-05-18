<?php

class Migrate extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('migrate_model', 'migrate');
        if (!$this->input->is_cli_request()) {
          //  exit('Direct access is not allowed. This is a command line tool, use the terminal');
        }
    }

    public function migrate($version = null)
    {
        $this->load->library('migration');

        if ($version != null) {
            if ($this->migration->version($version) === false) {
                show_error($this->migration->error_string());
            } else {
                echo "Migrations run successfully" . PHP_EOL;
            }
            return;
        }

        if ($this->migration->latest() === false) {
            show_error($this->migration->error_string());
        } else {
            echo "Migrations run successfully" . PHP_EOL;
        }
    }

    public function seed() {
        $this->migrate->seed();
    }

    public function seedTestSubcontractorOrderProcess() {
        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('TestSubcontractorOrderSeeder');
        $CI->seeder->call('TestPaymentCertificateSeeder');
        $CI->seeder->call('TestSubcontractorInvoicesSeeder');
    }

    public function seedTestIRS() {
        $this->migrate->seedTestIRS();
    }

    public function seedTestData() {
        $this->migrate->seedTestData();
    }

    public function seedTestRFI() {
        $this->migrate->seedTestRFI();
    }

    public function seedTestUsers() {
        $this->migrate->seedTestUsers();
    }

    public function seedTestPayment() {
        $this->migrate->seedTestPayment();
    }

    public function seedTestPurchaseOrder() {
        $this->migrate->seedTestPurchaseOrder();
    }

    public function seedTestProject() {
        $this->migrate->seedTestProject();
    }

    public function seedTestProjectPermissions() {
        $this->migrate->seedTestProjectPermissions();
    }

    public function seedTestSubcontractorOrder() {
        $this->migrate->seedTestUsers();
        $this->migrate->seedTestProject();
        $this->migrate->seedTestSubcontractorOrder();
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

    public function seedTestNotification() {
        $this->migrate->seedTestProject();
        $this->migrate->seedTestPurchaseOrder();
    }

}
