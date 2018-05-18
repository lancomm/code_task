<?php
echo $this->load->view("admin/includes/top", $this->data, true);
$table['title'] = $title;
$table['search'] = [
    'keyword' => [
    ],
];

$table['searchAction'] = $searchAction;

$table['headers'] = [
    'Name' => [
        "data-class" => "expand"
    ],
    'eMail' => [
        'data-hide' => "phone,tablet"
    ],
    'Phone' => [
        'data-hide' => "phone,tablet"
    ],
    'Notes' => [
        'data-hide' => "phone,tablet"
    ]
];

if ($type == 'subcontractors') {
    $table['headers']['Rating'] = [
        'data-hide' => "phone,tablet"
    ];
    $table['headers']['Trades'] = [
        'data-hide' => "phone,tablet"
    ];
    $table['headers']['Projects'] = [
        'data-hide' => "phone,tablet"
    ];
}

if ($type == 'suppliers') {
    $table['headers']['Projects'] = [
        'data-hide' => "phone,tablet"
    ];
}

$table['skipProjectDetails'] = true;

if ($this->common->check_permission('contacts', 'write') != false) {
    $table['add'] = base_url().''.$this->router->fetch_class().'/add_contact/'.$type;
}

if ($contact_list) {
    foreach ($contact_list as $contact) {
        $actions = '';
        $tradeString = '';
        if (!empty($contact->trade_ids)) {
            $tradeArray = [];
            $trade_ids = explode(',', $contact->trade_ids);
            foreach ($trade_ids as $ti) {
                $tradeArray[] = $trades[$ti];
            }
            $tradeString = implode(', ', $tradeArray);
        }

        $notes = $this->common->fetch_all(
            'crm_notes',
            [],
            [
                'table' => 'crm_users',
                'object_id' => $contact->id
            ],
            null, null, null, false, false
        );

        $name = empty($contact->title) ? '' : $contact->title . ' ';
        $name .= uCfirst($contact->name);
        $name .= empty($contact->surname) ? '' : ' ' . uCfirst($contact->surname);
        if ($type == 'clients') {
            $row[$contact->id] = [
                $name,
                $contact->email,
                $contact->phone,
                empty($notes) ? '<center>N/A</center>' : '<center><u><a href="#modal-global" id="custId" data-toggle="modal" onclick=\'getNotes('.$contact->id.', "crm_users")\'>Notes</a></u></center>',
            ];
        } else {
            $row[$contact->id] = [
                $name,
                $contact->email,
                $contact->phone,
                empty($notes) ? '<center>N/A</center>' : '<center><u><a href="#modal-global" id="custId" data-toggle="modal" onclick=\'getNotes('.$contact->id.', "crm_users")\'>Notes</a></u></center>',
            ];
        }

        if ($type == 'subcontractors') {
            $actions .= "<a title='Rate'
                href='" . base_url(). "Subcontractor_Ratings/add/" . $contact->id . "'>
                <button title='rate' class='btn btn-xs btn-default' type='button'>
                    <i class='fa fa-star'></i>
                </button>
            </a>";

            $ratingIndex = $this->users->getRating($contact->id);

            if ($ratingIndex == 0) {
                $rating = 'No Ratings';
            } elseif ($ratingIndex < 3) {
                $rating = '<button type="button" class="btn btn-circle btn-danger" >';
            } elseif ($ratingIndex < 7) {
                $rating = '<button type="button" class="btn btn-circle btn-warning" >';
            } elseif ($ratingIndex < 10) {
                $rating = '<button type="button" class="btn btn-circle btn-success" >';
            }

            $row[$contact->id][] = $rating;
            $row[$contact->id][] = $tradeString;
            $projects = $this->users->get_subcontractor_associated_projects($contact->id);
            if (!empty($projects)) {
                $row[$contact->id][] = implode('<br>', $projects);
            } else {
                $row[$contact->id][] = '';
            }
        }

        if ($type == 'suppliers') {
            $projects = $this->users->get_supplier_associated_projects($contact->id);
            if (!empty($projects)) {
                $row[$contact->id][] = implode('<br>', $projects);
            } else {
                $row[$contact->id][] = '';
            }
        }

        // if ($type == 'clients') {
        //     $actions = true;
        //     $table['actions']['view'] = 'view_contact';
        // }

        if ($this->common->check_permission('contacts', 'write') != false) {
            $actions .= '<a title="Edit" href="' . base_url(). 'users/edit_contact/'.$contact->id.'">
                <button class="btn btn-xs btn-default" type="button">
                    <i class="fa fa-edit"></i>
                </button>
            </a>';
        }

        if ($this->common->check_permission('contacts', 'write') != false) {
            $actions .= '<button title="Delete" class="btn btn-xs btn-default" data-href="' . base_url(). 'users/delete/'.$contact->id.'" data-toggle="modal" data-target="#confirm-delete">
                <i class="fa fa-times"></i>
            </button>';
        }

        $row[$contact->id][] = $actions;

        $table['rows'][] = $row;
        unset($row);
    }
}
$table['headers']['Actions'] = [];

echo $this->load->view("elements/bootstrap_table.php", $table, true);

echo $this->load->view("admin/includes/footer", $this->data, true);
?>
