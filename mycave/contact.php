<?php
    session_start();
    require 'head.php';
    include 'header.php';
    $title= 'Contact';
?>
<section class="formulaireContact">

    <h2><?php echo($title); ?></h2>

    <form method="POST" action="contact_post.php" id="contact">

        <div class="form_flex">
        
                <label for="name" class="name">Nom</label>
                <input type="text" name="name" id="name">

                <label for="email" class="email">Email</label>
                <input type="mail" name="email" id="email">

                <label for="subject" class="subject">Suggestion</label>
                <textarea name="subject" id="subject"></textarea>
                    
        </div>
        
        <button type="submit" class="button_submit">Envoyer</button>  
                     
    </form>
    <div id="feedback">
        <!-- Afficher le resultat aprés validation du formulaire -->
        </div>
</section>

<?php require 'footer.php';

?>