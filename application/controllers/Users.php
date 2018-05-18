<?php
class Users extends CI_Controller
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
        $this->table = 'crm_users';
        $this->load->model('common_model', 'common');
        $this->load->model('Users_model', 'users');
        $this->load->model('Admin_model', 'admin_model');
        $this->config->load('form_validation', true);
        $this->keywords = ['name', 'email'];
    }

    /*Index*/
    public function index($user_id = null)
    {
    	$data['user_id'] = $user_id;
    	$data['user_details'] = 
    	$this->common->fetch_all(
    	$this->table,
    	["*"],
    	["id"=>$user_id]
    	);
    	// need to see if they have any addresse
    	
    	$data['registered_addresses'] = $this->common->fetch_all(
    	"crm_user_addresses",
    	["*"],
    	["user_id"=>$user_id]
    	);
    	
        $this->load->view('users/index', $data);
    }
    /*Add User*/
    public function add()
    {

        if ($_POST) {
            $this->data =  $this->common->changeEmptyToNull($_POST);
            $this->form_validation->set_error_delimiters();
            $validationarr = $this->config->item('users_add_edit', 'form_validation');
            if ($this->users->checkDuplicateUserEmail($this->data['email'])) {
                $validationarr[] = array(
                    'field'   => 'email',
                    'label'   => 'Email',
                    'rules'   => 'required|valid_email|is_unique[crm_users.email]',
                    'errors' => array(
                        'is_unique'        => 'An account for this email address has already been created.',
                    ),
                );
            } else {
                $validationarr[] = array(
                    'field'   => 'email',
                    'label'   => 'Email',
                    'rules'   => 'required|valid_email',
                    'errors' => array(
                        'is_unique'        => 'Please enter a valid email address.',
                    ),
                );
            }

            $this->form_validation->set_rules($validationarr);
            if ($this->form_validation->run() == false) {
                $data['errorMsg'] = validation_errors();
            } else {
            	unset($this->data['retype_password'] );
                $this->data['password']         = $this->admin_model->hash_password($this->data['password']);
                $insertID = $this->common->add_record('crm_users', $this->data);
                if ($insertID != false) {
                    redirect('address/add/'.$insertID);
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'Update failed, please contact Systems Administrator <a href="mailto:tech.support@londonprojects.co.uk" target="_top">Send Mail</a>.'
                    );
                    $this->load->view('users/add_edit_user');
                }
            }
        }
        $this->load->view('users/add_edit_user');
    }

    public function edit($user_id = null)
    {

        if ($_POST) {
            $this->data = $this->common->changeEmptyToNull($_POST);
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters();
            $validationarr = $this->config->item('users_add_edit', 'form_validation');
            $validationarr[] = array(
                'field'   => 'email',
                'label'   => 'Email',
                'rules'   => 'trim|required|valid_email',
            );

            $this->form_validation->set_rules($validationarr);

            if ($this->form_validation->run() == false) {
                $this->data['errorMsg'] = validation_errors();
            } else {
                $this->data['id'] = $user_id;
                unset($this->data['retype_password'] );
                $update = $this->common->update_record('crm_users', $this->data);
                if ($update != false) {
                    $this->session->set_flashdata('success', 'User details updated successfully.');
                    redirect('users/index/'.$user_id);
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'Update failed, please contact Systems Administrator <a href="mailto:tech.support@londonprojects.co.uk" target="_top">Send Mail</a>.'
                    );
                    redirect('users/index/'.$user_id);
                }
            }
        } else {
            $this->data    =   $this->common->findById('crm_users', $user_id);
            $this->data['retype_password'] =  $this->data['password'] ;
            
        }
        $this->load->view('users/add_edit_user', $this->data);
    }

    Public function delete ($id = null)
    {
        if ($this->common->delete_record('crm_users', $id) != false) {
            $this->session->set_flashdata('success', 'User Successfully Deleted.');
            redirect('admin/logout');
        }
    }

}
