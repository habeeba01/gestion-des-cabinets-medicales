<?php

  require '../communs/config.php';


 
//REGARDE SI TOUT LE FORMULAIRE EST REMPLI
if(isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['prenom']) && !empty($_POST['prenom']) && isset($_POST['adresse']) && !empty($_POST['adresse']) && isset($_POST['civilite']) && isset($_POST['dateNaissance']) && !empty($_POST['dateNaissance']) && isset($_POST['lieuNaissance']) && !empty($_POST['lieuNaissance']) && isset($_POST['adresse']) && !empty($_POST['adresse']) && isset($_POST['ville']) && !empty($_POST['ville']) && isset($_POST['codePostal']) && !empty($_POST['codePostal']) && isset($_POST['numeroSC']) && !empty($_POST['numeroSC']) && isset($_POST['medecin_referent']) && strlen($_POST['numeroSC']) == 15){
	
	//PREPARATION DES REQUETES
	$requete = $BDD->prepare('INSERT INTO usager(id_usager, nom, prenom, civilite, dateNaissance, lieuNaissance, adresse, ville, codePostal, numeroSC, id_medecin) VALUES(:id, :nom, :prenom, :civilite, :dateNaissance, :lieuNaissance, :adresse, :ville, :codePostal, :numeroSC, :medecin_referent)');
	$verification = $BDD->prepare('SELECT COUNT(*) FROM usager WHERE prenom = ? AND nom = ? AND dateNaissance = ?');
	try{
		$verification->execute(array($_POST['prenom'], $_POST['nom'], $_POST['dateNaissance']));
	}catch(Exception $e){
		echo 'Erreur de la requête de vérification si l\'usager est déjà existant', $e->getMessage(); //Affiche l'erreur lié à la requête
	}


	//VERIFIE SI LE CONTACT EXISTE DEJA
	if ($verification->fetchColumn() != 0) {
		header("Location: FormulaireUsager.php?warning=Impossible ! L'usager est déjà inscrit !");
	}else{
			// SI L'USAGER NE DETIENT PAS DE MEDECIN REFERENT
			if ($_POST['medecin_referent'] == "") {
				try{
					$requete->execute(array('id' => NULL,
								'nom' => $_POST['nom'],
								'prenom' => $_POST['prenom'],
								'civilite' => $_POST['civilite'],
								'dateNaissance' => $_POST['dateNaissance'],
								'lieuNaissance' => $_POST['lieuNaissance'],
								'adresse' => $_POST['adresse'],
								'ville' => $_POST['ville'],
							    'codePostal' => $_POST['codePostal'],
								'numeroSC' => $_POST['numeroSC'],
							    'medecin_referent' => NULL));
				}catch(Exception $e){
					echo 'Erreur de la requête d\'ajout d\'un usager : ', $e->getMessage(); //Affiche l'erreur lié à la requête
				}

			}else{
				// SI l'USAGER DETIENT UN MEDECIN REFERENT
				try{
					$requete->execute(array('id' => NULL,
								'nom' => $_POST['nom'],
								'prenom' => $_POST['prenom'],
								'civilite' => $_POST['civilite'],
								'dateNaissance' => $_POST['dateNaissance'],
								'lieuNaissance' => $_POST['lieuNaissance'],
								'adresse' => $_POST['adresse'],
								'ville' => $_POST['ville'],
							    'codePostal' => $_POST['codePostal'],
								'numeroSC' => $_POST['numeroSC'],
							    'medecin_referent' => $_POST['medecin_referent']));
				}catch(Exception $e){
					echo 'Erreur de la requête d\'ajout d\'un usager : ', $e->getMessage(); //Affiche l'erreur lié à la requête
				}
			}
			
			header("Location: FormulaireUsager.php?success=L'usager $_POST[nom] $_POST[prenom] à bien été ajouté !"); //redirection après l'ajout d'un usager + message
	}

}
else{

		if (strlen($_POST['numeroSC']) != 15) { //Si le numéro de sécurité social est différent de 15 -> Redirection + message d'erreur
			header("Location: FormulaireUsager.php?warning=Impossible ! Le numéro de sécurité social doit faire 15 chiffres !");
		}

		//Si des champs inscrits sont vides -> Redirection + message d'erreur
		elseif (empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['adresse']) || empty($_POST['civilite']) || empty($_POST['dateNaissance']) || empty($_POST['lieuNaissance']) || empty($_POST['adresse']) || empty($_POST['ville']) || empty($_POST['codePostal'])) {

			header("Location: FormulaireUsager.php?warning=Veuillez remplir tous les champs du formulaire !");
		}
	
	 }


?>
