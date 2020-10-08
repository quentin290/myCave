<?php
session_start();
if(isset($_SESSION['id_utilisateur'])) :

require 'head.php';
require 'header.php';
$title = 'Ajout d\'une bouteille';

?>
<section class="formulaireBouteille">

<h2><?php echo($title); ?></h2>

<form action="formulaire_post.php" method="POST" id="formulaire_form" runat="server" enctype="multipart/form-data">

        <div class="form_flex">
              <div class="part_left">
                <label for="name" class="name">Nom</label>
                <input type="text" name="name" id="name" placeholder="Nom de la bouteille" autocomplete="off">

                <label for="pays" class="pays">Pays d'origine</label>
                <input type="text" name="pays" id="pays" placeholder="Pays" autocomplete="off">

                <label for="region" class="region">Région d'origine</label>
                <input type="text" name="region" id="region" placeholder="Région" autocomplete="off">

                <label for="description" class="description">Description</label>
                <textarea name="description" id="description" placeholder="Description" rows="8" cols="4"></textarea>
                </div>
                <div class="part_right">

                <label for="annee" class="annee">Année</label>
                <input type="text" name="annee" id="annee" placeholder="Année de la bouteille" autocomplete="off">

                <label for="raisins" class="raisins">Cépage</label>
                <input type="text" name="raisins" id="raisins" placeholder="Cépage" autocomplete="off">

                <label for="upload" class="upload">Photo</label>
                <input type="file" name="upload" id="upload" accept="image/png, image/jpeg, image/jpg">
                <img id="image" src="#" alt="apercu de l'image selectionne" />
                
                </div>  
        </div>
        
        <button type="submit" class="button_submit">Valider</button>

        <div id="resultat">
        <!-- Afficher le resultat aprés validation du formulaire -->
        </div>
                     
</form>

</section>

<?php 
require 'footer.php';

else :
        header('location: 404.php');
endif;
?>






