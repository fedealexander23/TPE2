<?php   

require_once './app/models/song.model.php';
require_once './app/views/api.view.php';

class SongApiController{
    private $model;
    private $view;

    private $data;

    public function __construct() {
        $this->model = new SongModel();
        $this->view = new ApiView();
        
        // lee el body del request
        $this->data = file_get_contents("php://input");
    }

}