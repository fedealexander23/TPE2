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
        
        $songs = $this->model->getAll();
        if ($songs){
            $this->view->response($songs);
        }else{ 
            $this->view->response("La coleccion no existe", 404);
        }
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
            $this->view->response("La cancion se inserto con exito con el id = $id", 201);
        }
    }
}