<?php

namespace App\Models;
use MF\Model\Model;



class Usuario extends Model{


    private $id;
    private $nome;
    private $telefone;
    private $email;
    private $senha;
    private $setor;
    private $id_horario;



    public function __get($attribute){
        return $this->$attribute;
    }



    public function __set($attribute, $value){
        $this->$attribute = $value;
    }



    public function autenticarUsuario(){

        $query = "SELECT F.id, F.nome, S.setor, F.telefone, F.email FROM funcionarios AS F LEFT JOIN setores AS S ON F.id_setor = S.id Where F.email = :email AND F.senha = :senha AND F.situacao = 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->execute();
        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        if($usuario['id'] != '' && $usuario['nome'] != ''){
            $this->__set('id', $usuario['id']);
            $this->__set('nome', $usuario['nome']);
            $this->__set('setor', $usuario['setor']);

        }

        return $this; 

    }



    public function cadastraFuncionario(){

        $query = "INSERT INTO funcionarios (nome, id_setor, telefone, email, senha) VALUES (:nome, :id_setor, :telefone, :email, :senha)";
        //INSERT INTO horario_atendimentos(id_horario, atendimentos, id_funcionario) VALUES (:id_horario,12, LAST_INSERT_ID())"; //criar uma foreign key de horário para linkar com os horários cadastrados.
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':id_setor', $this->__get('id_setor'));
        //$stmt->bindValue(':id_horario', $this->__get('id_horario'));
        $stmt->bindValue(':telefone', $this->__get('telefone'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha', md5($this->__get('senha')));
        $stmt->execute();
    }

    public function getLastId(){
        $query = 'SELECT LAST_INSERT_ID() as funcionario_id from funcionarios';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function listaFuncionarios(){

        $query = 'SELECT F.id, F.nome, F.telefone, F.email, ha.atendimentos, TIME_FORMAT(h.horario, "%H:%i") AS horario , S.setor FROM funcionarios AS F LEFT JOIN setores AS S ON F.id_setor = S.id LEFT JOIN horario_atendimentos AS ha ON ha.id_funcionario = F.id LEFT JOIN horarios AS h ON ha.id_horario = h.id WHERE F.situacao = 1';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function listaHorarios(){
        $query = "SELECT id, TIME_FORMAT(horario, '%H:%i') AS horario FROM horarios";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }



    public function listaMedicos(){

        $query = 'SELECT F.nome, F.id, ha.atendimentos,ha.id_horario, TIME_FORMAT(h.horario, "%H:%i") AS horario FROM funcionarios AS F LEFT JOIN setores AS S ON F.id_setor = S.id LEFT JOIN horario_atendimentos AS ha ON ha.id_funcionario = F.id LEFT JOIN horarios AS h ON ha.id_horario = h.id WHERE id_setor = 2 AND F.situacao = 1';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }



    public function listaMedicosAtivosInativos(){

        $query = "SELECT funcionarios.nome, funcionarios.id  FROM funcionarios WHERE id_setor = 2 AND situacao = 1";

        $stmt = $this->db->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }



    public function selecionaMedicos($id){
        $query = "SELECT funcionarios.nome FROM funcionarios WHERE id_setor = 2 AND id = :id AND situacao = 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }



    public function listaAgendamentos(){
        $query = "SELECT a.paciente, a.id, m.nome AS 'medico', a.prontuario, f.nome AS 'solicitante',a.atendimento_realizado, a.horario, DATE_FORMAT(a.dia, '%d/%m/%y') AS 'dia' FROM agendamentos AS a JOIN funcionarios AS m ON a.medico_id = m.id JOIN funcionarios AS f ON a.agendado_por = f.id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }



    public function deletar($id, $table){

        
        if($table == 'funcionarios'){ // <-- seleciona as tabelas onde será alterada somente a situacao
            $query = "UPDATE $table SET situacao = 0 WHERE $table.id = :id;";
        }else{ // <-- seleciona as tabelas onde será deletado de fato
            $query = "DELETE FROM $table WHERE $table.id = :id";
        }
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    public function atualizar($id){
        /*$query = "UPDATE funcionarios SET nome = :nome, email = :email, telefone = :telefone, id_setor = :id_setor WHERE funcionarios.id = :id;";*/

        $query = "
        START  TRANSACTION;

        UPDATE funcionarios SET nome = :nome, email = :email, telefone = :telefone, id_setor = :id_setor WHERE funcionarios.id = :id;

        UPDATE horario_atendimentos SET id_horario = :id_horario WHERE horario_atendimentos.id_funcionario = :id;

        COMMIT;
        "; //estudar melhor transactions//
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':id_setor', $this->__get('id_setor'));
        $stmt->bindValue(':telefone', $this->__get('telefone'));
        $stmt->bindValue(':id_horario', $this->__get('id_horario'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();
    }



}

?>