<?php

class SingerModel{

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=tpe1;charset=utf8', 'root', '');
    }

    public function getAllSinger() {
        // 1. abro conexión a la DB
        // ya esta abierta por el constructor de la clase

        // 2. ejecuto la sentencia (2 subpasos)
        $query = $this->db->prepare("SELECT * FROM singers");
        $query->execute();

        // 3. obtengo los resultados
        $singer = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
        
        return $singer;
    }

   public function getSingerID($id){
        // 1. abro conexión a la DB
        // ya esta abierta por el constructor de la clase

        // 2. ejecuto la sentencia (2 subpasos)
        $query = $this->db->prepare("SELECT * FROM singers where singer = ?");
        $query->execute([$id]);
        $singer = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
        
        return $singer;
    }

    public function insertSinger($singer, $nationality, $img = null){
        // 1. abro conexión a la DB
        // ya esta abierta por el constructor de la clase

        // 2. ejecuto la sentencia (2 subpasos)
        $pathImg = null;
        if ($img){
            $pathImg = $this->uploadImage($img);
            $query = $this->db->prepare("INSERT INTO singers (singer, nationality, img) VALUES (?, ?, ?)");
            $query->execute([$singer, $nationality, $pathImg]);
        }else{
            $query = $this->db->prepare("INSERT INTO singers (singer, nationality) VALUES (?, ?)");
            $query->execute([$singer, $nationality]);
        }

        return $this->db->lastInsertId();
    }

    public function deleteSingerById($singer){
        // 1. abro conexión a la DB
        // ya esta abierta por el constructor de la clase
        
        // 2. ejecuto la sentencia (2 subpasos)
        $query = $this->db->prepare('DELETE FROM singers WHERE singer = ?');
        $query->execute([$singer]);
    }
    
    function editSingerById($singer, $nationality, $id, $img = null){
    if ($img){
        $pathImg = $this->uploadImage($img);
        $query = $this->db->prepare("UPDATE singers SET singer = ?, nationality = ?, img = ? WHERE singer = ?");
        $query->execute([$singer, $nationality, $pathImg, $id]);
    }else{
        $query = $this->db->prepare("UPDATE singers SET singer = ?, nationality = ? WHERE singer = ?");
        $query->execute([$singer, $nationality, $id]);
    }
    }

    // Revisa que la imagen este una vez y no se repita 
    // Y copia la img del lugar temporal a donde la queremos guardar
    
    private function uploadImage($img){
        $target = 'img/singers/' . uniqid() . '.jpg';
        move_uploaded_file($img, $target);
        return $target;
    }
}

