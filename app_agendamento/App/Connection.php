<?php

    namespace App;



    class Connection{



    public static function getDb(){

        try {

            $conn = new \PDO(

                'mysql:dbname=u611050133_agendamento_cf;host=srv1041.hstgr.io; charset=utf8',

                "u611050133_root", 

                "Lker4nFM#.9U#qW",

                array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

            



            return $conn;

        } catch (\PDOException $e) {
            error_log($e);
        }

    }

       

}

?>