<?php
	require '../communs/config.php';

	// SI l'url contient un GET de nom id_usager ET de nom id_medecin ET de nom heure
	if (isset($_GET['id_usager']) && isset($_GET['id_medecin']) && isset($_GET['heure'])) {
		$id_medecin = $_GET['id_medecin'];
		$id_usager = $_GET['id_usager'];
		$heure = $_GET['heure'];

		try{
			$req = $BDD->query("DELETE FROM consultation WHERE id_medecin = $id_medecin AND id_usager = $id_usager");
		}catch(Exception $e){
			echo 'Erreur de la requête de suppression de consultation : ', $e->getMessage(); //Affiche l'erreur lié à la requête
		}

		header('Location: rechercherConsultations.php?success=Consultation supprimé avec succès !'); //Consultation crée -> Redirection + message succès
	}

?>
