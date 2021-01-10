<?php
namespace App\Models;
use MF\Model\Model;

class Relatorio_Atendidos extends Model{

    private $id;
    private $paciente;
    private $medico_id;
    private $prontuario;
    private $horario;
    private $dia;
    private $atendimento_realizado;


    public function __get($attribute){
        return $this->$attribute;
    }

    public function __set($attribute, $value){
        $this->$attribute = $value;
    }

    public function contagemAtendimentosPorDia(){
        $query = 'SELECT COUNT(id) AS "atendidos" FROM atendimentos_realizados  WHERE (SELECT CAST(hora_dia AS DATE)) = :dia';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':dia', $this->__get('dia'));
        $stmt->execute();

        while($results = $stmt->fetch(\PDO::FETCH_ASSOC)){
            $result[] = $results;
        }

        return $result;
    }

    public function contagemAgendamentosPorMedico(){
        $query = 'SELECT COUNT(atendimento_realizado = 1) AS "atendidos" FROM agendamentos WHERE dia = :dia AND medico_id = :medico_id';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':dia', $this->__get('dia'));
        $stmt->bindValue(':medico_id', $this->__get('medico_id'));
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
 
    }
}

?>