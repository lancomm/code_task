<?php
echo $this->load->view("admin/includes/top", '', true);
$form['title'] = 'Add/Edit' . ' ' . uCfirst($type);
$form['skipProjectDetails'] = true;
$data['job_titles'] = $this->common->get_select_list(
    'crm_params',
    [
        'value_field'   => 'id',
        'text_field'    => 'name'
    ],
    [
        'description'   => 'Job Title'
    ]
);

$data['title_options'] = array('' => 'Select Title') + $data['job_titles'];

if ($type == 'clients' || $type == 'professionals') {
    $entityDisabled = $this->router->fetch_method() == 'edit_contact' ? true : '';
    $form['input_group'] = array(
        'entity_id' => [
            'required'  => true,
            'type'      => 'select',
            'options'   => $this->common->get_params_list('Entity Type'),
            'disabled'  => $entityDisabled
        ],
    );

    $businessDisabled = '';
    $personalDisabled = '';

    if (empty($this->data['entity_id'])) {
        $personal['form_style'] = 'display:none';
        $business['form_style'] = 'display:none';
    } else {
        if ($this->data['entity_id'] == 204) {
            $businessDisabled = 'disabled';
            $personalDisabled = '';
            $business['form_style'] = 'display:none';
            $personal['form_style'] = 'display:';

            $projects['form_style'] = 'display:';
            $description['form_style'] = 'display:';
        }
        if ($this->data['entity_id'] == 205) {
            $personalDisabled = 'disabled';
            $businessDisabled = '';
            $business['form_style'] = 'display:';
            $personal['form_style'] = 'display:none';

            $projects['form_style'] = 'display:';
            $description['form_style'] = 'display:';
        }
    }

    $personal['input_group']= array(
        'title_id' => [
            'required'  => true,
            'type'      => 'select',
            'disabled'  => $personalDisabled,
            'options'   => $this->common->get_params_list('title')
        ],
        'name' => [
            'disabled'  => $personalDisabled,
            'required'  => true,
        ],
        'surname' => [
            'required'  => true,
            'disabled'  => $personalDisabled,
        ],
        'address_1' => [
            'required'  => true,
            'disabled'  => $personalDisabled,
        ],
        'address_2' => [
            'disabled'  => $personalDisabled,
        ],
        'address_3' => [
            'disabled'  => $personalDisabled,
        ],
        'town' => [
            'disabled'  => $personalDisabled,
        ],
        'city' => [
            'disabled'  => $personalDisabled,
            'required'  => true,
        ],
        'postcode' => [
            'disabled'  => $personalDisabled,
            'required'  => true,
        ],
        'phone' => [
            'disabled'  => $personalDisabled,
            'required'  => true,
            'label' => 'Phone',
        ],
        'email' => [
            'disabled'  => $personalDisabled,
            'required'  => true,
            'html_required' => true,
            'label'     => 'Email',
        ],
        'country' => [
            'disabled'  => $personalDisabled,
            'required'  => true,
            'type'      => 'select',
            'options' 	=> $this->common->countries_list()
        ]
    );

    $business['input_group'] = array(
        'name' => [
            'label' => 'Company Name',
            'required'  => true,
            'disabled'  => $businessDisabled,
        ],
        'address_1' => [
            'required'  => true,
            'disabled'  => $businessDisabled,
        ],
        'address_2' => [
            'disabled'  => $businessDisabled,
        ],
        'address_3' => [
            'disabled'  => $businessDisabled,
        ],
        'town' => [
            'disabled'  => $businessDisabled,
        ],
        'city' => [
            'disabled'  => $businessDisabled,
            'required'  => true,
        ],
        'postcode' => [
            'disabled'  => $businessDisabled,
            'required'  => true,
        ],
        'phone' => [
            'disabled'  => $businessDisabled,
            'required'  => true,
            'label' => 'Phone',
        ],
        'email' => [
            'disabled'  => $businessDisabled,
            'required'  => true,
            'html_required' => true,
            'label'     => 'Email',
        ],
        'country' => [
            'disabled'  => $businessDisabled,
            'required'  => true,
            'type'      => 'select',
            'options' 	=> $this->common->countries_list()
        ]
    );

    $personal['skipHeader'] = true;
    $personal['form_id']    = 'personal_form';
    $personal['form_class'] = 'personal_form';

    $business['skipHeader'] = true;
    $business['form_id']    = 'business_form';
    $business['form_class'] = 'business_form';
} else {
    $form['input_group'] = array(
        'name' => [
            'required'  => true,
        ],
        'address_1' => [
            'required'  => true,
        ],
        'address_2' => [
        ],
        'address_3' => [
        ],
        'town' => [
        ],
        'city' => [
            'required'  => true,
        ],
        'postcode' => [
            'required'  => true,
        ],
        'phone' => [
            'required'  => true,
            'label' => 'Phone',
        ],
        'email' => [
            'required'  => true,
            'html_required' => true,
            'label'     => 'Email',
        ],
        'country' => [
            'required'  => true,
            'type'      => 'select',
            'options' 	=> $this->common->countries_list()
        ]
    );
}

