<?php
namespace App\Models;

use MF\Model\Model;

class Usuario extends Model{

    private $id;
    private $nome;
    private $email;
    private $senha;
    private $setor;

    public function __get($attribute){
        return $this->$attribute;
    }

    public function __set($attribute, $value){
        $this->$attribute = $value;
    }

    public function autenticarUsuario(){
        $query = "SELECT F.id, F.nome, S.setor, F.telefone, F.email FROM funcionarios AS F LEFT JOIN setores AS S ON F.id_setor = S.id Where F.email = :email AND F.senha = :senha";
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
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':id_setor', $this->__get('id_setor'));
        $stmt->bindValue(':telefone', $this->__get('telefone'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha', md5($this->__get('senha')));
        $stmt->execute();
    }

    public function listaFuncionarios(){
        $query = 'SELECT F.id, F.nome, S.setor, F.telefone, F.email FROM funcionarios AS F LEFT JOIN setores AS S ON F.id_setor = S.id WHERE F.situacao = 1';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function listaSetores(){
        $query = "SELECT id, setor FROM setores";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function listaMedicos(){
        $query = "SELECT funcionarios.nome, funcionarios.id  FROM funcionarios WHERE id_setor = 2 AND funcionarios.situacao = 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function listaMedicosAtivosInativos(){
        $query = "SELECT funcionarios.nome, funcionarios.id  FROM funcionarios WHERE id_setor = 2";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function selecionaMedicos($id){
        $query = "SELECT funcionarios.nome FROM funcionarios WHERE id_setor = 2 AND id = :id";
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

    public function deletar($id){
        $query = "UPDATE funcionarios SET situacao = 0 WHERE funcionarios.id = :id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

}
?>