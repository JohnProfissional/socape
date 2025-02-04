<?php

require_once __DIR__ . '/../model/Motor.php';
require_once __DIR__ . '/../model/Database.php';

class MotorController extends Motor
{
    protected $tabela = 'motor';

    public function __construct()
    {
    }

    public function findOne($idmotor)
    {
        $query = "SELECT * FROM $this->tabela WHERE idmotor = :idmotor";
        $stm = Database::prepare($query);
        $stm->bindParam(':idmotor', $idmotor, PDO::PARAM_INT);
        $stm->execute();

        foreach ($stm->fetchAll() as $obj) {
            $motor = new Motor(null, null);
            $motor->setIdmotor($obj->idmotor);
            $motor->setPotencia($obj->potencia);
        }
        return $motor;  
    }

    public function findAll()
    {
        $query = "SELECT * FROM $this->tabela ORDER BY potencia";
        $stm = Database::prepare($query);
        $stm->execute();
        $motores = array();

        foreach ($stm->fetchAll() as $obj) {
            array_push(
                $motores,
                new Motor($obj->idmotor, $obj->potencia)
            );
        }
        return $motores;
    }

    public function insert($potencia)
    {
        $query = "INSERT INTO $this->tabela (potencia)
        VALUES (:potencia)";
        $stm = Database::prepare($query);
        $stm->bindParam(':potencia', $potencia);        

        return $stm->execute();
    }

    public function update($idmotor)
    {
        $query = "UPDATE $this->tabela SET marca = :marca WHERE idmotor = :idmotor";
        $stm = Database::prepare($query);
        $stm->bindParam(':idmotor', $idmotor, PDO::PARAM_INT);
        $stm->bindValue(':potencia', $this->getPotencia());
        
        return $stm->execute();
    }

    public function delete($idmotor)
    {
        $query = "DELETE FROM $this->tabela WHERE idmotor = :idmotor";
        $stm = Database::prepare($query);
        $stm->bindParam(':idmotor', $idmotor, PDO::PARAM_INT);
        return $stm->execute();
    }
    
}
