<?php

session_start();
session_destroy();

$referer = 'index.php';

header('Location: ' . $referer);

?>