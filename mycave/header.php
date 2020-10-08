<header>

    <nav>
        <!-- Logo principale -->
        <div class="logo"><img src="images_items/logo-blanc.png" alt="logo_myCave" id="logo"></div>
        <!-- Bloc d'affichage information connexion -->
        <div id="bloc">
            <div id="result"><?php echo $msg = isset($_SESSION['id_utilisateur']) ? 'Bonjour et bienvenue sur votre application, ajouter, modifier ou supprimer des références en un clic.' : 'Bonjour et bienvenue sur my-cave'; ?></div>
        </div>

        <!-- Condition si utilisateur connecté -->
        <?php if(isset($_SESSION['id_utilisateur'])) : ?>

                <!-- Bouton de déconnexion -->
                <div id="boutonDeconnect">
                    <button class="button" onclick="window.location.href = 'disconnect.php';">Exit</button>
                </div>
        
            <?php else : ?>
               
                 <div class="bouttonAdmin">

                <!-- Formulaire de connexion  -->
                <form action="login_post.php" method="POST" id="login_form">

                    <div class="champ_input">
                        <input type="text" name="login" id="login" autocomplete="off" placeholder="Identifiant">
                        <input type="password" name="password" id="password" placeholder="Mot de passe"> 
                    </div>
                    <button type="submit" class="boutonSubmit">Go</button>

                </form>

            </div>         

        <?php endif; ?>

        

    </nav>
    
    
   
</header>
<section class="scrolling_menu">

    <div class="flex_link_button">

    <?php
    if($_SERVER['PHP_SELF'] !== '/index.php'): ?>

        <button type="button" class="visite_link" onclick="location.href='index.php'">
                <div class="goulot">
                    <p class="texte">Accueil</p>
                </div>
        </button>

    <?php endif;
    if($_SERVER['PHP_SELF'] !== '/cave.php'): ?> 
        
        <button type="button" class="visite_link" onclick="location.href='cave.php'">
            <div class="goulot">
                <p class="texte">Visiter</p>
            </div>
        </button>
    <?php endif; 
    if($_SERVER['PHP_SELF'] !== '/contact.php'): ?>

        <button type="button" class="visite_link" onclick="location.href='contact.php'">
            <div class="goulot">
                <p class="texte">Contact</p>
            </div>
        </button>

    <?php endif;
    if(isset($_SESSION['id_utilisateur']) && $_SERVER['PHP_SELF'] !== '/formulaire.php') : ?>

        <button type="button" class="visite_link" onclick="location.href='formulaire.php'">
            <div class="goulot">
                <p class="texte">Ajout</p>
            </div>
        </button>
        
    <?php endif; ?>

    </div>
    <div id="menu">
    <div id="arrow"></div>
    </div>

</section>