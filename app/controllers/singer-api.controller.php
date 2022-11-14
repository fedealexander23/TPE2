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
        $orderBy = $_GET['orderBy'] ?? null;
        $orderMode = $_GET['orderMode'] ?? null;
        
        $linkTo = $_GET['linkTo'] ?? null;
        $equalTo = $_GET['equalTo'] ?? null;
        
        $limit = $_GET['limit'] ?? null;
        $offset = $_GET['offset'] ?? null;

        if( $orderBy == null && $orderMode == null && $linkTo == null && $equalTo == null && $limit == null && $offset == null){
            print_r('comun'); 
            
            $singer = $this->model->getAll($orderBy, $orderMode);
            if ($singer)
                $this->view->response($singer);
            else 
                $this->view->response("La coleccion no existe", 404);
        }

        elseif(!isset($orderBy) && !isset($orderMode) && !isset($limit) && !isset($offset)){
            print_r("filtrado");

            if($linkTo == null || $equalTo == null){
                $this->view->response("no completaste todos los datos", 404);
            }
            else{
                $singer = $this->model->getfilter($linkTo, $equalTo);
                if ($singer)
                    $this->view->response($singer);
                else 
                    $this->view->response("La coleccion no existe", 404);
            }
        }

        elseif(!isset($orderBy) && !isset($orderMode) && !isset($linkTo) && !isset($equalTo)){
            print_r('paginado');

            if(is_numeric($limit) && is_numeric($offset)){
                $singer = $this->model->getPagination($limit, $offset);
                if ($singer)
                    $this->view->response($singer);
                else 
                    $this->view->response("La coleccion no existe", 404);
            }else{
                $this->view->response("los datos ingresados no son numericos", 404);
            }
        }

        else{
            print_r('ordenado');

            if(($orderBy == 'singer') || ($orderBy == 'nationality') || ($orderBy == 'img') && ($orderMode == 'ASC' || $orderMode == 'DESC')){
                $singers = $this->model->getOrder($orderBy, $orderMode);
                if ($singers)
                    $this->view->response($singers);
                else 
                    $this->view->response("La coleccion no existe", 404);
            }else{
                $this->view->response("La forma de ordenamiento no es valida", 404);
            }
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