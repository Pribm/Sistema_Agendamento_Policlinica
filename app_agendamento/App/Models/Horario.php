<?php
    namespace App\Models;

    use MF\Model\Model;

    class Horario extends Model{

        private $horario;

        public function create(){
            $query = 'INSERT INTO horarios (horario) VALUE (:horario)';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':horario', $this->__get('horario'));
            $stmt->execute();
        }

        public function read(){
            $query = "SELECT id, TIME_FORMAT(horario, '%H:%i') AS horario FROM horarios";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function update($id){

        }

        public function delete($id){

        }

        public function __get($attribute){
            return $this->$attribute;
        }
    
        public function __set($attribute, $value){
            $this->$attribute = $value;
        }
    }

?>