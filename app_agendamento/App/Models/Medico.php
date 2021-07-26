<?php
    namespace App\Models;

    use MF\Model\Model;

    class Medico extends Model{

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

        public function read(){
            $query = 'SELECT f.id, f.email, f.nome, f.telefone, f.turnos, s.setor FROM funcionarios AS f JOIN setores AS s ON f.id_setor = s.id WHERE situacao = 1 AND s.id = 2';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }
?>