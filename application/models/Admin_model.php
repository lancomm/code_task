<?php
/*
* administative functions
* @category admin
* @author Satheesh G
*/
class Admin_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function generateRandomBase62String($length)
    {
        if (!defined('MCRYPT_DEV_URANDOM')) {
            die('The MCRYPT_DEV_URANDOM source is required (PHP 5.3).');
        }
        $result          = '';
        $remainingLength = $length;
        do {
            // We take advantage of the fast base64 encoding
            $binaryLength = (int)($remainingLength * 3 / 4 + 1);
            $binaryString = mcrypt_create_iv($binaryLength, MCRYPT_DEV_URANDOM);
            $base64String = base64_encode($binaryString);

            // Remove invalid characters
            $base62String = str_replace(array('+','/','='), '', $base64String);
            $result .= $base62String;

            // If too many characters have been removed, we repeat the procedure
            $remainingLength = $length - strlen($result);
        } while ($remainingLength > 0);
        return substr($result, 0, $length);
    }

    public function calculateTokenHash($token)
    {
        if (strlen($token) < 20) {
            throw new Exception('The token is too short and therefore too weak');
        }
        return hash('sha256', $token, false);
    }

    public function isTokenExpired($creationDate)
    {
        $seconds = 18000;
        $date    = new DateTime();
        $time_now= $date->getTimestamp();
        if (($time_now - $creationDate) <= $seconds) {
            return false;
        } else {
            return true;
        }
    }

    public function isTokenValid($token)
    {
        $tokenLength = 50;
        return !is_null($token) && ($tokenLength == strlen($token)) && ctype_alnum($token);
    }

    public function generateToken( & $tokenForLink, & $tokenHashForDatabase)
    {
        $my_array['tokenForLink'] = $this->generateRandomBase62String('50');
        $my_array['tokenHashForDatabase'] = $this->calculateTokenHash($my_array['tokenForLink']);
        return $my_array;
    }

    public function new_user_reset_password()
    {
        $userId = $this->findUserByEmail($_POST['email']);
        if (!is_null($userId)) {
            $token_array = $this->generateToken($tokenForLink, $tokenHashForDatabase);
            $emailLink   = "<a href='".base_url()."Admin/change_password?tok=".$token_array['tokenForLink']."'>https://itrackprojects.co.uk</a>";
            $creationDate= new DateTime();
            $date        = $creationDate->getTimestamp();
            $this->savePasswordResetToDatabase($token_array['tokenHashForDatabase'], $userId, $date);
            $subject     = "Welcome to London Projects Dashboard";
            $to          = $_POST['email'];
            $body        = '<!DOCTYPE html>
            <html>
            <head>
            <meta charset="utf-8" />
            <title>Welcome to London Projects Dashboard</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            </head>
            <body>
            <div>
            <div style="font-size: 26px;font-weight: 700;letter-spacing: -0.02em;line-height: 32px;color: #41637e;font-family: sans-serif;text-align: center" align="center" id="emb-email-header">
            </div>
            <p style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Please click on the link below to set your password.</p>
            <p style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">'.$emailLink.'</p>
            <p style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Many thanks the London Projects Team</p>
            </div>
            </div>
            </body>
            </html>';
            $this->common->sendEmail($to, $subject, $body);
        }
    }

    function addLoginAttempt($value)
    {
        //Increase number of attempts. Set last login attempt if required.
        $q     = "SELECT * FROM crm_users_attempts WHERE ip = '$value'";
        $query = $this->db->query($q);
        $data  = $query->result_array();
        if ($data) {
            $attempts = $data[0]["Attempts"] + 1;
            if ($attempts == 3) {
                $q     = "UPDATE crm_users_attempts SET attempts=".$attempts.", lastlogin=NOW() WHERE ip = '$value'";
                $query = $this->db->query($q);
            }
            else {
                $q     = "UPDATE crm_users_attempts SET attempts=".$attempts." WHERE ip = '$value'";
                $query = $this->db->query($q);
            }
        }
        else {
            $q     = "INSERT INTO crm_users_attempts (attempts,IP,lastlogin) values (1, '$value', NOW())";
            $query = $this->db->query($q);
        }
    }

    function clearLoginAttempts($value)
    {
        $q     = "UPDATE crm_users_attempts SET attempts = 0 WHERE ip = '$value'";
        $query = $this->db->query($q);
        return $query;
    }

    function checkLoginAttempts($value)
    {
        $q        = "SELECT attempts, (CASE when lastlogin is not NULL and DATE_ADD(LastLogin, INTERVAL 5 MINUTE)>NOW() then 1 else 0 end) as Denied FROM crm_users_attempts WHERE ip = '$value'";
        $query    = $this->db->query($q);
        $result   = $query->result_array();
        $db_error = $this->db->error();
        if (!empty($db_error['code']) and $db_error['code'] !== 0) {
            return false;
        } else {
            return $result;
        }
    }

    function hash_password($password_to_hash)
    {
        $hash = password_hash($password_to_hash, PASSWORD_DEFAULT);
        return $hash;
    }

    function check_login_data($username, $password)
    {
        $query = $this->db->select('crm_users.*')
            ->from('crm_users')
            ->where('email', $username)
            ->where('deleted', 0)
            ->get();
           # echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            if (password_verify($password, $row['password'])) {
                return $row;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function update_login_password($user_id, $new_password)
    {
        $data = array('password'=> $this->hash_password($new_password));
        $this->db->where('id', $user_id);
        $this->db->update('crm_users', $data);
        $db_error = $this->db->error();
        if (!empty($db_error['code']) and $db_error['code'] !== 0) {
            return false;
        } else {
            return true;
        }
    }

    public function savePasswordResetToDatabase($tokenHashForDatabase, $userId, $creationDate)
    {
        $data = array(
            'change_password_token'          => $tokenHashForDatabase,
            'change_password_token_creation' => $creationDate
        );
        $this->db->where('id', $userId);
        $this->db->update('crm_users', $data);

        $db_error = $this->db->error();
        if (!empty($db_error['code']) and $db_error['code'] !== 0) {
            return false;
        } else {
            return true;
        }
    }

    public function loadPasswordResetFromDatabase($tokenHashForDatabase)
    {
        $this->db->select('*');
        $this->db->from('crm_users');
        $this->db->where('change_password_token', $tokenHashForDatabase);
        $query    = $this->db->get();
        $row      = $query->row_array();
        $db_error = $this->db->error();
        if (!empty($db_error['code']) and $db_error['code'] !== 0) {
            return false;
        } else {
            return $row;
        }
    }

    /*---Check user name exist--------*/
    public function findUserByEmail($email)
    {
        $this->db->select('id');
        $this->db->from('crm_users');
        $this->db->where('email', $email);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $dets = $query->row();
            return $dets->id;
        } else {
            return null;
        }
    }

}
