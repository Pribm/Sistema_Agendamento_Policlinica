<?php
    namespace App\Models;

    use MF\Model\Model;

    class Funcionario extends Model{

        private $email;
        private $senha;
        private $nome;
        private $telefone;
        private $id_setor;
        private $turnos;

        public function __get($attribute){
            return $this->$attribute;
        }

        public function __set($attribute, $value){
            $this->$attribute = $value;
        }

        public function create(){
            $query = 'INSERT INTO funcionarios (email, senha, nome, telefone, id_setor, turnos) VALUES (:email, :senha, :nome, :telefone, :id_setor, :turnos)';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':senha', $this->__get('senha'));
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':telefone', $this->__get('telefone'));
            $stmt->bindValue(':id_setor', $this->__get('id_setor'));
            $stmt->bindValue(':turnos', $this->__get('turnos'));
            $stmt->execute();
        }

        public function read(){
            $query = 'SELECT f.email, f.nome, f.telefone, f.turnos, s.setor FROM funcionarios AS f JOIN setores AS s ON f.id_setor = s.id WHERE situacao = 1';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function update(){

        }

        public function delete(){

        }
    }
?>