<?php

class Common_model extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->validation_messages();
    }

    /**
        * redirects to index if theres a session url varaible
        * @param string $sessionVar
        * @return array where/like attributes for mysql query
    */
    function redirectIndex(string $controller) {
        if (!empty($this->session->userdata($controller.'_url'))) {
            redirect($controller.'/index?' . $this->session->userdata($controller.'_url'));
        } else {
            redirect($controller.'/index');
        }
    }





    public function isLiveServer()
    {
        if ($_SERVER['HTTP_HOST'] === 'itrackprojects.co.uk') {
            return true;
        } else {
            return false;
        }
    }

    function changeEmptyToNull($postValues = null) {
        if (!empty($postValues)) {
            foreach ($postValues as $key => $value) {

                if ($postValues[$key] == 0) {
                    continue;
                }

                if (empty($postValues[$key]) || $postValues[$key] == '') {
                    unset($postValues[$key]);
                }
            }
        }

        return $postValues;
    }

    function get_field($tablename = '', $field = '', $where = '')
    {
        $this->db->where($where);
        $this->db->select($field);
        $query = $this->db->get($tablename);
        $row   = $query->row_array();
        if (!empty($row)) {
            $result = $row[$field];
        } else {
            $result = '';
        }

        $db_error = $this->db->error();
        if (!empty($db_error['code']) and $db_error['code'] !== 0) {
            return false;
        } else {
            return $result;
        }
    }

    function user_select($where = [])
    {
        $this->db->select('*');
        $this->db->from('crm_users');

        if (!empty($where)) {
            $this->db->where($where);
        }

        $query = $this->db->get();

        $db_error = $this->db->error();
        if (!empty($db_error['code']) and $db_error['code'] !== 0) {
            return false;
        } else {
            $array = [];
            foreach ($query->result_array() as $result) {
                $array[$result['id']] = ucfirst($result['name']) . ' ' . ucfirst($result['surname']);
            }
            return $array;
        }
    }



    function get_select_list(
        $table = null, $fields = array(), $where = array(),
        $orderBy = array(), $where_in = array(), $joins = array(),
        $select = array(), $where_not_in = array()
    ) {
        if (empty($select)) {
            $this->db->select('*');
        } else {
            $this->db->select($select);
        }

        $this->db->from($table);

        foreach ($where as $wh_key => $wh_value) {
            $this->db->where($wh_key, $wh_value);
        }
        if (!empty($where_in)) {
            foreach ($where_in as $wh_key => $wh_val) {
                $this->db->where_in($wh_key, $wh_val);
            }
        }

        if (!empty($where_not_in)) {
            foreach ($where_not_in as $wh_not_key => $wh_not_val) {
                $this->db->where_in($wh_not_key, $wh_not_val);
            }
        }

        if (!empty($joins)) {
            foreach ($joins as $join) {
                $this->db->join($join[0], $join[1], $join[2]);
            }
        }
        if (!empty($orderBy)) {
            foreach ($orderBy as $ord_key => $ord_value) {
                $this->db->order_by($ord_key, $ord_value);
            }
        } else {
            $this->db->order_by($fields['text_field'], 'Asc');
        }

        $query    = $this->db->get();
        $db_error = $this->db->error();
        if (!empty($db_error['code']) and $db_error['code'] !== 0) {
            return false;
        } else {
            $array = [];

            foreach ($query->result_array() as $result) {
                $array[$result[$fields['value_field']]] = ucfirst($result[$fields['text_field'] ]);
            }

            return $array;
        }
    }

    function get_params_list($type = '')
    {
        $this->db->select('*');
        $this->db->from('crm_params');
        $this->db->where('description', $type);
        $this->db->order_by('name');
        $query    = $this->db->get();

        $db_error = $this->db->error();
        if (!empty($db_error['code']) and $db_error['code'] !== 0) {
            return false;
        } else {
            foreach ($query->result_array() as $param => $fields) {
                $array[$fields['id']] = ucfirst($fields['name']);
            }
            if (!empty($array)) {
                return $array;
            }
        }
    }

    function countries_list()
    {
        $countries = array("United Kingdom","Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antarctica","Antigua and Barbuda","Argentina","Armenia",
            "Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia",
            "Bosnia and Herzegowina","Botswana","Bouvet Island","Brazil","British Indian Ocean Territory","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia",
            "Cameroon","Canada","Cape Verde","Cayman Islands","Central African Republic","Chad","Chile","China","Christmas Island","Cocos (Keeling) Islands","Colombia",
            "Comoros","Congo","Congo, the Democratic Republic of the","Cook Islands","Costa Rica","Cote d'Ivoire","Croatia (Hrvatska)","Cuba","Cyprus","Czech Republic",
            "Denmark","Djibouti","Dominica","Dominican Republic","East Timor","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia",
            "Falkland Islands (Malvinas)","Faroe Islands","Fiji","Finland","France","France Metropolitan","French Guiana","French Polynesia","French Southern Territories",
            "Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guinea","Guinea-Bissau","Guyana",
            "Haiti","Heard and Mc Donald Islands","Holy See (Vatican City State)","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran (Islamic Republic of)",
            "Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Korea, Democratic People's Republic of","Korea, Republic of",
            "Kuwait","Kyrgyzstan","Lao, People's Democratic Republic","Latvia","Lebanon","Lesotho","Liberia","Libyan Arab Jamahiriya","Liechtenstein","Lithuania","Luxembourg",
            "Macau","Macedonia, The Former Yugoslav Republic of","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Martinique","Mauritania",
            "Mauritius","Mayotte","Mexico","Micronesia, Federated States of","Moldova, Republic of","Monaco","Mongolia","Montserrat","Morocco","Mozambique","Myanmar",
            "Namibia","Nauru","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island",
            "Northern Mariana Islands","Norway","Oman","Pakistan","Palau","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn","Poland","Portugal",
            "Puerto Rico","Qatar","Reunion","Romania","Russian Federation","Rwanda","Saint Kitts and Nevis","Saint Lucia","Saint Vincent and the Grenadines","Samoa",
            "San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Seychelles","Sierra Leone","Singapore","Slovakia (Slovak Republic)","Slovenia","Solomon Islands",
            "Somalia","South Africa","South Georgia and the South Sandwich Islands","Spain","Sri Lanka","St. Helena","St. Pierre and Miquelon","Sudan","Suriname",
            "Svalbard and Jan Mayen Islands","Swaziland","Sweden","Switzerland","Syrian Arab Republic","Taiwan, Province of China","Tajikistan","Tanzania, United Republic of",
            "Thailand","Togo","Tokelau","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Turks and Caicos Islands","Tuvalu","Uganda","Ukraine",
            "United Arab Emirates","United Kingdom","United States","United States Minor Outlying Islands","Uruguay","Uzbekistan","Vanuatu","Venezuela","Vietnam",
            "Virgin Islands (British)","Virgin Islands (U.S.)","Wallis and Futuna Islands","Western Sahara","Yemen","Yugoslavia","Zambia","Zimbabwe");

        foreach ($countries as $country) {
            $array[$country] = $country;
        }

        return $array;
    }

    public function findById($table = null, $id = null, $array = false)
    {
        if ($table == null || $id == null) {
            return false;
        }
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('id', $id);
        $query    = $this->db->get();
        $row      = $query->row_array();

        $db_error = $this->db->error();
        if (!empty($db_error['code']) and $db_error['code'] !== 0) {
            return false;
        } else {
            if ($array === true) {
                return (array) $row;
            } else {
                return $row;
            }
        }
        return false;
    }


    function add_record($table = null, $fields = array())
    {
        if ($table == null || empty($fields)) {
            return false;
        }

        $this->db->insert($table, $fields);

        $insert_id = $this->db->insert_id();
        if (!empty($db_error['code']) and $db_error['code'] !== 0) {
            return false;
        } else {
           // $this->log_changes($table, $fields, $insert_id, "ADD");
            return $insert_id;
        }

        return false;
    }

    function update_record($table = null, $fields = array())
    {
        if ($table == null || empty($fields) || empty($fields['id'])) {
            return false;
        }

        $original = (array) $this->common->fetch_all(
            $table,
            [implode(',', array_keys($fields))],
            [
                'id' => $fields['id']
            ],
            null, null, null, true,
            false
        );

        if (array_diff_assoc($original, $fields)) {
            $intersect = array_intersect($original, $fields);
            $from = array_diff($original, $intersect);
            $to = array_diff($fields, $intersect);

            $this->db->where('id', $fields['id']);
            $log_id = $fields['id'];
            unset($fields['id']);
            $this->db->set($fields);
            $this->db->update($table);
            if (!empty($db_error['code']) and $db_error['code'] !== 0) {
                return false;
            } else {
               # $this->log_changes($table, $to, $log_id, "UPDATE", null, $from, $to);
                return true;
            }

            return false;
        } else {
            return true;
        }
    }

    function update($table = null, $fields = array(), $where = array(), $where_in = array(), $where_not_in = array())
    {
        if ($table == null || empty($fields) || empty($where)) {
            return false;
        }

        if (!empty($where_in)) {
            $this->db->where_in($where_in);
        }

        if (!empty($where_not_in)) {
            $this->db->where_not_in($where_in);
        }

        $this->db->where($where);
        $this->db->set($fields);

        $this->db->update($table);

        if (!empty($db_error['code']) and $db_error['code'] !== 0) {
            return false;
        } else {
            $this->log_changes($table, $fields, null, "UPDATE_MULTIPLE", $where);
            return true;
        }

        return false;
    }

    function delete($table = null, $where = array())
    {
        if ($table == null) {
            return false;
        }

        foreach ($where as $wh_key => $wh_value) {
            $this->db->where($wh_key, $wh_value);
        }

        $fields['deleted'] = 1;
        $this->db->set($fields);

        $id = $this->db->update($table);
        $this->log_changes($table, $fields, null, "DELETE_MULTIPLE", $where);
        if (!empty($db_error['code']) and $db_error['code'] !== 0) {
            return false;
        } else {
            return $id;
        }

        return false;
    }

    function delete_record($table = null, $id = null)
    {

        if ($table == null || $id == null) {
            return false;
        }
        $this->db->where('id', $id);
        $fields['deleted'] = 1;
        $this->db->set($fields);

        $id = $this->db->update($table);
       // $this->log_changes($table, $fields, $id, "DELETE", null);

        if (!empty($db_error['code']) and $db_error['code'] !== 0) {
            return false;
        } else {
            return $id;
        }

        return false;
    }

    function fetch_where_in($table, $fields = null, $key = null, $whereIn = null, $where = null, $joins = null, $orderBy = null)
    {
        if ($table == null) {
            return false;
        }
        $this->db->from($table);

        if ($joins != null) {
            foreach ($joins as $join) {
                $this->db->join($join[0], $join[1], $join[2]);
            }
        }

        if ($fields != null) {
            $this->db->select(implode(',', $fields));
        }

        $this->db->where_in($key, $whereIn);
        if ($where != null) {
            $this->db->where($where);
        }

        if (!empty($orderBy)) {
            foreach ($orderBy as $ord_key => $ord_value) {
                $this->db->order_by($ord_key, $ord_value);
            }
        }

        $query    = $this->db->get();

        $db_error = $this->db->error();
        if (!empty($db_error['code']) and $db_error['code'] !== 0) {
            return false;
        } else {
            return $query->result();
        }
    }


    /**
        * returns results from mysql database
        * @param string $table
        * @param array $fields
        * @param array $where
        * @param array $joins
        * @param array $orderby
        * @param array $limit
        * @param bool $fetch_row
        * @param bool $deleted
        * @param bool $fetch_array
        * @param array $group_by
        * @return array
    */
    function fetch_all(
        $table = null, $fields = null, $where = null,
        $joins = null, $orderby = null, $limit = null, $fetch_row = false,
        $deleted = true, $fetch_array = false, $groupby = false
    )
    {
        if ($table == null) {
            return false;
        }
        $this->db->from($table);

        if ($groupby != false) {
            $this->db->group_by($groupby);
        }

        if ($fields != null) {
            $this->db->select(implode(',', $fields));
        }

        if ($joins != null) {
            foreach ($joins as $join) {
                $this->db->join($join[0], $join[1], $join[2]);
            }
        }

        if ($orderby != null) {
            foreach ($orderby as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }

        if ($limit != null) {
            if (!empty($limit[1])) {
                $this->db->limit($limit[0], $limit[1]);
            } else {
                $this->db->limit($limit[0]);
            }
        }

        if ($deleted == true) {
            $where[$table.'.deleted'] = 0;
        }

        if ($where != null) {
            $this->db->where($where);
        }

        $query    = $this->db->get();

        $db_error = $this->db->error();
        if (!empty($db_error['code']) and $db_error['code'] !== 0) {
            return false;
        } else {
            if ($fetch_row == true) {
                return $query->row();
            } elseif ($fetch_array == true) {
                return $query->result_array();
            } else {
                return $query->result();
            }
        }
    }

    function validation_messages()
    {
        $this->form_validation->set_message('required', '%s is required.');
        $this->form_validation->set_message('min_length', '%s must be at least %s characters in length..');
        $this->form_validation->set_message('max_length', '%s field can not exceed %s characters in length.');
        $this->form_validation->set_message('matches', '%s does not match the %s');
        $this->form_validation->set_message('valid_email', '%s must contain a valid email address.');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
    }






}
