<?php

require_once './app/models/singer.model.php';
require_once './app/views/api.view.php';

class SingerApiController{
    private $model;
    private $view;

    private $data;

    public function __construct() {
        $this->model = new SingerModel();
        $this->view = new ApiView();
        
        // lee el body del request
        $this->data = file_get_contents("php://input");
    }

}