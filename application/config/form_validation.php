<?php
$config = array(
	'change_password' => array(
        array(
            'field'   => 'password',
            'label'   => 'Password',
            'rules'   => array(
                array(
                        'check_password',
                        function ($password)
                        {
                            if(strlen($password) < 8) {
                                return false;
                            } elseif(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/', $password) ==0) {

                                return false;
                            }
                            return true;
                        }
                )
            ),
            'errors' => array(

                'check_password' => 'Password must be at least 8 characters and a mixture of uppercase, lowercase, numbers and a special character.',
            )
        )
    ),
'users_address' => array(
array('field'   => 'address_1',
      'label'   => 'Address Line 1',
      'rules'   => 'trim|required'
      ),
      array('field'   => 'address_2',
      'label'   => 'Address Line ',
      'rules'   => 'trim|required'
      ),
      array('field'   => 'town',
      'label'   => 'Town ',
      'rules'   => 'trim|required'
      ),
      array('field'   => 'postcode',
      'label'   => 'Post Code',
      'rules'   => 'trim|required'
      ),
      array('field'   => 'country',
      'label'   => 'Country',
      'rules'   => 'trim|required'
      ),
       array('field'   => 'from_date',
      'label'   => 'From',
      'rules'   => 'trim|required'
      ),
      array('field'   => 'to_date',
      'label'   => 'Till',
      'rules'   => 'trim|required'
      ),
),



    'users_add_edit' => array(
        array(
            'field'   => 'forename',
            'label'   => 'Forename',
            'rules'   => 'trim|required'
        ),
        array(
            'field'   => 'surname',
            'label'   => 'Surname',
            'rules'   => 'trim|required'
        ),
         array(
            'field'   => 'password',
            'label'   => 'Password',
            'rules'   => 'trim|required'
        ),
         array(
            'field'   => 'retype_password',
            'label'   => 'retype_password',
            'rules'   => 'required|matches[password]'
        ),
    ),

);
