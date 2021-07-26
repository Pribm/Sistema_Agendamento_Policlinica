<?php
namespace App\Models;

use MF\Model\Model;

class DiaSemana extends Model{


    public function labelDias($id){
        $query = "SELECT dia FROM dias_de_atendimento WHERE id =".$id;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch()['dia'];
    }
}

?>