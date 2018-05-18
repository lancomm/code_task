<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Admin extends CI_Controller
{
    var $data;
    var $admin_id;

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('table');
        $this->load->helper(array('form', 'url','html'));
        $this->load->database();
        $this->load->model('Admin_model', 'admin_model');
        $this->load->model('users_model', 'users');
        $this->load->model('common_model', 'common');
        $this->config->load('form_validation', true);
    }

    public function send_reset_email()
    {
        $userId = $this->admin_model->findUserByEmail($_POST['email']);

        if (!is_null($userId)) {
            $token_array = $this->admin_model->generateToken($tokenForLink, $tokenHashForDatabase);
            $emailLink = base_url()."Admin/change_password?tok=".$token_array['tokenForLink'];
            $creationDate= new DateTime();
            $date        = $creationDate->getTimestamp();
            $this->admin_model->savePasswordResetToDatabase($token_array['tokenHashForDatabase'], $userId, $date);
            $subject     = "Reset Email Link";
            $to          = $_POST['email'];
            $body        = '<!DOCTYPE html>
            <html>
                <head>
                <meta name="viewport" content="width=device-width" />
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <title>Password Reset Request</title>
                </head>
                <body>
                    <div>
                        <p style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you for requesting a password change<br><br>
                        If you are not expecting this then please do not click the link below.<br><br>
                        If you are wanting to change your London Projects password then please click this link: <a href="'.$emailLink.'">https://itrackprojects.co.uk/change_password</a><br><br>
                        Many thanks the London Projects Team
                    </div>
                </body>
            </html>';
            $this->common->sendEmail($to, $subject, $body);
            $this->session->set_flashdata('success', 'Reset Email sent.');
            redirect('admin/login', $this->data);
        } else {
            $this->session->set_flashdata('error', 'Email not found.');
            redirect('admin/reset_password');
        }
    }

    public function index()
    {
        if (!$this->session->userdata('SESS_USERID')) {
            redirect("admin/login");
        } else {
            $this->data['menu'] = 'home';
            redirect("projects");
        }
    }

    public function change_password()
    {
        $this->logout(false);
        $this->data['errorMsg'] = "";
        $allow_change_password = true;
        if (!isset($_GET['tok']) || !$this->admin_model->isTokenValid($_GET['tok'])) {
            $this->data['errorMsg'] = 'The token is invalid.';
            $allow_change_password = false;
            redirect("admin");
        }

        $tokenHashFromLink = $this->admin_model->calculateTokenHash($_GET['tok']);

        if (!$return_data = $this->admin_model->loadPasswordResetFromDatabase($tokenHashFromLink)) {
            if ($this->data['errorMsg'] == "") {
                $this->data['errorMsg'] = "Token Not found";
            }
            $allow_change_password = false;
        }

        if ($this->admin_model->isTokenExpired($return_data['change_password_token_creation'])) {
            if ($this->data['errorMsg'] == "") {
                $this->data['errorMsg'] = 'The token has expired.';
            }
            $allow_change_password = false;
        }

        if ($allow_change_password == true) {
            if ($_POST) {
                $this->form_validation->set_error_delimiters();
                /* config loaded in construct */
                $validationarr = $this->config->item('change_password', 'form_validation');
                $user_id       = $_POST['user_id'];
                $new_password  = $_POST['password'];
                $tok           = $_POST['tok'];
                $this->form_validation->set_rules($validationarr);
                if ($this->form_validation->run() == false) {
                    $this->data['errorMsg'] = validation_errors();
                } else {
                    if ($this->admin_model->update_login_password($user_id, $new_password)) {
                        $this->data['errorMsg'] = '<div style="padding-bottom:5px;"><font size="2" color="green">Password changed.</font></div>';
                        $this->session->set_flashdata('success', 'Password Changed.');
                        redirect("Admin");
                    }
                }
            }
            $this->data['user_id'] = $return_data['id'];
            $this->load->view('admin/change_password', $this->data);
        } else {
            $this->load->view('admin/reset_password', $this->data);
        }
    }

    public function reset_password()
    {
        $this->data['login'] = true;
        $this->load->view('admin/reset_password', $this->data);
    }

    private function dateDiff($time1, $time2, $precision = 6)
    {
        if (!is_int($time1)) {
            $time1 = strtotime($time1);
        }
        if (!is_int($time2)) {
            $time2 = strtotime($time2);
        }

        if ($time1 > $time2) {
            $ttime = $time1;
            $time1 = $time2;
            $time2 = $ttime;
        }

        $intervals = array('day','hour','minute','second');
        $diffs = array();

        foreach ($intervals as $interval) {
            $ttime = strtotime('+1 ' . $interval, $time1);

            $add   = 1;
            $looped= 0;
            while ($time2 >= $ttime) {
                $add++;
                $ttime = strtotime("+" . $add . " " . $interval, $time1);
                $looped++;
            }

            $time1 = strtotime("+" . $looped . " " . $interval, $time1);
            $diffs[$interval] = $looped;
        }

        $count = 0;
        $times = array();

        foreach ($diffs as $interval => $value) {
            if ($count >= $precision) {
                break;
            }

            if ($value > 0) {
                if ($value != 1) {
                    $interval .= "s";
                }
                $times[] = $value . "" . $interval;
                $count++;
            }
        }

        return implode(": ", $times);
    }

	public function user_profile(){
		echo "UserProfile";
	}
    public function login()
    {
        $this->data['login'] = true;

        if (!$this->session->userdata('SESS_USERID')) {
            $this->form_validation->set_rules('user_name', 'Email', 'required');
            $this->form_validation->set_rules('user_password', 'Password', 'required');
            $this->form_validation->set_error_delimiters(
                '<div  align="left"  style="padding-left:70px">',
                '</div>'
            );
            if ($this->form_validation->run() == false) {
                $this->data['errorMsg'] = validation_errors();
                
                $this->load->view('admin/login', $this->data);
            } else {
                if ($this->setLoginData($_POST['user_name'], $_POST['user_password'])) {
                        redirect("users/index/".$this->session->userdata('SESS_USERID'));
                } else {
                	$this->load->view('admin/login', $this->data);
                    $this->session->set_flashdata('error', 'The Email or password you entered is incorrect.');
                }
            }
        }

    }

    public function logout($redirect = true)
    {
        session_unset();
        if ($redirect == true) {
            redirect("Admin/login");
        }
    }

    private function setLoginData($username, $password)
    {
        if ($user = $this->admin_model->check_login_data($username, $password)) {
            $user_browser = $_SERVER['HTTP_USER_AGENT'];
            $data = array(
                'SESS_USERID'       => $user['id'],
                'SESS_USERNAME'     => $user['name'] . ' ' . $user['surname'],
                'SESS_FIRSTNAME'    => $user['name'],
                'SESS_LASTNAME'     => $user['surname'],
                'SESS_USERTYPE'     => $user['type'],
                'SESS_USERGROUP'    => $user['group_id'],
                'SESS_TOKEN'        => hash('sha512', $user['password'] . $user_browser),
            );

            if (!empty($_SESSION['REQUEST_URI'])) {
                $data['REQUEST_URI'] = $_SESSION['REQUEST_URI'];
            }

            $this->session->set_userdata($data);
            return true;
        } else {
            return false;
        }
    }

    function change_password_remove()
    {
        $this->session->set_flashdata();
        if (!$this->session->userdata('SESS_USERID')) {
            redirect('admin');
        }
        $this->data['menu']     =   'home';
        if ($_POST) {
            $details = $this->admin_model->getAdminDetailsById($this->session->userdata('SESS_USERID'));
            $this->data['admin_list'] = $_POST;
            $this->load->library('form_validation');
            $validationarr = array(
                array(
                    'field'   => 'password',
                    'label'   => 'New Password',
                    'rules'   => 'required|min_length[6]|max_length[20]'
                ),
                array(
                    'field'   => 'confirm_password',
                    'label'   => 'Confirm Password ',
                    'rules'   => 'required|matches[password]|min_length[6]|max_length[20]'
                )
            );

            $this->form_validation->set_rules($validationarr);
            if ($this->form_validation->run() == false) {
                $this->data['errorMsg'] = validation_errors();
            } elseif ($details['admin_password']!=$_POST['oldpassword']) {
                $this->data['errorMsg'] ="Old password mismatching";
            } else {
                $password = $_POST['password'];
                $current_password = $details['admin_password'];
                $this->admin_id= $this->session->userdata('SESS_USERID');
                if ($this->admin_model->update_password($password, $current_password)) {
                    $this->data['msg'] ="Password Changed Successfully!!!";
                }
            }
        }
        $this->load->view("admin/change_password", $this->data);
    }

    function _is_username_exist()
    {
        if ($this->admin_model->is_name_exist($this->input->post('username'))) {
            $this->form_validation->set_message('_is_username_exist', 'User Name already exists');
            return false;
        } else {
            return true;
        }
    }
}
