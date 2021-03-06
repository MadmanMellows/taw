<?php
//Class for interacting with database

class Member extends Dbh {

    //Addes member details to member table
    protected function setMember($first_name, $last_name, $street_address, $postcode, $number){
        $stmt = $this->connect()->prepare("INSERT INTO `member`(`first_name`, `last_name`, `street_address`,
                                                       `postcode`, `number`, `login_id_fk`) 
                                                        VALUES (?,?,?,?,?,?);");
        session_start();
        $login_id_fk = $_SESSION['login_id'];
        // Executes the prepared statement and checks returned value
        if(!$stmt->execute(array($first_name, $last_name, $street_address, $postcode, $number, $login_id_fk))){

            //Used for error checking if statement failed
            //print_r(array($first_name, $last_name, $street_address, $postcode, $number, $login_id_fk));
            print_r($stmt->errorInfo());
            $stmt = null;
            header("location: ../index.php?error=sqlfail");
            exit();
            }
           
        //Upgrades account to full if member details are correct
        $stmt = null;  
        $account_type = 'full';
        $stmt = $this->connect()->prepare("UPDATE `member_login` SET `account_type`=:account_type WHERE `login_id`=:member_id"); 
        $stmt->bindParam(':member_id', $login_id_fk, PDO::PARAM_INT);
        $stmt->bindParam(':account_type', $account_type);

        if($stmt->execute()) {
            session_start();
            $_SESSION["account_type"] = $account_type;
            header("location: ../index.php?error=success");
            exit();
       } else {
        print_r($stmt->errorInfo());
        $stmt = null;
        //header("location: ../index.php?error=accountUpdateFail");
        exit();
       }
    }

    function updateMember($first_name, $last_name, $street_address, $postcode, $number, $member_id){
        $stmt = $this->connect()->prepare("UPDATE member SET first_name = :first_name,
                                           last_name = :last_name,
                                           street_address = :street_address,
                                           postcode = :postcode,
                                           number = :number
                                           WHERE member.member_id = :member_id");
       
        $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);           
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);        
        $stmt->bindParam(':street_address', $street_address, PDO::PARAM_STR);
        $stmt->bindParam(':postcode', $postcode, PDO::PARAM_STR);
        $stmt->bindParam(':number', $number, PDO::PARAM_STR);
        $stmt->bindParam(':member_id', $member_id, PDO::PARAM_INT);

       if(!$stmt->execute()){
        print_r($stmt->errorInfo());
        }
    }

}