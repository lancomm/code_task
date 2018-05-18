<?php
class Params extends MY_Controller
{
    var $data;
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper(array('form','url','html'));

        $this->load->model('common_model', 'common');
    }

    public function getParam($id = null) {
        if ($id != null) {
            $paramFind = $this->common->findById('crm_params', $id);
            echo json_encode($paramFind);
        }
    }
}
