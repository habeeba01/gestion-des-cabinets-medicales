<?php
	require '../communs/config.php';

	if (isset($_GET['id'])) { //Si l'url coontient un GET de nom ID
		$id = $_GET["id"];

		try{
			$req = $BDD->query("DELETE FROM usager WHERE id_usager = $id");
		}catch(Exception $e){
			echo 'Erreur de la requête de suppréssion d\'un usager : ', $e->getMessage(); //Affiche l'erreur lié à la requêt
		}

		header('Location: rechercheUsager.php?success=Usager supprimé avec succès ! '); //L'usager est supprimé -> Redirection avec message succès
	}

?>
