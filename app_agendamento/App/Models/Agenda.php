<?php
namespace App\Models;


use Faker\Factory;
use MF\Model\Model;

    class Agenda extends Model{

        private $id;
        private $paciente;
        private $medico_id;
        private $prontuario;
        private $horario_id;
        private $dia;
        private $agendado_por;
        private $atendimento_realizado;
        private $limit;
        private $offset;

        public function create(){
            
        }

        public function read(){

            $limit = $this->__get('limit');
            $offset = $this->__get('offset');

            $query = "SELECT COUNT(a.id) AS total FROM agendamentos AS a
            WHERE (a.paciente LIKE CONCAT('%', :paciente, '%') or :paciente = '')
            AND (a.prontuario LIKE CONCAT('%', :prontuario, '%') or :prontuario = '')
            AND (a.medico_id = :medico or :medico = '')
            AND (a.horario = :horario_id or :horario_id = '')
            AND (a.dia = :dia or :dia = '')";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':medico', $this->__get('medico_id'));
            $stmt->bindValue(':dia', $this->__get('dia'));
            $stmt->bindValue(':prontuario', $this->__get('prontuario'));
            $stmt->bindValue(':horario_id', $this->__get('horario_id'));
            $stmt->bindValue(':paciente', $this->__get('paciente'));
            $stmt->execute();
            $count = $stmt->fetchColumn();

            $query = "SELECT a.*, DATE_FORMAT(a.dia, '%d/%m/%Y') AS dia, 
            m.nome AS medico,
            f.nome AS agendado_por,
            TIME_FORMAT(h.horario, '%H:%i') AS horario
            FROM agendamentos AS a
            JOIN funcionarios as m
            ON
            (a.medico_id = m.id)
            JOIN funcionarios as f
            ON
            (a.agendado_por = f.id)
            JOIN horarios as h
            ON
            a.horario = h.id
            
            WHERE (a.paciente LIKE CONCAT('%', :paciente, '%') or :paciente = '')
            AND (a.prontuario LIKE CONCAT('%', :prontuario, '%') or :prontuario = '')
            AND (a.medico_id = :medico or :medico = '')
            AND (a.agendado_por = :agendado_por or :agendado_por = '')
            AND (a.horario = :horario_id or :horario_id = '')
            AND (a.dia = :dia or :dia = '') ORDER BY a.dia DESC LIMIT {$limit} offset {$offset}";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':medico', $this->__get('medico_id'));
            $stmt->bindValue(':agendado_por', $this->__get('agendado_por'));
            $stmt->bindValue(':dia', $this->__get('dia'));
            $stmt->bindValue(':prontuario', $this->__get('prontuario'));
            $stmt->bindValue(':horario_id', $this->__get('horario_id'));
            $stmt->bindValue(':paciente', $this->__get('paciente'));
            $stmt->execute();

            return ['agendamentos' => $stmt->fetchAll(\PDO::FETCH_ASSOC), 'count' => $count];
        }


        public function update(){
            
        }

        public function atender(){
            $query = 'UPDATE agendamentos SET atendimento_realizado = 1 WHERE agendamentos.id = :id';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function delete(){
            $query = 'DELETE FROM agendamentos WHERE (id = :id)';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
        }

        public function count(){
            $query = 'SELECT COUNT(agendamentos.paciente) FROM agendamentos WHERE agendamentos.dia = :dia AND agendamentos.medico_id = :medico_id';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':dia', $this->__get('dia'));
            $stmt->bindValue(':medico_id', $this->__get('medico_id'));
            $stmt->execute();
            return $stmt->fetch();
        }
            
        public function createTest($numero_de_registros){
            $faker = Factory::create('pt_BR');
            for ($i=0; $i < $numero_de_registros; $i++) { 
                $query = 'INSERT INTO agendamentos (paciente, medico_id, prontuario, sus, horario, dia, agendado_por, extra, atendimento_realizado) VALUES (:paciente, :medico_id, :prontuario, :sus, :horario, :dia, :agendado_por, :extra, :atendimento_realizado)';
    
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(':paciente',  $faker->name());
                $stmt->bindValue(':medico_id', $faker->numberBetween(186, 188));
                $stmt->bindValue(':prontuario', strval($faker->randomNumber(7)));
                $stmt->bindValue(':sus', strval($faker->randomNumber(5)));
                $stmt->bindValue(':horario', $faker->numberBetween(1, 4));
                $stmt->bindValue(':dia', $faker->date($format = 'Y-m-d'));
                $stmt->bindValue(':agendado_por',  1);
                $stmt->bindValue(':extra',  0);
                $stmt->bindValue(':atendimento_realizado',  0);
                $stmt->execute();
            }
        }

        public function __get($attribute){
            return $this->$attribute;
        }
    
        public function __set($attribute, $value){
            $this->$attribute = $value;
        }
    }

?>