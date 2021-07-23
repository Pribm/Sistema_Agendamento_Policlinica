<?php

    namespace App;



    class Connection{



    public static function getDb(){

        try {

            $conn = new \PDO(

                'mysql:dbname=agendamento_cardoso_fontes;host=127.0.0.1:3306; charset=utf8',
                "root", 
                "",
                array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

            



            return $conn;

        } catch (\PDOException $e) {

            $e->error_log;

        }

    }

       

}

?>