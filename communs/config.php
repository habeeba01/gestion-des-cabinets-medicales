<?php
//Les différents paramètre à remplir pour se connecter à la Base de Donnée
$server = "localhost";
$user = "root";
$pass = "root";
$db_name = "cabinet_medical";


// CREER LA CONNEXION A LA BASE DE DONNEE
try{
	$BDD = new PDO("mysql:host=$server;dbname=$db_name", $user, $pass);
	//echo "Connexion établie";
}
catch(Exception $e){
	die('Erreur connexion à la base de donnée'); //Si les paramètres données ne sont pas correct pour mener à bien la connexion à la bdd

}


?>
