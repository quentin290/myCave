<?php
session_start();

if(isset($_SESSION['id_utilisateur'])) :
             
require 'connect.php';
require 'head.php';
include 'header.php';
$title = 'Modification d\'une bouteille';
// include 'section_1.php';

$idMod = intval($_POST['idBouteille']);
$req = "SELECT * FROM bouteille where id = '$idMod'";
$req = $bdd->prepare($req);
$req->execute();
$donnees = $req->fetch();
// var_dump($donnees);

?>

<!-- bouton de retour vers la cave -->


<section class="formulaireBouteille">

<h2><?php echo($title); ?></h2>
<img src="" alt="" id="succes">

<form action="modifier_post.php" method="POST" id="modifier_form" runat="server" enctype="multipart/form-data" >
        <input type="hidden" id="idMaBouteille" name="idMaBouteille" value="<?php echo $donnees['id']; ?>" >
        <div class="form_flex">
                <div class="part_left">

                <label for="name" class="name">Nom</label>
                <input type="text" name="name" id="name" value="<?php echo $donnees['nom']; ?>" >

                <label for="pays" class="pays">Pays d'origine</label>
                <input type="text" name="pays" id="pays" value="<?php echo $donnees['pays']; ?>">

                <label for="region" class="region">Région d'origine</label>
                <input type="text" name="region" id="region" value="<?php echo $donnees['region']; ?>">

                <label for="description" class="description">Description</label>
                <textarea name="description" id="description" rows="8" cols="4"><?php echo $donnees['description']; ?></textarea>
        </div>
        <div class="part_right">
        <label for="annee" class="annee">Année</label>
        <input type="text" name="annee" id="annee" value="<?php echo $donnees['annee']; ?>">

        <label for="raisins" class="raisins">Cépage</label>
                <input type="text" name="raisins" id="raisins" value="<?php echo $donnees['raisins']; ?>">
        
        <label for="upload" class="upload">Photo</label>
        <input type="file" name="upload" id="upload" accept="image/png, image/jpeg, image/jpg">
        <!-- affiche l'image de la bouteille a modifier -->
        <img src="images_items/<?php echo $donnees['image'];?>" id="image">

        <input type="hidden" id="photoDelete" name="photoDelete" value="<?php echo $donnees['image']; ?>" >

        
        </div>
        </div>
        
        <button type="submit" class="button_submit">Valider</button> 

</form>
<div id="modif">
<!-- Afficher le resultat aprés validation du formulaire -->
</div>


</section>

<?php require 'footer.php'; 

else : 
        header('location: 404.php');

endif; ?> 