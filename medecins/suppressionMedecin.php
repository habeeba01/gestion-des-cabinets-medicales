<?php
	require '../communs/config.php';

	if (isset($_GET['id'])) {
		$id = $_GET["id"];
		try{
			$req = $BDD->query("DELETE FROM medecin WHERE id_medecin = $id");
		}catch(Exception $e){
			echo 'Erreur de la requête de suppréssion d\'un médecin : ', $e->getMessage(); 
		}
		header('Location: rechercheMedecin.php?success=Médecin supprimé avec succès !'); //Medecin supprimé -> Redirection + message succès
	}

?>
