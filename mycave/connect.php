<?php
try{
	$bdd = new PDO('mysql:host=sql306.byethost7.com;dbname=b7_25856073_projet_my_cave;charset=utf8','b7_25856073','29051987qkbz');
}
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());
}