<?php
//Class for interacting with database

class Score extends Dbh {

    //Adds points to a members points on podium result
    protected function setPoints($points, $place){
        $stmt = $this->connect()->prepare("UPDATE comp_entry SET points = points + ? WHERE image_id_fk = ?;");
       
       if(!$stmt->execute(array($points, $place))){
        print_r($stmt->errorInfo());
        }
    }
}