<?php

class Users_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('common_model', 'common');
    }


    public function checkDuplicateUserEmail($email = null) {
        if ($email !=null) {
            $find = $this->common->fetch_all(
                'crm_users',
                [],
                [
                    'email' => $email,
                ]
            );

            if (!empty($find)) {
                return true;
            } else {
                return false;
            }
        }
        return;
    }


}
