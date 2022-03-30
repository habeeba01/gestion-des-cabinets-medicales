<?php
	require '../communs/config.php';
	 
	// SI TOUT LE FORMULAIRE EST REMPLI
	if(isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['prenom']) && !empty($_POST['prenom']) && isset($_POST['civilite']) && preg_match('~^[a-zA-ZÀ-ÖØ-öø-ÿœŒ]+$~u', $_POST['nom']) && preg_match('~^[a-zA-ZÀ-ÖØ-öø-ÿœŒ]+$~u', $_POST['prenom'])){ 
		//pregmatch vérifie que nom et prenom peut contenir toutes les lettres et lettre du supplément latin-1
		
		//PREPARATION DES REQUETES
		$requete = $BDD->prepare('INSERT INTO medecin(id_medecin, nom, prenom, civilite) VALUES(:id, :nom, :prenom, :civilite)');
		$verification = $BDD->prepare('SELECT COUNT(*) FROM medecin WHERE prenom = ? AND nom = ?');

		try{ 
			$verification->execute(array($_POST['prenom'], $_POST['nom']));
		}catch(Exception $e){
			echo 'Erreur de la requête de vérification si un médecin est déjà existant : ', $e->getMessage(); //Affiche l'erreur lié à la requête
		}

		//VERIFIE SI LE CONTACT EXISTE DEJA
		if ($verification->fetchColumn() != 0) {
			header("Location: FormulaireMedecin.php?warning=Le médecin $_POST[nom] $_POST[prenom] est déjà inscrit !");;
		}else{
				try{
					$requete->execute(array('id' => NULL,
									'nom' => $_POST['nom'],
									'prenom' => $_POST['prenom'],
									'civilite' => $_POST['civilite']));
				}catch(Exception $e){
					echo 'Erreur de la requête ajout médecin : ', $e->getMessage(); //Affiche l'erreur lié à la requête
				}

			header("Location: FormulaireMedecin.php?success=Le médecin $_POST[nom] $_POST[prenom] à bien été ajouté !"); //Medecin ajouté -> Redirection + message succès
		}

	}else{

		if(!preg_match('~^[a-zA-ZÀ-ÖØ-öø-ÿœŒ]+$~u', $_POST['nom']) || !preg_match('~^[a-zA-ZÀ-ÖØ-öø-ÿœŒ]+$~u', $_POST['prenom'])){ //si contient autre que lettre et lettre supplément latin-1
			header("Location: FormulaireMedecin.php?warning=Le nom ou prénom ne doit pas comporter de chiffre ! ");
		}else{
			header("Location: FormulaireMedecin.php?warning=Le nom ou prénom contient des valeurs interdites ! "); //Si le nom/prénom contient des chiffres ou valeurs interdite -> Redirection + message erreur
		}

	}

?>
