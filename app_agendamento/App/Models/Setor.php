<?php
    namespace App\Models;

    use MF\Model\Model;

    class Setor extends Model{

        private $setor;

        public function create(){
            $query = 'INSERT INTO setores (setor) value (:setor)';
            $stmt = $this->db->prepare($query);
            $stmt = $stmt->bindValue(':setor', $this->__get('setor'));
            $stmt->execute();
        }

        public function read(){
            $query = 'SELECT * from setores';
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