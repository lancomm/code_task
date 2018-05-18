<?php
echo $this->load->view("admin/includes/top", '', true);
$form['title'] = 'Add/Edit' . ' ' . uCfirst($type);
$form['skipProjectDetails'] = true;
$job_titles = $this->common->get_select_list(
    'crm_params',
    [
        'value_field'   => 'id',
        'text_field'    => 'name'
    ],
    [
        'description'   => 'Job Title'
    ]
);

$title_options = array('' => 'Select Title') + $job_titles;

if ($type == 'clients') {
    $form['input_group'] = array(
        'entity_id' => [
            'required'  => true,
            'type'      => 'select',
            'disabled'  =>true,
            'options'   => $this->common->get_params_list('Entity Type')
        ],
    );

    $businessDisabled = true;
    $personalDisabled = true;

    if (empty($this->data['entity_id'])) {
        $personal['form_style'] = 'display:none';
        $business['form_style'] = 'display:none';
    } else {
        if ($this->data['entity_id'] == 204) {
            $business['form_style'] = 'display:none';
            $personal['form_style'] = 'display:';
        }
        if ($this->data['entity_id'] == 205) {
            $business['form_style'] = 'display:';
            $personal['form_style'] = 'display:none';
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
            'label' => $this->data['type'] == 170 ? 'Company Name' : 'Name',
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

if ($this->data['type'] == 170) {
    $form['input_group']['vat_number'] = [
    ];
    $form['input_group']['company_number'] = [
    ];
} elseif ($this->data['type'] == 176) {
    $form['input_group']['trade_ids'] = [
        'type'     => 'select_multiple',
        'tool-tip'  => 'Add additional weather not displayed in the weather text input above',
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
            25 => '20%',
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

$this->load->view('form_template', $form);
$details['skipHeader'] = true;

$details['form_class'] = 'details_form';
$details['form_id'] = 'details_form';
$details['input_group']['description'] = [
    'type'  => 'textarea',
    'disabled'  => true,
    'col'  => 2
];

$details['input_group']['notes'] = [
    'type'  => 'textarea',
    'disabled'  => true,
    'col'  => 2
];

if ($type == 'clients') {
    $this->load->view('form_template', $personal);
    $this->load->view('form_template', $business);
}

$this->load->view('form_template', $details);

if (!empty($notes)) {
    echo $this->load->view('elements/get_notes', ['title' => 'Notes'], true);
}
?>
<div class="row">
    <div class="col-md-12">
        <legend><?php echo ucfirst($type);?> - Employees/Contacts</legend>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="row clearfix">
    		<div class="col-md-12 column">
    			<table class="table table-bordered table-hover" id="table_contact_details">
    				<thead>
    					<tr >
    						<th class="text-center">
    							Name
    						</th>
    						<th class="text-center">
    							Job Title
    						</th>
    						<th class="text-center">
    							Phone
    						</th>
    						<th class="text-center">
    							Email
    						</th>
                            <th class="text-center">
    							Actions
    						</th>
    					</tr>
    				</thead>
    				<tbody id='contacts_details'>
    					<tr id='addr0'>
    						<td>
                                <input
                                    class="form-control"
                                    type="text"
                                    id='contact_name'
                                    style='text-align:center;'
                                />
    						</td>
    						<td>
                                <?php
                                echo form_dropdown(
                                    '',
                                    $title_options,
                                    '',
                                    [
                                        'class' => 'form-control',
                                        'id'    => 'contact_title',
                                    ]
                                );
                                ?>
    						</td>
    						<td>
                                <input
                                    id="contact_phone"
                                    type="text"
                                    class="form-control"
                                    style='text-align:center;'
                                />
    						</td>
    						<td>
                                <input
                                    id="contact_email"
                                    type="text"
                                    class="form-control"
                                    style='text-align:center;'
                                />
    						</td>
                            <td>
                                <a id="add_contact" class="btn btn-default btn-success"><i class="fa fa-plus"></i></a>
                            </td>
    					</tr>
                        <?php
                        if (!empty($linked_contacts)) {
                            foreach ($linked_contacts as $lc_id => $lc_values) {
                            ?>
                                <tr>
                                    <td>
                                        <input type='hidden' name='short_form_contact_id[]' value='<?php echo $lc_id; ?>'>
                                        <input type='hidden' name='contact_name[]' value='<?php echo $lc_values['name']; ?>'>
                                        <?php
                                            echo $lc_values['name'];
                                        ?>
                                    </td>
                                    <td>
                                        <input type='hidden' name='contact_title[]' value='<?php echo $lc_values['job_title_id']; ?>'>
                                        <?php
                                            echo $title_options[$lc_values['job_title_id']];
                                        ?>
                                    </td>
                                    <td>
                                        <input type='hidden' name='contact_phone[]' value='<?php echo $lc_values['phone']; ?>'>
                                        <?php
                                            echo $lc_values['phone'];
                                        ?>
                                    </td>
                                    <td>
                                        <input type='hidden' name='contact_email[]' value='<?php echo $lc_values['email']; ?>'>
                                        <?php
                                            echo $lc_values['email'];
                                        ?>
                                    </td>
                                    <td>
                                        <a id="delete_contact" class="btn btn-default btn-danger"><i class="fa fa-minus"></i></a>
                                    </td>
                                </tr>
                            <?php
                            }
                        }
                        ?>
    				</tbody>
    			</table>
    		</div>
    	</div>
    </div>
</div>
<?php


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
$formButtons['submitButton'] = true;
$formButtons['cancel'] = base_url().''.$this->router->fetch_class().'/contacts_index/'.$type;
$this->load->view('elements/form_buttons', $formButtons);
echo $this->load->view("admin/includes/footer", '', true);
?>
<script type='text/javascript' src='<?php echo base_url();?>js/contacts.js'></script>
