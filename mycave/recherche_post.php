<?php 
session_start();
require "connect.php";

$research = strip_tags(trim($_POST["research"]));
    // gets value sent over search form
     
    $min_length = 3;
    // you can set minimum length of the query if you want
     
    if(strlen($research) >= $min_length){ // if query length is more or equal minimum length then

        $query = $bdd->prepare("SELECT * FROM bouteille WHERE nom LIKE ? OR pays LIKE ? OR raisins LIKE ? OR region LIKE ? OR annee LIKE ? OR description LIKE ?");
        $query->execute(
            array(
                 "%".$research."%",
                 "%".$research."%",
                 "%".$research."%",
                 "%".$research."%",
                 "%".$research."%",
                 "%".$research."%"
                )
            );
  
            
           $count = $query->rowCount();
               if($count >= 1){// if there is no matching rows do following
                     
                    $donnees = $query->fetchAll(PDO::FETCH_ASSOC);
                       
                        $msg_success = $donnees;
                              
                }
                else{ 
                    $msg_error = "Aucun résultat pour cette recherche!";
                }
            // $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop
            
         
    }
    else{ // if query length is less than minimum
        $msg_error =  "Veuillez entrez au minimum ".$min_length. " caractères";
    }

    
    $error_true = isset($msg_error);
    
    if($error_true) {
        $msg = array();
        $msg['error'] = TRUE;
        $msg['message'] = $msg_error;
    }
    else {
        $msg['error'] = FALSE;
        $msg['bouteilles'] = $msg_success;
    }

    header('Content-Type: application/json');
    echo json_encode($msg);

?>