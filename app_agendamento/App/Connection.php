<?php
    namespace App;

    class Connection{

    public static function getDb(){
        try {
            $conn = new \PDO(
                'mysql:dbname=agendamento_cardoso_fontes;host=localhost',
                "root", 
                ""
            );

            return $conn;
        } catch (PDOException $e) {
            $e->error_log();
        }
    }
       
}
?>