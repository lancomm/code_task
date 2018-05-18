<?php
$table['title'] = 'User Details';
$table['headers'] = [
    'Name' => [
        "data-class" => "expand"
    ],
    'Gender' => [
        'data-hide' => "phone,tablet"
    ],
    'User Email' => [
        'data-hide' => "phone,tablet"
    ],
    'User DOB' => [
        'data-hide' => "phone,tablet"
    ],
];

foreach ($user_details as $key => $data) {
    $row[$data->id] = [
    	$this->common->get_field(
            'crm_params',
            'name',
            [
                'id'    => $data->title_id
            ]
        ). ' '.$data->forename . ' ' . $data->surname,
        $this->common->get_field(
            'crm_params',
            'name',
            [
                'id'    => $data->gender_id
            ]
        ),
        $data->email,
        $data->dob
    ];

    $table['rows'][] = $row;
    unset($row);
}
    $actions = true;
    $table['actions']['edit'] = true;
    $table['actions']['edit_method'] = "users";
    $table['actions']['delete'] = true;
    $table['actions']['delete_method'] = "users";


if ((!empty($actions))) {
    $table['headers']['Actions'] = [
        'data-hide' => "phone,tablet"
    ];
}
?>
<a href="<?php echo base_url().'index.php/Admin/logout';?>">
<button>Logout</button>
</a>
<br />
<br />
<?php

echo $this->load->view("elements/data_table.php", $table, true);
unset($table['rows']);
$table['rows'] = null;

$ad_table['title'] = 'User Addreses';
$ad_table['headers'] = [
    'From' => [
        "data-class" => "expand"
    ],
    'To' => [
        "data-class" => "expand"
    ],
    'Address' => [
        "data-class" => "expand"
    ],
    'Town' => [
        'data-hide' => "phone,tablet"
    ],
    'County' => [
        'data-hide' => "phone,tablet"
    ],
    'Postcode' => [
        'data-hide' => "phone,tablet"
    ],
    'Country' => [
        'data-hide' => "phone,tablet"
    ],
];
 $ad_table['rows'] = null;
foreach ($registered_addresses as $key => $data) {
	echo $key;
    $row_ad[$data->id] = [
    	$data->from_date,
    	$data->to_date,
        $data->address_1.' '.$data->address_2,
        $data->town,
        $data->county,
        $data->postcode,
        $data->country,
        
    ];

    $ad_table['rows'][] = $row_ad;
    unset($row_ad);
}
 
    $actions = true;
    $ad_table['actions']['edit'] = true;
    $ad_table['actions']['edit_method'] = "address";
    $ad_table['actions']['delete'] = true;
    $ad_table['actions']['delete_method'] = "address";
    
    if ((!empty($actions))) {
    $ad_table['headers']['Actions'] = [
        'data-hide' => "phone,tablet"
    ];
}
$ad_table['custom_action']['method'] = "Add";
$ad_table['custom_action']['url'] = base_url()."index.php/address/add/".$user_id;

echo $this->load->view("elements/data_table.php", $ad_table, true);

echo $this->load->view("admin/includes/footer",null,true);
?>
