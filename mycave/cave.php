<?php session_start(); ?>

    <?php
    require 'head.php';
    include 'header.php';
//     include 'section_1.php';
//     include 'cave.php';
    $message = "Bienvenue dans la cave et bonne visite.";
    ?>

<section class="cave">
        <!-- partie recherche de bouteille et ajout -->
        <form action="recherche_post.php" method="POST" class="ongletRecherche" id="moteurRecherche">
        <input type="search" name="research" id="research" placeholder="Entrez un mot-clé">
        <button type="submit" id="start_search">Rechercher</button>
        </form>
        <div id="messageError"></div>

        <!-- Connection et affichage des données -->
        <?php
        
        //Variable $page qui aura pour valeur le numéro de la page affiché
        $page = (!empty($_GET['page']) ? $_GET['page'] : 1);
        //Variable qui limite le nombre de bouteille par page
        $limite = 6;
        $debut = ($page - 1) * $limite;

        //connection base de donnée
        require 'connect.php';

        //Partie Requête
        $query = 'SELECT SQL_CALC_FOUND_ROWS * FROM bouteille LIMIT :limite OFFSET :debut';
        $query = $bdd->prepare($query);
        $query->bindValue('debut', $debut, PDO::PARAM_INT);
        $query->bindValue('limite', $limite, PDO::PARAM_INT);
        $query->execute();

        /* Ici on récupère le nombre d'éléments total. Comme c'est une requête, il ne
        * faut pas oublier qu'on ne récupère pas directement le nombre.
        * De plus, comme la requête ne contient aucune donnée client pour fonctionner,
        * on peut l'exécuter ainsi directement */
        $resultFoundRows = $bdd->query('SELECT found_rows()');
        /* On doit extraire le nombre du jeu de résultat */
        $nombreDeBouteilleTotal = $resultFoundRows->fetchColumn();
        // var_dump($nombreDeBouteilleTotal);

        ?>
        
        <div class="mesBouteilles">
        <?php
        $i = 0;
        //affichage des données
        while ($donnees = $query->fetch())
        {
               $i++;
        ?>
                <div class="uneBouteille">
                        <div class="titre">
                                <h3><?php echo $donnees['nom']; ?></h3>
                                <h3><?php echo $donnees['annee']; ?></h3>
                        </div>
                        <div class="blocPhotoTexte">
                                <div class="photoBouteille">
                                        <img class="image" src="images_items/<?php echo $donnees['image']; ?>">
                                </div>
                                <div class="texteBouteille">
                                        <h4>Cépage: <span class="infos"><?php echo $donnees['raisins']; ?></span></h4>
                                        <h4>Pays: <span class="infos"><?php echo $donnees['pays']; ?></span></h4>
                                        <h4>Regions: <span class="infos"><?php echo $donnees['region']; ?></span></h4>
                                        <p>Description: <span class="infos"><?php echo $donnees['description']; ?></span><p>
                                </div>
                        </div>
                        
                        <div class="fonctionBouteille">
                                <?php if(isset($_SESSION['id_utilisateur'])) : ?>
                                <!-- boutons pour modifier ou supprimer une bouteille -->
                                <?php $monId = $donnees['id'];
                                // echo $monId;
                                ?>
                                <!--Formuliare pour modifier une bouteille -->
                                <form action="modifications" method="POST" class="click_modifier">
                                        <input type="hidden" class="idBouteille" name="idBouteille" value="<?php echo $monId ?>">
                                        <button type="submit">Modifier</button>
                                </form>
                        
                                <!--Formuliare pour supprimer une bouteille -->
                                <form action="supprimer_post.php" method="POST" onsubmit="return confirm('Etes-vous sur de vouloir supprimer? Si vous cliquez sur OK la bouteille serat definitivement supprimé');">
                                        <input type="hidden" class="idBouteille" name="idBouteille" value="<?php echo $monId ?>">
                                        <input type="hidden" class="imageBouteille" name="imageBouteille" value="<?php echo $donnees['image']; ?>">
                                        <button type="submit">Supprimer</button>
                                </form>
                        
                        <?php endif; ?>
                        </div>
                        
                </div>
        <?php
        }
        ?>
</div>

<div class="paging">
        <?php
        // Partie "Liens"
        /* On calcule le nombre de pages */
        $nombreDePages = ceil($nombreDeBouteilleTotal / $limite);

        if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
        {
            $pageActuelle = intval($_GET['page']);
            if($pageActuelle > $nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
            {
                $pageActuelle = $nombreDePages;
            }
        }
        else // Sinon
        {
            $pageActuelle = 1; // La page actuelle est la n°1    
        }

        /* Si on est sur la première page, on n'a pas besoin d'afficher de lien
        * vers la précédente. On va donc l'afficher que si on est sur une autre
         * page que la première */
        if ($page > 1):
        ?>
        <a href="?page=<?php echo $page - 1; ?>" class="precedente"></a> 
        <?php
        endif;
        /* On va effectuer une boucle autant de fois que l'on a de pages */
        for ($i = 1; $i <= $nombreDePages; $i++):
            if($i !== $pageActuelle):
            ?>
            <a href="?page=<?php echo $i; ?>" class="numberPage"><?php echo $i; ?></a> 
        <?php
        endif;
        endfor;
    
        /* Avec le nombre total de pages, on peut aussi masquer le lien
        * vers la page suivante quand on est sur la dernière */
        if ($page < $nombreDePages):
        ?>
        <a href="?page=<?php echo $page + 1; ?>" class="suivante"></a>
        <?php
        endif;
        
        ?>

        
</div>
<?php
// Termine le traitement de la requête
$query->closeCursor(); 
?>

</section>
<?php 
require 'footer.php';
?>