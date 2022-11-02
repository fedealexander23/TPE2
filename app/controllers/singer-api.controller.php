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

    private function getData() {
        return json_decode($this->data);
    }

    public function getSingers($params = null) {
        
        $singers = $this->model->getAll();
        if ($singers){
            $this->view->response($singers);
        }else{ 
            $this->view->response("La coleccion no existe", 404);
        }
    }

    public function getSinger($params = null) {
        // obtengo el id del arreglo de params
        $id = $params[':ID'];
        $singer = $this->model->get($id);

        if ($singer){
            $this->view->response($singer);
        }else {
            $this->view->response("El artista con el id = $id no existe", 404);
        }
    }

    public function deleteSinger($params = null) {
        $id = $params[':ID'];

        $singer = $this->model->get($id);
        if ($singer) {
            $this->model->delete($id);
            $this->view->response($singer);
        } else {
            $this->view->response("El artista con el id = $id no existe", 404);
        }
    }

    public function insertSinger($params = null) {
        $singer = $this->getData();

        if (empty($singer->singer) || empty($singer->nationality)) {
            $this->view->response("Complete los datos", 400);
        } else {
            if($singer->img){
                $id = $this->model->insert($singer->singer, $singer->nationality, $singer->img);
                $newSinger = $this->model->get($id);
                $this->view->response($newSinger, 201);
            }else{
                $id = $this->model->insert($singer->singer, $singer->nationality);
                $newSinger = $this->model->get($id);
                $this->view->response($singer->singer, 201);
            }
        }
    }

    public function editSinger($params = null) {
        $id = $params[':ID'];
        $singer = $this->getData();

        if (empty($singer->singer) || empty($singer->nationality)) {
            $this->view->response("Complete los datos", 400);
        } else {
            if($singer->img){
                $this->model->edit($singer->singer, $singer->nationality, $id, $singer->img);
                $newSinger = $this->model->get($id);
                $this->view->response($singer, 201);
            }else{
                $id = $this->model->edit($singer->singer, $singer->nationality, $id);
                $newSinger = $this->model->get($id);
                $this->view->response($singer, 201);
            }
        }
    }
}