<?php
require 'connect.php';

//je récupère les variables 
$name          = strip_tags(trim($_POST['name']));
$annee         = strip_tags(trim($_POST['annee']));
$raisins       = strip_tags(trim($_POST['raisins']));
$pays          = strip_tags(trim($_POST['pays']));
$region        = strip_tags(trim($_POST['region']));
$description   = strip_tags(trim($_POST['description']));
$file          = $_FILES['upload'];

if(!isset($_POST['name']) || empty($_POST['name'])) {

    $msg_error = "Veuillez renseigner un nom";

}
elseif(!isset($_POST['annee']) || empty($_POST['annee'])) {
    

    $msg_error = "Veuillez renseigner une année";

}
elseif(!isset($_POST['raisins']) || empty($_POST['raisins'])) {
    

    $msg_error = "Veuillez renseigner un type de raisin";

}
elseif (!isset($_POST['pays']) || empty($_POST['pays'])) {

    $msg_error = "Veuillez renseigner un pays";

}
elseif (!isset($_POST['region']) || empty($_POST['region'])) {

    $msg_error = "Veuillez renseigner une région";

}
elseif (!isset($_POST['description']) || empty($_POST['description'])) {

    $msg_error = "Veuillez renseigner une description";

}
elseif(isset($file) && $file['error'] == 4) {

    $msg_error = "Veuillez charger une image";

}
else {
    
    if(isset($file) && $file['error'] == 0) {
        $valid_ext = array('jpg','jpeg','png');
        //1. strrchr renvoie l'extension avec le point (« . »).
        //2. substr(chaine,1) ignore le premier caractère de chaine.
        //3. strtolower met l'extension en minuscules.
        $extension_upload = strtolower(substr(strrchr($file['name'], '.'),1));

        if(in_array($extension_upload,$valid_ext)) { // je vérifie que l'extension uploadé est bien une image

            if($file['size'] <= 2000000) {

                $upload_name = uniqid() . $file['name']; // je rajoute un code unique aléatoire
                $dir = "images/" . $upload_name;

                $resultat = move_uploaded_file($file['tmp_name'],$dir); // je déplace le fichier du répertoire temporaire => dossier upload
                // si réussite => return TRUE
                if($resultat) {

                    $msg_success = 'La bouteille a bien était ajouté à la cave!';
                    // preparation de la requête
                    $req = $bdd->prepare("INSERT INTO bouteille (nom, annee, raisins, pays, region, description, image) VALUES(:nom, :annee, :raisins, :pays, :region, :description, :image)");
                    // execution de la requête
                    $result = $req->execute(
                        array(
                        "nom" => $name,
                        "annee" => $annee,
                        "raisins" => $raisins,
                        "pays" => $pays,
                        "region" => $region,
                        "description" => $description,
                        "image" => $upload_name
                        )
                );
                    
                }
                else {

                    $msg_error = 'Oups, une erreur s\'est produite';

                }
            }
            else {

                $msg_error = 'L\'image trop volumineuse';

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