if ($type == 'clients') {
    $projects['input_group']['project_ids'] = [
        'required'  => true,
        'html_required' => true,
        'type'      => 'select_multiple',
        'label'     => 'Projects',
        'id'        => 'select_2_projects',
        'col'      => '2',
        'tool-tip'  => 'Add projects client is associated to.',
        'options'   => $this->common->get_select_list(
            'crm_projects',
            [
                'value_field'   => 'id',
                'text_field'    => 'address_1'
            ]
        ),
    ];
}

if ($this->data['type'] == 170) {
    $business['input_group']['vat_number'] = [
    ];
    $business['input_group']['company_number'] = [
    ];
    $personal['input_group']['vat_number'] = [
    ];
    $personal['input_group']['company_number'] = [
    ];
} elseif ($this->data['type'] == 176) {
    $form['input_group']['trade_ids'] = [
        'type'     => 'select_multiple',
        'tool-tip'  => 'Add subcontractors trade e.g (Electrician, Carpenter).',
        'options'  => $this->common->get_select_list('crm_trade', ['value_field' => 'id', 'text_field' => 'name']),
    ];
    $form['input_group']['utr_number'] = [
    ];
    $form['input_group']['vat_number'] = [
    ];
    $form['input_group']['company_number'] = [
    ];
}

if ($this->data['type'] == 176) {
    $form['input_group']['cis_payment'] = [
        'type'  => 'select',
        'options' => $this->common->get_params_list('Cis Payment Type')
    ];
    $form['input_group']['cis_percentage'] = [
        'type'  => 'select',
        'options' => [
            0   => '0%',
            20 => '20%',
            30  => '30%'
        ]
    ];
}

$attributes = array(
	'name'     => "add_contact",
	'method'   => "post",
);

$hidden = array(
    'type'      => $this->data['type'],
    'active'    => 0
);

if (!empty($this->data['project_id'])) {
	$hidden['project_id'] = $this->data['project_id'];
}

if (!empty($this->data['id'])) {
	$hidden['id'] = $this->data['id'];
}

echo form_open_multipart('', $attributes, $hidden);
$this->load->view('form_template', $form);
$details['skipHeader'] = true;

$details['form_class'] = 'details_form';
$details['form_id'] = 'details_form';

$projects['skipHeader'] = true;

$projects['form_class'] = 'projects_form';
$projects['form_id'] = 'projects_form';

$details['input_group']['description'] = [
    'type'  => 'textarea',
    'col'  => 2
];

$details['input_group']['notes'] = [
    'type'  => 'textarea',
    'col'  => 2
];

if ($type == 'clients' || $type == 'professionals') {
    $this->load->view('form_template', $personal);
    $this->load->view('form_template', $business);
}

if ($type == 'clients') {
    $this->load->view('form_template', $projects);
}

$this->load->view('form_template', $details);

if (!empty($notes)) {
    echo $this->load->view('elements/get_notes', ['title' => 'Notes'], true);
}

$this->load->view('elements/add_contacts', $data);

if ($this->data['type'] == 176) {
    $formFiles['input_group']['files'] =  [
        'label'     => 'Insurance Documents',
        'type'      => 'file',
        'id'        => "filer_input",
        'multiple'  => true,
        'col'       => 2,
    ];

    $formFiles['title'] = 'Insurance';
    $this->load->view('form_template', $formFiles);
    $this->load->view(
        'elements/insurances',
        [
            'title' => false,
            'headers' => [
                'Type',
                'Amount',
                'Expiry',
            ],
            'insurances'    => [
                'employers_liability',
                'products_liability',
                'contractors_liability',
                'professional_indemnity',
                'excess_public_liability'
            ],
        ]
    );
    if (!empty($files)) {
        $data['fileType'] = 195;
        echo $this->load->view('elements/files', $data, true);
    }
}
$formButtons['cancel'] = base_url().''.$this->router->fetch_class().'/contacts_index/'.$type;
$this->load->view('elements/form_buttons', $formButtons);
echo form_close();
?>
<script type='text/javascript' src='<?php echo base_url();?>js/contacts.js'></script>
<?php
echo $this->load->view("admin/includes/footer", '', true);
?>
