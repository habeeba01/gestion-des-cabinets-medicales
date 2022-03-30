
<?php 
	require '../communs/config.php';

	 //Si l'utilisateur n'a pas de sessions user et pwd créees -> Redirection pour se connecter
	session_start();
	if (!isset($_SESSION['user']) && !isset($_SESSION['pwd'])) {
	    header("Location: ../index.php?warning=Vous devez vous connecter pour accéder à cette page !");
	   exit;
	}
?>

<?php
//Si tout les champs sont remplis
if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['adresse']) && isset($_POST['civilite']) && isset($_POST['dateNaissance']) && isset($_POST['lieuNaissance']) && isset($_POST['adresse']) && isset($_POST['ville']) && isset($_POST['codePostal']) && isset($_POST['numeroSC']) && strlen($_POST['numeroSC']) == 15 && strlen($_POST['codePostal']) == 5){
	
	//PREPARATION DES REQUETES
	$requete = $BDD->prepare("UPDATE usager SET nom=:nom, prenom = :prenom, civilite = :civilite, dateNaissance = :dateNaissance, lieuNaissance = :lieuNaissance, adresse = :adresse, ville = :ville, codePostal = :codePostal, numeroSC = :numeroSC, id_medecin = :medecin_referent WHERE id_usager = :id");

	if(empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['adresse']) || empty($_POST['civilite']) || empty($_POST['dateNaissance']) || empty($_POST['lieuNaissance']) || empty($_POST['adresse']) || empty($_POST['ville']) || empty($_POST['codePostal'])){

		header("Location: rechercheUsager.php?warning=Veuillez remplir tous les champs requis ! ");
	}


	//Si aucuns champs n'est vide
	if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['adresse']) && !empty($_POST['civilite']) && !empty($_POST['dateNaissance']) && !empty($_POST['lieuNaissance']) && !empty($_POST['adresse']) && !empty($_POST['ville']) && !empty($_POST['codePostal'])){

		// SI L'USAGER NE DETIENT PAS DE MEDECIN REFERENT
		if ($_POST['medecin_referent'] == "") {
			try{
				$requete->execute(array('id' => $_GET['id'],
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

					header("Location: rechercheUsager.php?success=L'usager $_POST[nom] $_POST[prenom] à bien été modifé !");

			}catch(Exception $e){
				echo 'Erreur de la requête de modification d\'un usager : ', $e->getMessage();
			}

			}else{
				// SI l'USAGER DETIENT UN MEDECIN REFERENT
				try{
					$requete->execute(array('id' => $_GET['id'],
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
					header("Location: rechercheUsager.php?success=L'usager $_POST[nom] $_POST[prenom] à bien été modifé !");

				}catch(Exception $e){
					echo 'Erreur de la requête de modification d\'un usager : ', $e->getMessage();
				}
			}
	}

		
}
?>


<?php

	require "../communs/header.php"; 

	$formulaire = $BDD->prepare("SELECT * FROM usager WHERE id_usager = :id");
	try{
		$formulaire->execute(array('id' => $_GET['id']));
	}catch(Exception $e){
		echo 'Erreur de la requête de récupération d\'un usager : ', $e->getMessage();
	}

	while ($data = $formulaire->fetch()) {
?>
	<html>
		<form method="Post" action="">
			<div class="shadow p-3 mb-5 bg-white rounded">
	      		<h2 align="center"> Modificiation d'un usager </h2>
	  		</div>
	  		<div class="shadow p-3 mb-5 bg-white rounded">
			   <center><p>
				   <div class="form-group">
				   		<b>Nom  :</b> <input type="text" name="nom" id="nom" value="<?php echo $data['nom'];?>" />
				   		<b>Prénom :</b> <input type="text" name="prenom" id="prenom" value="<?php echo $data['prenom'];?>"/>
		           </div>

		       	   <div class="form-group">
		           		<b>Date de naissance :</b> <input type="date" name="dateNaissance" id="dateNaissance" value="<?php echo $data['dateNaissance'];?>"/>
		           </div>

		           <div class="form-group">
		           		<b>Lieu de naissance :</b> <input type="text" name="lieuNaissance" id="lieuNaissance" value="<?php echo $data['lieuNaissance'];?>"/>
		           </div>

		           <div class="form-group">
		           		<b>Adresse :</b> <input type="text" name="adresse" id="adresse" value="<?php echo $data['adresse'];?>"/>
		           </div>

		           <div class="form-group">
		           		<b>Ville :</b> <input type="text" name="ville" id="ville" value="<?php echo $data['ville'];?>"/>
		           </div>

		           <div class="form-group">
		           		<b>Code Postal :</b> <input type="text" name="codePostal" id="Codepostal" value="<?php echo $data['codePostal'];?>"/>
		           </div>

		           <div class="form-group">
		           		<b>Numero Sécurité sociale :</b> <input type="number" name="numeroSC" id="numeroSC" maxlength="15" value="<?php echo $data['numeroSC'];?>"/>
		           </div>

		           <div class="form-group">
		           		<b>Médecin réferent :</b>
		           		<?php require 'choixMedecin.php'; ?>
		           </div>

		           <div class="form-group">
				       <?php
				       if($data['civilite'] == "H"){
					       echo'<input type="radio" id="civilite" name="civilite" value="H" checked> <label for="H">Monsieur</label> ';
	           			   echo'<input type="radio" id="civilite" name="civilite" value="F"> <label for="F">Madame</label> ';
			       	   }else{
						   echo'<input type="radio" id="civilite" name="civilite" value="H"> <label for="H">Monsieur</label> ';
	           			   echo'<input type="radio" id="civilite" name="civilite" value="F" checked> <label for="F">Madame</label>';
			       	   }?>
		       	   </div>

			       <div class="form-group">
	               		<input type="submit" value="Modifier" class="btn btn-outline-success">   <input type="reset" value="Vider" id="reset" class="btn btn-outline-danger">
	        	   </div>
			   </p>
			</div>
		</form>
	</html>
<?php
}

?>


