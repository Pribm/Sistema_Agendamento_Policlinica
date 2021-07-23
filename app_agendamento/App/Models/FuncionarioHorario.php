<?php
    namespace App\Models;
    use MF\Model\Model;

    class FuncionarioHorario extends Model{

        private $id_funcionario;
        private $id_horario;

        public function create(){
            $query = 'INSERT INTO funcionario_horario (id_funcionario, id_horario) VALUES (:id_funcionario, :id_horario)';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_funcionario', $this->__get('id_funcionario'));
            $stmt->bindValue(':id_horario', $this->__get('id_horario'));
            $stmt->execute();
        }

        public function read(){
            $query = 'SELECT nome, telefone, email, senha FROM funcionarios WHERE funcionario_horario.id_funcionario = funcionarios.id JOIN SELECT horarios.horario WHERE funcionario_horario.id_horario = horarios.id';
        }

        public function update(){

        }

        public function delete(){

        }

        public function __get($attribute){
            return $this->$attribute;
        }

        public function __set($attribute, $value){
            $this->$attribute = $value;
        }
    }

?>