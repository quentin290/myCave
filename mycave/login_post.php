<?php
session_start();
require 'connect.php';

$salt = "g9==*000ù°5";
$salt1 = "85+<:l6W77";
$utilisateur = strip_tags($_POST['login']);
$mot_de_passe = strip_tags($_POST['password']);
$mdp_hash = sha1($mot_de_passe .$salt1 .$utilisateur .$salt);

//requête 
$req = $bdd->prepare("SELECT id_utilisateur FROM administrateur WHERE utilisateur = :utilisateurREQ AND mot_de_passe = :mot_de_passeREQ");

$req->execute(
    array(
        'utilisateurREQ' => $utilisateur,
        'mot_de_passeREQ' => $mdp_hash
    )
);

$resultat = $req->fetch();

if($resultat) :

    $_SESSION['id_utilisateur'] = $resultat['id_utilisateur'];
    $msg_success = "";

else :

    $msg_error = "identifiant ou mot de passe incorrect !";

endif;

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
