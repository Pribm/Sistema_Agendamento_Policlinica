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
            $query = 'SELECT f.id, f.email, f.nome, f.telefone, f.turnos, s.setor FROM funcionarios AS f JOIN setores AS s ON f.id_setor = s.id WHERE situacao = 1 ORDER BY f.id DESC';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getFuncionario(){
            $query = 'SELECT f.id,f.nome, f.id_setor, f.telefone, f.email, f.turnos, s.setor FROM funcionarios AS f JOIN setores AS s ON f.id_setor = s.id WHERE situacao = 1 AND f.id = :id';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function update(){
            $query = 'UPDATE funcionarios SET nome = :nome, email = :email, telefone = :telefone, id_setor = :id_setor, turnos = :turnos WHERE funcionarios.id = :id';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':telefone', $this->__get('telefone'));
            $stmt->bindValue(':id_setor', $this->__get('id_setor'));
            $stmt->bindValue(':turnos', $this->__get('turnos'));
            $stmt->execute();
        }

        public function delete(){

        }
    }
?>