<?php
$form = array(
    'input_group' => array(
        'email' => [
            'required'  => true
        ],
        'password' => array(
            'type'              => 'password',
            'required'  => true
        ),
        'retype_password' => array(
            'type'              => 'password',
            'required'  => true
        ),
       
    'title_id' => [
            'type'          => 'select',
            'required'      => true,
            'options'       => $this->common->get_select_list(
                'crm_params',
                [
                    'value_field'   => 'id',
                    'text_field'    => 'name'
                ],
                [
                    'description'   => 'honorifics'
                ]
            )
        ],
        'forename' => [
            'required'  => true
        ],
        'surname' => [
            'required'  => true
        ],
        'gender_id' => [
            'type'          => 'select',
            'required'      => true,
            'options'       => $this->common->get_select_list(
                'crm_params',
                [
                    'value_field'   => 'id',
                    'text_field'    => 'name'
                ],
                [
                    'description'   => 'gender'
                ]
            )
        ],
        'dob' => array(
           'class' => 'date-picker',
        ),

        

    )
);

$hidden = [];

$form['title'] = uCfirst($this->router->fetch_method()).' User';
echo form_open(
    '',
    [
        'method'        => "post",
        'name'          => "useraddfrm",
        'id'            => "useraddfrm"
    ],
    $hidden
);
$redirect_url =  base_url().'index.php/Admin';
if ($this->router->fetch_method() == "edit"){
$redirect_url =  base_url().'index.php/users/index/'.$this->data['id'];	
}

$form['skipProjectDetails'] = true;
$this->load->view('form_template', $form);
?>
<div id='content'>
    <div class="row">
        <div class="col-lg-12">
            <u><h3>Addresses</h3></u>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12" style="text-align: right;">
                    <input name="" tabindex="14" type="submit" value="Submit"  class="btn btn-primary"/>
                    <input name="" type="button" value="Cancel" class="btn btn-primary" onclick="window.location.href='<?php echo $redirect_url;?>'">
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->load->view("admin/includes/footer", null, true);?>
