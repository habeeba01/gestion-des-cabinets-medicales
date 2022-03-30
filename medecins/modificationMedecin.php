<?php
	require '../communs/config.php';

	session_start();
	
	//Si l'utilisateur n'a pas de sessions user et pwd créees -> Redirection pour se connecter
	if (!isset($_SESSION['user']) || !isset($_SESSION['pwd'])) {
	    header("Location: ../index.php?warning=Vous devez vous connecter pour accéder à cette page !");
	    exit;
	}
?>

<?php

	require "../communs/header.php";

	$formulaire = $BDD->prepare("SELECT * FROM medecin WHERE id_medecin = :id");
	try{
		$formulaire->execute(array('id' => $_GET['id']));
	}catch(Exception $e){
		echo 'Erreur de la requête de récupération de l\'id d\'un médecin : ', $e->getMessage(); //Affiche l'erreur lié à la requête
	}

	while ($data = $formulaire->fetch()) {
?>
	<html>
		<form method="Post" action="">
					<div class="shadow p-3 mb-5 bg-white rounded">
		        		<h2 align="center"> Modification d'un médecin </h2>
		      		</div>
		      	   <div class="shadow p-3 mb-5 bg-white rounded">
					   <center><p>
					   	<div class="form-group">
					       <b>Nom  :</b> <input type="text" name="nom" id="nom" value="<?php echo $data['nom'];?>" />
					    </div>

					    <div class="form-group">
					       <b>Prenom :</b> <input type="text" name="prenom" id="prenom" value="<?php echo $data['prenom'];?>"/>
					    </div>

					    <div class="form-group">
					       <b>Civilité  :</b>
					       
					       <?php
					       if($data['civilite'] == "H"){
						       echo'<input type="radio" id="civilite" name="civilite" value="H" checked> <label for="H"> Monsieur </label> ';
					           echo'<input type="radio" id="civilite" name="civilite" value="F"> <label for="F"> Madame</label>';
				       	   }else{
							   echo'<input type="radio" id="civilite" name="civilite" value="H"> <label for="H"> Monsieur </label> ';
					           echo'<input type="radio" id="civilite" name="civilite" value="F" checked> <label for="F"> Madame </label>';
				       	   }
					       ?>
					    </div>

					    <div class="form-group">
					       <input type="submit" value="Modifier" class="btn btn-outline-success">
					       <input type="reset" value="Vider" id="reset" class="btn btn-outline-danger">
					    </div>
				    </div>
				   </p>
			</form>
	</html>
<?php 
}
//REGARDE SI TOUT LE FORMULAIRE EST REMPLI
//var_dump($_GET);
if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['civilite'])){

	//PREPARATION DES REQUETES
	$requete = $BDD->prepare("UPDATE medecin SET nom=:nom, prenom = :prenom, civilite = :civilite WHERE id_medecin = :id");

	// Si le champs nom ou prenom est vide
	if (empty($_POST['nom']) || empty($_POST['prenom'])) {
		header("Location: rechercheMedecin.php?warning=Veuillez remplir tous les champs requis"); //Redirection + message erreur
	}

	// SI les champs prenom et nom ne sont pas vides
	if (!empty($_POST['nom']) && !empty($_POST['prenom'])) {
		try{
			$requete->execute(array('nom' => $_POST['nom'],
								'prenom' => $_POST['prenom'],
								'civilite' => $_POST['civilite'],
								'id' => $_GET['id']));
		}catch(Exception $e){
			echo 'Erreur de la requête de modification d\'un médecin  : ', $e->getMessage(); //Affiche l'erreur lié à la requête
		}
		
		header("Location: rechercheMedecin.php?success=Le médecin $_POST[nom] $_POST[prenom] à bien été modifé !"); //Medecin modifié + message succès

	}
}

?>


