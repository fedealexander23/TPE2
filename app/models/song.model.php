<?php

class SongModel{

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=tpe1;charset=utf8', 'root', '');
    }

    public function getAllSong() {
        // 1. abro conexión a la DB
        // ya esta abierta por el constructor de la clase

        // 2. ejecuto la sentencia (2 subpasos)
        $query = $this->db->prepare("SELECT * FROM songs");
        $query->execute();

        // 3. obtengo los resultados
        $songs = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
        
        return $songs;
    }
    
    public function getSongID($id){
        // 1. abro conexión a la DB
        // ya esta abierta por el constructor de la clase

        // 2. ejecuto la sentencia (2 subpasos)
        $query = $this->db->prepare("SELECT a.*, b.nationality, b.img FROM songs a INNER JOIN singers b ON a.singer = b.singer where id = ? ");
        $query->execute([$id]);
        $songs = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
        
        return $songs;
    }

    public function insertSong($title, $genere, $album, $singer){
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
        //$query = $this->db->prepare("SELECT * FROM songs WHERE singer = ?");
        $query = $this->db->prepare("SELECT * FROM songs WHERE singer LIKE ?");
        $query->execute(["%$singer%"]);
        $songs = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
        
        return $songs;
    }

    public function deleteSongById($id){
        $query = $this->db->prepare('DELETE FROM songs WHERE id = ?');
        $query->execute([$id]);
    }


    public function  editSongById($title, $genere, $album, $singer, $id){
        $query = $this->db->prepare("UPDATE songs SET title = ? , genere = ?, album = ?, singer = ? WHERE id = ?");
        $query->execute([$title, $genere, $album, $singer, $id]);

    }
}