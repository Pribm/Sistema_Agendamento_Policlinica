<?php

namespace App\Models;
use MF\Model\Model;



class Prontuario extends Model{


    private $id;
    private $nome;
    private $nome_pai;
    private $nome_mae;
    private $bairro;
    private $complemento;
    private $endereco;
    private $numero;
    private $estado_civil;
    private $telefone;
    private $obs;
    private $profissao;
    private $prontuario;
    private $sexo;
    private $sus;



    public function __get($attribute){
        return $this->$attribute;
    }



    public function __set($attribute, $value){
        $this->$attribute = $value;
    }

    public function inserir(){
        $query = 'INSERT INTO prontuario (bairro, complemento, endereco, estadoCivil, fone, mae, naturalidade, nome, numero, obs, pai, profissao, prontuario, sexo, sus) VALUES (:bairro, :complemento, :endereco, :estadoCivil, :fone, :mae, :naturalidade, :nome, :numero, :obs, :pai, :profissao, :prontuario, :sexo, :sus)';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':bairro', $this->__get('bairro'));
        $stmt->bindValue(':complemento', $this->__get('complemento'));
        $stmt->bindValue(':endereco', $this->__get('endereco'));
        $stmt->bindValue(':estadoCivil', $this->__get('estadoCivil'));
        $stmt->bindValue(':fone', $this->__get('fone'));
        $stmt->bindValue(':mae', $this->__get('mae'));
        $stmt->bindValue(':naturalidade', $this->__get('naturalidade'));
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':numero', $this->__get('numero'));
        $stmt->bindValue(':obs', $this->__get('obs'));
        $stmt->bindValue(':pai', $this->__get('pai'));
        $stmt->bindValue(':profissao', $this->__get('profissao'));
        $stmt->bindValue(':prontuario', $this->__get('prontuario'));
        $stmt->bindValue(':sexo', $this->__get('sexo'));
        $stmt->bindValue(':sus', $this->__get('sus'));
        $stmt->execute();
    }
}


?>