<?php
    namespace App\Models;

    use MF\Model\Model;

    class Setor extends Model{

        private $setor;
        private $id;

        public function create(){
            $query = 'INSERT INTO setores (setor) VALUE (:setor)';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':setor', $this->__get('setor'));
            $stmt->execute();
        }

        public function read(){
            $query = 'SELECT * from setores WHERE situacao = 1';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function update($id){

        }

        public function delete(){
            $query = 'UPDATE setores SET situacao = 1 WHERE setores.id = :id';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
        }

        public function __get($attribute){
            return $this->$attribute;
        }

        public function __set($attribute, $value){
            $this->$attribute = $value;
        }
    }
?>