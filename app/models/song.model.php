<?php

class SongModel{

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=tpe1;charset=utf8', 'root', '');
    }

    public function getAll(){
        $query = $this->db->prepare("SELECT * FROM songs");
        $query->execute();
        // 3. obtengo los resultados
        $songs = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
        
        return $songs;
    }    

    public function getPagination($limit, $offset){
        $query = $this->db->prepare("SELECT * FROM songs LIMIT $offset, $limit");
        $query->execute();

        // 3. obtengo los resultados
        $songs = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
        return $songs; 
    }

    public function getfilter($linkTo, $equalTo){

        // preguntar si es inyeccion sql
        $query = $this->db->prepare("SELECT * FROM songs WHERE $linkTo LIKE ?");
        $query->execute(["%$equalTo%"]);

        $songs = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
        
        return $songs;
    }

    public function getOrder($orderBy, $orderMode){
        $query = $this->db->prepare("SELECT * FROM songs ORDER BY $orderBy $orderMode");
        $query->execute();
        // 3. obtengo los resultados
        $songs = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
        
        return $songs;
    }

    public function get($id){
        // 1. abro conexión a la DB
        // ya esta abierta por el constructor de la clase

        // 2. ejecuto la sentencia (2 subpasos)
        $query = $this->db->prepare("SELECT a.*, b.nationality, b.img FROM songs a INNER JOIN singers b ON a.singer = b.singer where id = ? ");
        $query->execute([$id]);
        $songs = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
        
        return $songs;
    }

    public function insert($title, $genere, $album, $singer){
        // 1. abro conexión a la DB
        // ya esta abierta por el constructor de la clase

        // 2. ejecuto la sentencia (2 subpasos)
        $query = $this->db->prepare("INSERT INTO songs (title, genere, album, singer) VALUES (?, ?, ?, ?)");
        $query->execute([$title, $genere, $album, $singer]);

        return $this->db->lastInsertId();
    }

    public function filterSinger($singer){
        // 1. abro conexión a la DB
        // ya esta abierta por el constructor de la clase

        // 2. ejecuto la sentencia (2 subpasos)
        $query = $this->db->prepare("SELECT * FROM songs WHERE singer LIKE ?");
        $query->execute(["%$singer%"]);
        $songs = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
        
        return $songs;
    }

    public function delete($id){
        $query = $this->db->prepare('DELETE FROM songs WHERE id = ?');
        $query->execute([$id]);
    }


    public function  edit($title, $genere, $album, $singer, $id){
        $query = $this->db->prepare("UPDATE songs SET title = ? , genere = ?, album = ?, singer = ? WHERE id = ?");
        $query->execute([$title, $genere, $album, $singer, $id]);

    }
}