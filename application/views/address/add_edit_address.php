<?php
$form = array(
    'input_group' => array(
        'address_1' => [
        	'label' => "Address Line 1",
            'required'  => true
        ],
        'address_2' => [
        	'label' => "Address Line 2",
            'required'  => true
        ],
        'town' => [
            'required'  => true
        ],
        'county' => [
            'required'  => true
        ],
        'country' => [
            'required'  => true
        ],
        'postcode' => [
            'required'  => true
        ],     
        'from_date' => [
           'label' => 'From',
           'class' => 'date-picker',
        ],
        'to_date' => [
           'label' => 'Till',
           'class' => 'date-picker',
        ],

        

    )
);

$hidden = ["user_id" => $user_id];

$form['title'] = uCfirst($this->router->fetch_method()).' Address for '. $this->common->get_field(
            'crm_users',
            'forename',
            [
                'id'    => $user_id
            ]
        );
echo form_open(
    '',
    [
        'method'        => "post",
        'name'          => "useraddfrm",
        'id'            => "useraddfrm"
    ],
    $hidden
);
$form['skipProjectDetails'] = true;
$this->load->view('form_template', $form);
?>
<div id='content'>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12" style="text-align: right;">
                    <input name="" tabindex="14" type="submit" value="Submit"  class="btn btn-primary"/>
                    <input name="" type="button" value="Cancel" class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/users/index/<?php echo $user_id;?>'" />
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->load->view("admin/includes/footer", null, true);?>
