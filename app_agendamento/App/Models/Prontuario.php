<?php

namespace App\Models;
use MF\Model\Model;
use Faker\Factory;
use PDO;

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
    private $nascimento;
    private $profissao;
    private $prontuario;
    private $sexo;
    private $sus;
    private $aberto_por;
    private $limit;
    private $offset;



    public function __get($attribute){
        return $this->$attribute;
    }



    public function __set($attribute, $value){
        $this->$attribute = $value;
    }

    public function inserir(){
        $query = 'INSERT INTO prontuario (bairro, complemento, endereco, id_estado_civil, data_nascimento, telefone, mae, naturalidade, nome, numero, observacao, pai, profissao, prontuario, id_sexo, sus, aberto_por) VALUES (:bairro, :complemento, :endereco, :estadoCivil, :nascimento, :telefone, :mae, :naturalidade, :nome, :numero, :observacao, :pai, :profissao, :prontuario, :sexo, :sus, :aberto_por)';
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
        $stmt->bindValue(':nascimento', $this->__get('nascimento'));
        $stmt->bindValue(':aberto_por', $this->__get('aberto_por'));
        $stmt->execute();
    }

    public function getLastId(){
        $query = 'SELECT LAST_INSERT_ID() as id from prontuario';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getPaciente(){
        $query = "SELECT p.*,DATE_FORMAT(p.data_criacao, '%d/%m/%Y') AS data_criacao,FLOOR(DATEDIFF(CURRENT_DATE, p.data_nascimento)/365) AS idade, s.sexo, e.estado_civil FROM prontuario AS p
        JOIN estado_civil AS e ON p.id_estado_civil = e.id
        JOIN sexo AS s ON p.id_sexo = s.id
        WHERE p.id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function pesquisar(){
        $query = "SELECT p.*,DATE_FORMAT(p.data_criacao, '%d/%m/%Y') AS data_criacao, FLOOR(DATEDIFF(CURRENT_DATE, p.data_nascimento)/365) AS idade, s.sexo, e.estado_civil FROM prontuario AS p
        JOIN estado_civil AS e ON p.id_estado_civil = e.id
        JOIN sexo AS s ON p.id_sexo = s.id
        WHERE(p.nome LIKE CONCAT('%', :nome, '%') OR :nome = '')
        AND (p.sus LIKE CONCAT('%', :sus, '%') OR :sus = '')
        AND (p.prontuario LIKE CONCAT('%', :prontuario, '%') OR :prontuario = '')
        AND (p.pai LIKE CONCAT('%', :pai, '%') OR :pai = '')
        AND (p.mae LIKE CONCAT('%', :mae, '%') OR :mae = '') ORDER BY id DESC";


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
        $query = "SELECT p.*, DATE_FORMAT(p.data_criacao, '%d/%m/%Y') AS data_criacao, FLOOR(DATEDIFF(CURRENT_DATE, p.data_nascimento)/365) AS idade, s.sexo, e.estado_civil FROM prontuario AS p
        JOIN estado_civil AS e ON p.id_estado_civil = e.id
        JOIN sexo AS s ON p.id_sexo = s.id WHERE (nome LIKE CONCAT('%', :nome, '%') OR :nome = '') AND (sus LIKE CONCAT('%', :sus, '%') OR :sus = '') AND (prontuario LIKE CONCAT('%', :prontuario, '%') OR :prontuario = '') AND (pai LIKE CONCAT('%', :pai, '%') OR :pai = '') AND (mae LIKE CONCAT('%', :mae, '%') OR :mae = '') ORDER BY id DESC limit $limit offset $offset";
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
            $query = 'INSERT INTO prontuario (bairro, complemento, endereco, id_estado_civil, data_nascimento, telefone, mae, naturalidade, nome, numero, observacao, pai, profissao, prontuario, id_sexo, sus, aberto_por) VALUES (:bairro, :complemento, :endereco, :estadoCivil, :nascimento, :telefone, :mae, :naturalidade, :nome, :numero, :observacao, :pai, :profissao, :prontuario, :sexo, :sus, :aberto_por)';

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':bairro', $faker->streetName());
            $stmt->bindValue(':complemento', $faker->streetName());
            $stmt->bindValue(':endereco', $faker->address());
            $stmt->bindValue(':estadoCivil', 1);
            $stmt->bindValue(':telefone', $faker->cellphone());
            $stmt->bindValue(':mae', $faker->name('female'));
            $stmt->bindValue(':naturalidade', $faker->regionAbbr());
            $stmt->bindValue(':nome',  $faker->name());
            $stmt->bindValue(':numero', $this->__get('numero'));
            $stmt->bindValue(':observacao', $this->__get('observacao'));
            $stmt->bindValue(':pai', $faker->name('male'));
            $stmt->bindValue(':profissao', $faker->jobTitle());
            $stmt->bindValue(':prontuario', '321123');
            $stmt->bindValue(':sexo', 1);
            $stmt->bindValue(':sus', $faker->cnpj());
            $stmt->bindValue(':nascimento', '1985-03-19');
            $stmt->bindValue(':aberto_por', $faker->name());
            $stmt->execute();
        }
    }
}


?>