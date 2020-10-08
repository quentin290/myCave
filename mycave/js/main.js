(function($) {
    
$(document).ready(function() {

    // Fonction au click sur le logo de droite faire apparaitre la formulaire de connexion
    $('#logo').on('click', function() {
        if( !$('div').is('#boutonDeconnect')){
        
            $('#login_form').toggleClass('appear');
        }  
    });

    // fonction evénement sur entrée dans un input
    $('label, input, textarea').on('focus', function() {
            $('label, input, textarea').removeClass('hasclick');
            $(this).addClass('hasclick');
    });
    $(document).click(function(event) { 
        if(!$(event.target).closest('label, input, textarea').length) {
            //Le clic s'est produit en dehors de l'élément monElement
            $('input, textarea').removeClass('hasclick');
        } 
    });

    // +++++++++++++++FONCTION SCROLLING MENU+++++++++++++++++++++++++
    $('#arrow').on('click', function(){
        $('.scrolling_menu').toggleClass('scroll_down');
        if($('.scrolling_menu').hasClass('scroll_down')){
            $('#arrow').addClass('turned');
        }
        else{
             $('#arrow').removeClass('turned');
        }
    });
    $(document).click(function(event) { 
        if(!$(event.target).closest('#arrow').length) {
            //Le clic s'est produit en dehors de l'élément monElement
            $('.scrolling_menu').removeClass('scroll_down');
            $('#arrow').removeClass('turned');
        } 
    });
    
   
    //+++++++++++++++++++++++++++++++++++++++++++++++++
    //fonction ajax pour formulaire d'ajout de bouteille
    //+++++++++++++++++++++++++++++++++++++++++++++++++
    $('#formulaire_form').submit(function() {

        //vide la div #resultat de son contenue
        $('#resultat').empty();

        //recupération des données du formulaire
        var form = $(this);
        var formdata = (window.FormData) ? new FormData(form[0]) : null;
        var data = (formdata !== null) ? formdata : form.serialize();
        
            $.ajax({
                url: form.attr('action'), //le fichier cible côté serveur
                type: form.attr('method'),
                contentType: false, // obligatoire pour le formData
                processData: false, // obligatoire pour le formData
                dataType: 'json',
                data: data,
                success: function(data){
                    
                    if(data.error == true) {
                        $('#resultat').append(data.message);
                        
                    }
                    else {
                        $('#resultat').append(data.message);
                        $('#formulaire_form')[0].reset(); //efface les données du formulaire
                    }
                }

            });
    
        return false;
    });
    

    //++++++++++++++++++++++++++++++++++++++++++++++++++++
    //fonction ajax pour formulaire de connexion admin
    //++++++++++++++++++++++++++++++++++++++++++++++++++++
    $('#login_form').on('submit', function() {

        //vide la div #result de son contenue
        $('#result').empty();
        $('#bloc').css('display', 'block');
        //recupération des données du formulaire
        var form = $(this);
        var formdata = (window.FormData) ? new FormData(form[0]) : null;
        var data = (formdata !== null) ? formdata : form.serialize();
        
            $.ajax({
                url: form.attr('action'), //le fichier cible côté serveur
                type: form.attr('method'),
                contentType: false, // obligatoire pour le formData
                processData: false, // obligatoire pour le formData
                dataType: 'json',
                data: data,
                success: function(data){
                    if(data.error == true) {
                        $('#result').append(data.message);
                        
                    }
                    else {  
                        $('#result').append(data.message);
                        $('#login_form').hide();
                        // $('.mesBouteilles').load("../cave.php");
                        document.location.reload(true);
                        
                    }
                }

            });
    
        return false;
    });

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //fonction ajax pour formulaire de modification d'une bouteille
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    $('#modifier_form').submit(function() {

         //vide la div #result de son contenue
         $('#modif').empty();

        //recupération des données du formulaire
        var form = $(this);
        var formdata = (window.FormData) ? new FormData(form[0]) : null;
        var data = (formdata !== null) ? formdata : form.serialize();

           $.ajax({
                url: form.attr('action'), //le fichier cible côté serveur
                type: form.attr('method'),
                contentType: false, // obligatoire pour le formData
                processData: false, // obligatoire pour le formData
                dataType: 'json',
                data: data,
                success: function(data){
                    if(data.error == true) {
                        $('#modif').append(data.message);
            
                    }
                    else { 
                        $('#modif').append(data.message);
                        $('#modifier_form').remove();
                        $('#succes').attr('src', 'https://www.reactiongifs.com/r/vhpy.gif');
                    }
                }

            });
    
        return false;
    });


    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //Appel de la fonction readURL pour afficher ou modifier l'apercu de l'image dans le input id="upload"
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    $("#upload").change(function(){
        readURL(this);
    });

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //fonction ajax pour formulaire recherche par mot clé
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    $('#moteurRecherche').submit(function() {

        //vide la div #result de son contenue
        $('#messageError').empty();

       //recupération des données du formulaire
       var form = $(this);
       var formdata = (window.FormData) ? new FormData(form[0]) : null;
       var data = (formdata !== null) ? formdata : form.serialize();

          $.ajax({
               url: form.attr('action'), //le fichier cible côté serveur
               type: form.attr('method'),
               contentType: false, // obligatoire pour le formData
               processData: false, // obligatoire pour le formData
               dataType: 'json',
               data: data,
               success: function(data){
                   if(data.error == true) {
                       $('#messageError').append(data['message']);
                   }
                   else {
                    // vide les div mesBouteilles et paging

                        $donneesB = data['bouteilles'];

                        console.log($donneesB.length);
                        var $id_user = $('.click_modifier');
                        console.log($id_user.length);
                        if( $id_user.length ){
                            $('.mesBouteilles').empty();
                            $('.paging').empty();

                            for(i=0; $donneesB.length > i; i++) {
                            
                            $('.mesBouteilles').append(
                                "<div class='uneBouteille'>" + 
                                "<div class='titre'>" + 
                                "<h3>" + 
                                $donneesB[i]['nom'] +' '+ $donneesB[i]['annee'] + 
                                "</h3>" + 
                                "</div>" + 
                                "<div class='blocPhotoTexte'>" +
                                "<div class='photoBouteille'>" +
                                "<img class='image' src='images_items/" +
                                $donneesB[i]['image'] +
                                "'></div>" +
                                "<div class='texteBouteille'>" +
                                "<h4>Raisins: <span class='infos'>" +
                                $donneesB[i]['raisins'] +
                                "</span></h4>" +
                                "<h4>Pays: <span class='infos'>" +
                                $donneesB[i]['pays'] +
                                "</span></h4>" +
                                "<h4>Regions: <span class='infos'>" +
                                $donneesB[i]['region'] +
                                "</span></h4>" +
                                "<p>Description: <span class='infos'>" +
                                $donneesB[i]['description'] +
                                "</span><p>" +
                                "</div>" +
                                "</div>" +
                                "<div class='fonctionBouteille'>" +
                                // <!--Formuliare pour modifier une bouteille -->
                                "<form action='modifications' method='POST'>" +
                                "<input type='hidden' class='idBouteille' name='idBouteille' value='" + 
                                $donneesB[i]['id'] + 
                                "'><button type='submit'>Modifier</button></form>" +
                                // <!--Formuliare pour supprimer une bouteille -->
                                "<form action='supprimer_post.php' method='POST' onsubmit='return confirm" + 
                                "(\"Etes-vous sur de vouloir supprimer? Si vous cliquez sur OK la bouteille serat definitivement supprimé\");'>" +
                                "<input type='hidden' class='idBouteille' name='idBouteille' value='" + 
                                $donneesB[i]['id'] +
                                "'><button type='submit'>Supprimer</button></form>" +
                                "</div>" +
                                "</div>");
                        } 

                        }
                        else{

                            $('.mesBouteilles').empty();
                            $('.paging').empty();

                            for(i=0; $donneesB.length > i; i++) {
                            
                            $('.mesBouteilles').append(
                                "<div class='uneBouteille'>" + 
                                "<div class='titre'>" + 
                                "<h3>" + 
                                $donneesB[i]['nom'] +' '+ $donneesB[i]['annee'] + 
                                "</h3>" + 
                                "</div>" + 
                                "<div class='blocPhotoTexte'>" +
                                "<div class='photoBouteille'>" +
                                "<img class='image' src='images_items/" +
                                $donneesB[i]['image'] +
                                "'></div>" +
                                "<div class='texteBouteille'>" +
                                "<h4>Raisins: <span class='infos'>" +
                                $donneesB[i]['raisins'] +
                                "</span></h4>" +
                                "<h4>Pays: <span class='infos'>" +
                                $donneesB[i]['pays'] +
                                "</span></h4>" +
                                "<h4>Regions: <span class='infos'>" +
                                $donneesB[i]['region'] +
                                "</span></h4>" +
                                "<p>Description: <span class='infos'>" +
                                $donneesB[i]['description'] +
                                "</span><p>" +
                                "</div>" +
                                "</div>" +
                                "<div class='fonctionBouteille'></div>" +
                                "</div>");
                        }

                        };
                            
                   }
               }

           });
   
       return false;
   });
 
    //++++++++++++++++++++++++++++++++++++++++
    //fonction ajax pour formulaire de contact
    //++++++++++++++++++++++++++++++++++++++++
    $("#contact").submit(function() {
         $("#feedback").empty();
        //recupération des données du formulaire
        var name    = $("#name").val();
        var email   = $("#email").val();
        var message = $("#subject").val();

        $.post(
            "contact_post.php",
            {
                name: name,
                email: email,
                message: message
                
            },
            function(data){
                if(data.error == true) {
                    $("#feedback").append(data.message);
                }
                else { 
                    $("#feedback").append(data.message);
                    $("#contact").remove();
                    // $('#succes').attr('src', 'https://www.reactiongifs.com/r/vhpy.gif');
                }
            },
            'json'

        );
    
        return false;
    });

});
})(jQuery);