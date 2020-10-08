<?php
session_start();
require 'connect.php';


$idSup = intval($_POST['idBouteille']);
$photoDelete = intval($_POST['imageBouteille']);

$req = $bdd->prepare("DELETE FROM bouteille WHERE id = :id");
var_dump($idSup);
echo $idSup;

$req->execute(
    array(
        "id" => $idSup
    )
);

unlink ("images_items/".$photoDelete); //Permet de supprimer l'ancienne image

header('Location: cave.php');

?>