<?php
    namespace App\Models;

    use MF\Model\Model;

    class Consulta extends Model{

        private $id;
        private $paciente;
        private $medico_id;
        private $prontuario;
        private $sus;
        private $horario;
        private $dia;
        private $agendado_por;
        private $atendimento_realizado;

        public function __get($atributo){
            return $this->$atributo;
        }

        public function __set($atributo, $valor){
            $this->$atributo = $valor;
        }

        public function agendaPaciente($extra_sn){
            $query = 'INSERT INTO agendamentos (paciente, medico_id, prontuario, sus, horario, dia, agendado_por, extra) VALUES (:paciente, :medico_id, :prontuario, :sus, :horario, :dia, :agendado_por, :extra)';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':paciente', $this->__get('paciente'));
            $stmt->bindValue(':medico_id', $this->__get('medico_id'));
            $stmt->bindValue(':prontuario', $this->__get('prontuario'));
            $stmt->bindValue(':sus', $this->__get('sus'));
            $stmt->bindValue(':horario', $this->__get('horario'));
            $stmt->bindValue(':dia', $this->__get('dia'));
            $stmt->bindValue(':agendado_por', $this->__get('agendado_por'));
            $stmt->bindValue(':extra', $extra_sn);
            $stmt->execute();
        }

        public function contaAtendidos(){
            $query = 'SELECT COUNT(dia) AS "dia" FROM agendamentos WHERE dia = :dia AND medico_id = :medico_id';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':dia', $this->__get('dia'));
            $stmt->bindValue(':medico_id', $this->__get('medico_id'));
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function atender($id){
            $query = 'UPDATE agendamentos SET atendimento_realizado = "1" WHERE agendamentos.id = :id';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            $query = 'INSERT INTO atendimentos_realizados (id_agendamento) VALUE (:id_agendamento)';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_agendamento', $id);
            $stmt->execute();
        }

        public function filtrar(){
            $query = "SELECT a.extra, a.paciente, a.id, m.nome AS 'medico', a.prontuario, f.nome AS 'solicitante',a.atendimento_realizado, TIME_FORMAT(h.horario, '%H:%i') AS 'horario', DATE_FORMAT(a.dia, '%d/%m/%y') AS 'dia' FROM agendamentos AS a JOIN funcionarios AS m ON a.medico_id = m.id JOIN funcionarios AS f ON a.agendado_por = f.id JOIN horarios AS h ON a.horario = h.id WHERE (m.id = :medico OR :medico = '') AND (a.dia = :dia OR :dia = '') AND (a.prontuario = :prontuario OR :prontuario = '') AND (a.horario = :horario OR :horario = '') AND (a.paciente LIKE CONCAT('%', :paciente, '%') OR :paciente = '')";
            $stmt = $this->db->prepare($query);

            
            $stmt->bindValue(':medico', $this->__get('medico_id'));
            $stmt->bindValue(':dia', $this->__get('dia'));
            $stmt->bindValue(':prontuario', $this->__get('prontuario'));
            $stmt->bindValue(':horario', $this->__get('horario'));
            $stmt->bindValue(':paciente', $this->__get('paciente'));
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

    }
?>