<?php

class Index extends Controller
{
    public $data = array(
        'company' => 'Vendor',
        'maker_name' => 'Maker' ,
        'type_name' => 'Type',
        'model_name' => 'Model',
        'serial' => 'Serial',
        'asset' => 'Asset',
        'location_name' => 'Location',
        'group_name' => 'Group',
        'specification' => 'Specification',
        'documents' => 'Documents',
        'po_number' => 'PO #'
    );
    
    public $calibration = array(
        'company' => 'Vendor',
        'maker_name' => 'Maker' ,
        'type_name' => 'Type',
        'model_name' => 'Model',
        'serial' => 'Serial',
        'asset' => 'Asset',
        'location_name' => 'Location',
        'group_name' => 'Group',
        'specification' => 'Specification',
        'calibration_date' => 'Date'
    );
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
      //  $this->view->items = $this->model->get_calibration();
        $this->view->data = $this->calibration;
        $this->view->render('index/index');
    }
    
    public function asset()
    {
        $this->view->data = $this->data;
        $this->view->asset = $this->model->get_asset();
        $this->view->render('index/asset');
    }
}
