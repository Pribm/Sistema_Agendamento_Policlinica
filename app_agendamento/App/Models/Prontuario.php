<?php

namespace App\Models;
use MF\Model\Model;
use Faker\Factory;



class Prontuario extends Model{


    private $id;
    private $nome;
    private $nome_pai;
    private $nome_mae;
    private $bairro;
    private $complemento;
    private $endereco;
    private $naturalidade;
    private $numero;
    private $estado_civil;
    private $telefone;
    private $observacao;
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
        $query = 'INSERT INTO prontuario (bairro, complemento, endereco, id_estado_civil, telefone, mae, naturalidade, nome, numero, observacao, pai, profissao, prontuario, id_sexo, sus) VALUES (:bairro, :complemento, :endereco, :estadoCivil, :telefone, :mae, :naturalidade, :nome, :numero, :observacao, :pai, :profissao, :prontuario, :sexo, :sus)';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':bairro', $this->__get('bairro'));
        $stmt->bindValue(':complemento', $this->__get('complemento'));
        $stmt->bindValue(':endereco', $this->__get('endereco'));
        $stmt->bindValue(':estadoCivil', $this->__get('estado_civil'));
        $stmt->bindValue(':telefone', $this->__get('telefone'));
        $stmt->bindValue(':mae', $this->__get('nome_mae'));
        $stmt->bindValue(':naturalidade', $this->__get('naturalidade'));
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':numero', $this->__get('numero'));
        $stmt->bindValue(':observacao', $this->__get('observacao'));
        $stmt->bindValue(':pai', $this->__get('nome_pai'));
        $stmt->bindValue(':profissao', $this->__get('profissao'));
        $stmt->bindValue(':prontuario', $this->__get('prontuario'));
        $stmt->bindValue(':sexo', $this->__get('sexo'));
        $stmt->bindValue(':sus', $this->__get('sus'));
        $stmt->execute();
    }

    public function pesquisar(){
        $query = "SELECT * from prontuario WHERE (nome LIKE CONCAT('%', :nome, '%') OR :nome = '') AND (sus LIKE CONCAT('%', :sus, '%') OR :sus = '') AND (prontuario LIKE CONCAT('%', :prontuario, '%') OR :prontuario = '') AND (pai LIKE CONCAT('%', :pai, '%') OR :pai = '') AND (mae LIKE CONCAT('%', :mae, '%') OR :mae = '')";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':sus', $this->__get('sus'));
        $stmt->bindValue(':prontuario', $this->__get('prontuario'));
        $stmt->bindValue(':mae', $this->__get('nome_mae'));
        $stmt->bindValue(':pai', $this->__get('nome_pai'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    //pesquisar com paginação
    public function pesquisarPorPagina($limit, $offset){
        $query = "SELECT * from prontuario WHERE (nome LIKE CONCAT('%', :nome, '%') OR :nome = '') AND (sus LIKE CONCAT('%', :sus, '%') OR :sus = '') AND (prontuario LIKE CONCAT('%', :prontuario, '%') OR :prontuario = '') AND (pai LIKE CONCAT('%', :pai, '%') OR :pai = '') AND (mae LIKE CONCAT('%', :mae, '%') OR :mae = '') ORDER BY data_criacao DESC limit $limit offset $offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':sus', $this->__get('sus'));
        $stmt->bindValue(':prontuario', $this->__get('prontuario'));
        $stmt->bindValue(':mae', $this->__get('nome_mae'));
        $stmt->bindValue(':pai', $this->__get('nome_pai'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    //recuperar o numero de registros
    public function getTotalRegistros(){
        $query = "SELECT count(*) as total from prontuario WHERE (nome LIKE CONCAT('%', :nome, '%') OR :nome = '') AND (sus LIKE CONCAT('%', :sus, '%') OR :sus = '') AND (prontuario LIKE CONCAT('%', :prontuario, '%') OR :prontuario = '') AND (pai LIKE CONCAT('%', :pai, '%') OR :pai = '') AND (mae LIKE CONCAT('%', :mae, '%') OR :mae = '')";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':sus', $this->__get('sus'));
        $stmt->bindValue(':prontuario', $this->__get('prontuario'));
        $stmt->bindValue(':mae', $this->__get('nome_mae'));
        $stmt->bindValue(':pai', $this->__get('nome_pai'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function inserirRegistrosTeste($numero_de_registros){
        $faker = Factory::create('pt_BR');
        for ($i=0; $i < $numero_de_registros; $i++) { 
            $query = "INSERT INTO prontuario (bairro, complemento, endereco, estadoCivil, fone, mae, naturalidade, nome, numero, obs, pai, profissao, prontuario, sexo, sus) VALUES (:bairro, :complemento, :endereco, :estadoCivil, :fone, :mae, :naturalidade, :nome, :numero, :obs, :pai, :profissao, :prontuario, :sexo, :sus)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':bairro', $faker->streetName());
            $stmt->bindValue(':complemento', $faker->streetName());
            $stmt->bindValue(':endereco', $faker->address());
            $stmt->bindValue(':estadoCivil', $faker->numberBetween(1,3));
            $stmt->bindValue(':fone', $faker->cellphone());
            $stmt->bindValue(':mae', $faker->name('female'));
            $stmt->bindValue(':naturalidade', $faker->regionAbbr());
            $stmt->bindValue(':nome', $faker->name());
            $stmt->bindValue(':numero', $faker->buildingNumber());
            $stmt->bindValue(':obs', $faker->realText(120));
            $stmt->bindValue(':pai', $faker->name('male'));
            $stmt->bindValue(':profissao', $faker->jobTitle());
            $stmt->bindValue(':prontuario', $faker->numberBetween(95000,99999));
            $stmt->bindValue(':sexo', $faker->numberBetween(1,3));
            $stmt->bindValue(':sus', $faker->cnpj(false));
            $stmt->execute();
        }
    }
}


?>