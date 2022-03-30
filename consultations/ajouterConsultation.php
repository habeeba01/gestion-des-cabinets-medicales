<?php

	 require '../communs/config.php';

	//REGARDE SI TOUT LE FORMULAIRE EST REMPLI

	if(isset($_POST['usager_referent']) && isset($_POST['medecin_referent']) && isset($_POST['dateConsultation']) && isset($_POST['heureConsultation']) && isset($_POST['dureeConsultation']) && !empty($_POST['dateConsultation'])){
		
		//PREPARATION DES REQUETES

		$requete = $BDD->prepare('INSERT INTO consultation(id_medecin, id_usager, dateConsultation, heureConsultation, dureeConsultation) VALUES(:id_medecin, :id_usager, :dateConsultation, :heureConsultation, :dureeConsultation)');

		$verification = $BDD->prepare('SELECT COUNT(*) FROM consultation WHERE id_medecin = ? AND id_usager = ? AND heureConsultation = ? OR dateConsultation = ?');

		try{
			$verification->execute(array($_POST['usager_referent'], $_POST['medecin_referent'], $_POST['heureConsultation'], $_POST['dateConsultation']));
		}catch(Exception $e){
			echo 'Erreur de la requête de vérification si une consultation est déjà existante', $e->getMessage(); //Affiche l'erreur lié à la requête
		}

		//VERIFIE SI LE CONTACT EXISTE DEJA

		if ($verification->fetchColumn()>0) {
			header('Location: FormulaireConsultation.php?warning=Consultation déjà existante !'); //Redirection car la coonsultation est déjà existante

		}
		else{

			try{
				$requete->execute(array('id_medecin' => $_POST['medecin_referent'],
									'id_usager' => $_POST['usager_referent'],
									'dateConsultation' => $_POST['dateConsultation'],
									'heureConsultation' => $_POST['heureConsultation'],
								    'dureeConsultation' => $_POST['dureeConsultation']));
			}catch(Exception $e){
				echo 'Erreur de la requête ajout consultation', $e->getMessage();
			}

			header('Location: rechercherConsultations.php?success=Consultation créer avec succès !'); //Consultation crées -> Redirection + message succès
		}

	}
	else{
		if(empty($_POST['dateConsultation'])){ //Si la date de Consultationn n'est pas renseigné
			header("Location: ../consultations/FormulaireConsultation.php?warning=Veuillez choisir une date de consultation !"); //Redirection + message erreur
		}else{
			header("Location: ../consultations/FormulaireConsultation.php?error=Erreur ajout consultation"); //Redirection + message erreur
		}
		
	}


?>
