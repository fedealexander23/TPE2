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

    private function getData() {
        return json_decode($this->data);
    }

    public function getSongs($params = null) {
        $orderBy = $_GET['orderBy'] ?? null;
        $orderMode = $_GET['orderMode'] ?? null;

        $linkTo = $_GET['linkTo'] ?? null;
        $equalTo = $_GET['equalTo'] ?? null;

        $limit = $_GET['limit'] ?? null;
        $offset = $_GET['offset'] ?? null;

        if( $orderBy == null && $orderMode == null && $linkTo == null && $equalTo == null && $limit == null && $offset == null){
            print_r('comun'); 

            $song = $this->model->getAll();
            if ($song)
                $this->view->response($song);
            else 
                $this->view->response("La coleccion no existe", 404);
        }
        
        elseif($orderBy == null && $orderMode == null && $limit == null && $offset == null){
            print_r("filtrado");

            if($linkTo == null || $equalTo == null){
                $this->view->response("no completaste todos los datos", 404);
            }
            else{
                $song = $this->model->getfilter($linkTo, $equalTo);
                if ($song)
                    $this->view->response($song);
                else 
                    $this->view->response("La coleccion no existe", 404);
            }
        }

        elseif($orderBy == null && $orderMode == null && $linkTo == null && $equalTo == null){
            print_r('paginado');

            if(is_numeric($limit) && is_numeric($offset)){
                $song = $this->model->getPagination($limit, $offset);
                if ($song)
                    $this->view->response($song);
                else 
                    $this->view->response("La coleccion no existe", 404);
            }else{
                $this->view->response("los datos ingresados no son numericos", 404);
            }
        }

        elseif($linkTo == null && $equalTo == null && $limit == null && $offset == null){
            print_r('ordenado');

            if( ($orderBy == 'id') || ($orderBy == 'title') || ($orderBy == 'genere') || 
            ($orderBy == 'album') || ($orderBy == 'singer') && //preguntar xq tira error
            ($orderMode == 'ASC' || $orderMode == 'DESC') ){
                $song = $this->model->getOrder($orderBy, $orderMode);
                if ($song){
                    $this->view->response($song);
                }else{ 
                    $this->view->response("La coleccion no existe", 404);
                }
            }else{
                $this->view->response("La forma de ordenamiento no es valida", 404);
            }
        }

        //Preguntar como hacer esta funcion para que no haya repeticion de codigo
        /*
        function get(){
            $song = $this->model->getAll($orderBy, $orderMode, $linkTo, $equalTo);
            if ($song){
                $this->view->response($song);
            }else{ 
                $this->view->response("La coleccion no existe", 404);
            }
        }*/
    }

    public function getSong($params = null) {
        // obtengo el id del arreglo de params
        $id = $params[':ID'];
        $song = $this->model->get($id);

        if ($song){
            $this->view->response($song);
        }else {
            $this->view->response("La cancion con el id = $id no existe", 404);
        }
    }

    public function deleteSong($params = null) {
        $id = $params[':ID'];

        $song = $this->model->get($id);
        if ($song) {
            $this->model->delete($id);
            $this->view->response($song);
        } else {
            $this->view->response("La cancion con el id = $id no existe", 404);
        }
    }

    public function insertSong($params = null) {
        $song = $this->getData();

        if (empty($song->title) || empty($song->genere) || empty($song->album) || empty($song->singer)) {
            $this->view->response("Complete los datos", 400);
        } else {
            $id = $this->model->insert($song->title, $song->genere, $song->album, $song->singer);
            $song = $this->model->get($id);
            $this->view->response($song, 201);
        }
    }
    
    public function editSong($params = null) {
        $id = $params[':ID'];
        $song = $this->getData();

        if (empty($song->title) || empty($song->genere) || empty($song->album) || empty($song->singer) && empty($id)) {
            $this->view->response("Complete los datos", 400);
        } else {
            $this->model->edit($song->title, $song->genere, $song->album, $song->singer, $id);
            $song = $this->model->get($id);
            $this->view->response($song, 201);
        }
    }


}