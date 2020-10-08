<?php
require 'connect.php';

if(!isset($_POST['name']) || empty($_POST['name'])) {

    $msg_error = "Merci de renseigner un nom";
    
}
elseif(!isset($_POST['annee']) || empty($_POST['annee'])) {
    
    $msg_error = "Merci de renseigner une année";

}
elseif(!isset($_POST['raisins']) || empty($_POST['raisins'])) {
    
    $msg_error = "Merci de renseigner un type de raisin";

}
elseif (!isset($_POST['pays']) || empty($_POST['pays'])) {

    $msg_error = "Merci de renseigner un pays";

}
elseif (!isset($_POST['region']) || empty($_POST['region'])) {

    $msg_error = "Merci de renseigner une région";

}
elseif (!isset($_POST['description']) || empty($_POST['description'])) {

    $msg_error = "Merci de renseigner une description";

}
else {

    //je récupère les variables
        $idMaBouteille = intval($_POST['idMaBouteille']);
        $name          = strip_tags(trim($_POST['name']));
        $annee         = strip_tags(trim($_POST['annee']));
        $raisins       = strip_tags(trim($_POST['raisins']));
        $pays          = strip_tags(trim($_POST['pays']));
        $region        = strip_tags(trim($_POST['region']));
        $description   = strip_tags(trim($_POST['description']));
        $file          = $_FILES['upload'];
        $photoDelete   = $_POST['photoDelete'];

    if(isset($file) && $file['error'] == 0) {
        $valid_ext = array('jpg','jpeg','png');
        //1. strrchr renvoie l'extension avec le point (« . »).
        //2. substr(chaine,1) ignore le premier caractère de chaine.
        //3. strtolower met l'extension en minuscules.
        $extension_upload = strtolower(substr(strrchr($file['name'], '.'),1));

        if(in_array($extension_upload,$valid_ext)) { // je vérifie que l'extension uploadé est bien une image

            if($file['size'] <= 2000000) {

                $upload_name = uniqid() . $file['name']; // je rajoute un code unique aléatoire
                $dir = "images_items/" . $upload_name;

                $resultat = move_uploaded_file($file['tmp_name'],$dir); // je déplace le fichier du répertoire temporaire => dossier upload
                // si réussite => return TRUE
                if($resultat) {

                    $msg_success = 'La bouteille selectionné a été modifié avec succés!000000000000000';
                    // preparation de la requête
                    $req = $bdd->prepare("UPDATE bouteille SET nom = :nom, annee = :annee, raisins = :raisins, pays = :pays, region = :region, description = :description, image = :image WHERE id = :id");
                    // execution de la requête
                    $result = $req->execute(
                        array(
                        ":id" => $idMaBouteille,
                        ":nom" => $name,
                        ":annee" => $annee,
                        ":raisins" => $raisins,
                        ":pays" => $pays,
                        ":region" => $region,
                        ":description" => $description,
                        ":image" => $upload_name
                        )
                    );

                    unlink ("images_items/".$photoDelete); //Permet de supprimer l'ancienne image
                    
                }
                else {

                    $msg_error = 'Oups, une erreur s\'est produite';

                }
            }
            else {

                $msg_error = 'Image trop volumineuse';

            }
   

        }
        else {

            $msg_error = 'Le fichier envoyé n\'est pas une image au format jpg, jpeg ou png';
        }
    }
    else {
        
        if($file && $file['error'] == 3 || $file['error'] > 4) {
            $msg_error = "Oops !! une erreur s'est produite";
        }
        elseif(isset($file) && $file['error'] == 4) {

            $msg_success = 'La bouteille selectionné a été modifié avec succés! sans nouvelle image!';
                    // preparation de la requête
                    $req = $bdd->prepare("UPDATE bouteille SET nom = :nom, annee = :annee, raisins = :raisins, pays = :pays, region = :region, description = :description WHERE id = :id");
                    // execution de la requête
                    $result = $req->execute(
                        array(
                        ":id" => $idMaBouteille,
                        ":nom" => $name,
                        ":annee" => $annee,
                        ":raisins" => $raisins,
                        ":pays" => $pays,
                        ":region" => $region,
                        ":description" => $description
                        )
                );

                
        }
        else {
            $msg_error = "Taille du fichier trop importante";
        }
    }

}

$msg = array();
$error_true = isset($msg_error);

if($error_true) {
    $msg['error'] = TRUE;
    $msg['message'] = $msg_error;
}
else {
    $msg['error'] = FALSE;
    $msg['message'] = $msg_success;
}

header('Content-Type: application/json');
echo json_encode($msg);

?>