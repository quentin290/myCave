<?php

$name = strip_tags(trim($_POST['name']));
$email = strip_tags(trim($_POST['email']));
$subject = strip_tags(trim($_POST['message']));

if (!isset($name) || empty($name)) {

    $msg_error = "Merci de renseigner un nom";

}
elseif(strlen($name) < 3){

    $msg_error = "Merci de saisir au moins trois caractéres";

}
elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)) {

    $msg_error = "Merci de renseigner un email valide";

}
elseif (!isset($subject) || empty($subject)) {

    $msg_error = "Merci de renseigner un sujet";

}
elseif(strlen($subject) < 20){

    $msg_error = "Merci de saisir au moins vingt caractéres";
    
}

else{

    $entete  = 'MIME-Version: 1.0' . "\r\n";
    $entete .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $entete .= 'From: ' . $email . "\r\n";

    $message = '<h2>Message envoyé depuis la page Contact de myCave.com/</h2>
    <b>Nom : </b>' . $name . '</p>
    <p><b>Email : </b>' . $email . '<br>
    <b>Sujet : </b>' . $subject  . '<br>';
    

    $retour = mail('quentin.brisset290@gmail.com', 'Envoi depuis page Contact', $message, $entete);
    
    if($retour) {
        $msg_success = "Votre message a été envoyé avec succès!";
    }
    else {
        $msg_error = "Votre message n\'a pas pu être envoyé!";
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