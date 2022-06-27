<?php

class User extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function login()
    {
        if (!isset($_SESSION['logged_in'])) {
            $this->model->login($_POST);
        } else {
            header('LOCATION: '. URL);
        }
    }
    
    public function logout()
    {
        session_destroy();
        header('LOCATION: '. URL);
    }
    
    public function show_login_form()
    {
        $this->view->render('administrator/login', true);
    }
    
    public function user_login()
    {
        // $this->view->campaign = $this->model->get_campaigns();
        $this->view->render('administrator/login', true);
    }
    
    public function index()
    {
        $this->view->items = $this->model->get_objects();
        $this->view->render('user/index');
    }

    public function register()
    {
        $this->view->render('user/form/register', true);
    }

    public function save()
    {
        $this->model->insert_object($_POST);
    }

    public function edit_item($id)
    {
        $this->view->item = $this->model->get_object_detail($id);
        $this->view->render('user/form/edit_type', true);
    }

    public function update_object()
    {
        $this->model->update_object($_POST);
    }

    public function delete_item()
    {
        $ids = (is_array($_POST['ids'])) ? $_POST['ids'] : die();
        $this->model->delete_object($ids);
    }

    public function get()
    {
        echo json_encode($this->model->get_objects());
    }
}
