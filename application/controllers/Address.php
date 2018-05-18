<?php
class Address extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('table');
        $this->load->library('parser');
        $this->load->helper(array('form', 'url','html'));
        $this->load->database();
        $this->table = 'crm_user_addresses';
        $this->load->model('common_model', 'common');
        $this->load->model('Users_model', 'users');
        $this->load->model('Admin_model', 'admin_model');
        $this->config->load('form_validation', true);
        $this->keywords = ['name', 'email'];
    }

    /*Index*/
    public function index()
    {
        if ($this->common->check_permission('users', 'read') == false) {
            $this->session->set_flashdata('error', 'You do not have permission to view this page. Please contact Administrator');
            redirect('Admin/logout');
		}

    }
    /*Add Address*/
    public function add($user_id = null)
    {
	if ($user_id == null){ // means trying to access without a userid
		redirect('admin/logout');
	} else {
		$this->data['user_id'] = $user_id;
	}
        if ($_POST) {
            $this->data =  $this->common->changeEmptyToNull($_POST);
            $this->form_validation->set_error_delimiters();
            $validationarr = $this->config->item('users_address', 'form_validation');
            $this->form_validation->set_rules($validationarr);
            $max_address_length = "60";

           	// if i had more time i would put this into the MY_formvalidation libary
            $add_length = strlen($_POST['address_1'].$_POST['address_2']);
            if($add_length > $max_address_length){
				#$data['errorMsg']
				echo "You cannot enter more than 60 characters for the address lines 1 and 2<br />";
			} else {
				
			
            if ($this->form_validation->run() == false) {
                $data['errorMsg'] = validation_errors();
            } else {
            	// now check the details
                $insertID = $this->common->add_record('crm_user_addresses', $this->data);
                if ($insertID != false) {
                    redirect('/users/index/'.$user_id);
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'Update failed, please contact Systems Administrator </a>.'
                    );
                    $this->load->view('users/add_edit_address', $this->data);
                }
            }
        }
		}
        $this->load->view('address/add_edit_address', $this->data);
    }

    public function edit($address_id = null)
    {
        $this->data = $this->common->findById('crm_user_addresses', $address_id);
    	$user_id = $this->data['user_id'];
        if ($_POST) {
            $this->data = $this->common->changeEmptyToNull($_POST);
            $this->data['id'] = $address_id;
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters();
            $validationarr = $this->config->item('users_address', 'form_validation');
            $this->form_validation->set_rules($validationarr);

            if ($this->form_validation->run() == false) {
                $this->data['errorMsg'] = validation_errors();
            } else {
                $update = $this->common->update_record('crm_user_addresses', $this->data);
                if ($update != false) {
                    $this->session->set_flashdata('success', 'Address details updated successfully.');
                    redirect('users/index/'.$user_id);
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'Update failed, please contact Systems Administrator'
                    );
                    
                     redirect('users/index/'.$user_id);
                }
            }
        } 

        $this->load->view('address/add_edit_address', $this->data);
    }

    Public function delete ($id = null)
    {
    	$this->data = $this->common->findById('crm_user_addresses', $id);
    	$user_id = $this->data['user_id'];
        if ($this->common->delete_record('crm_user_addresses', $id) != false) {
            $this->session->set_flashdata('success', 'Address Successfully Deleted.');
             redirect('users/index/'.$user_id);
        }
    }

}
