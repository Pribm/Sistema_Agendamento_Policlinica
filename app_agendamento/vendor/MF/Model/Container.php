<?php
namespace MF\Model;

use App\Connection;

    class Container{

        public static function getModel($model){

            //essa variável vai dinamicamente, com base no parâmetro passado na função, instanciar o modelo
            $class = "\\App\\Models\\".ucfirst($model);

            $conn = Connection::getDb();

            //retornar o modelo solicitado ja instanciado, inclusive com a conexão já estabelacida.
            return new $class($conn);
        }

    }
?>