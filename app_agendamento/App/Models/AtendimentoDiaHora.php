<?php
    namespace App\Models;
    use MF\Model\Model;
use PDO;

class AtendimentoDiaHora extends Model{

        private $id_funcionario;
        private $id_horario;
        private $id_dia;
        private $atendimentos;

        public function create(){
            $query = 'INSERT INTO horario_atendimentos (id_horario, id_dia, atendimentos, id_funcionario) VALUES (:id_horario, :id_dia, :atendimentos, :id_funcionario)';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_horario', $this->__get('id_horario'));
            $stmt->bindValue(':id_dia', $this->__get('id_dia'));
            $stmt->bindValue(':atendimentos', $this->__get('atendimentos'));
            $stmt->bindValue(':id_funcionario', $this->__get('id_funcionario'));
            $stmt->execute();
        }

        public function read(){
            $query = 'SELECT funcionarios.nome, funcionarios.telefone, funcionarios.email,
                      horarios.horario,dias_de_atendimento.dia, horario_atendimentos.atendimentos,
                      horario_atendimentos.extras
                      FROM funcionarios
                      JOIN horario_atendimentos
                      ON (horario_atendimentos.id_funcionario = funcionarios.id)
                      JOIN horarios ON (horario_atendimentos.id_horario = horarios.id)
                      JOIN dias_de_atendimento ON (horario_atendimentos.id_dia = dias_de_atendimento.id)';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $funcionarios;
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