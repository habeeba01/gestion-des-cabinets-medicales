<html>
	<?php 
		session_start();

		//Si l'utilisateur n'a pas de sessions user et pwd créees -> Redirection pour se connecter
		if (!isset($_SESSION['user']) && !isset($_SESSION['pwd'])) {
				header("Location: ../index.php?warning=Vous devez vous connecter pour accéder à cette page !");
				exit;
		}
	?>
<head>
	<title>Recherche de médecin</title>
	<style type="text/css">
		table, td, tr { border: 1px solid black; border-collapse: separate;  } /* Mettre ligne */
	</style>
</head>
<?php require '../communs/header.php' ?>
	<fieldset>
		<div class="shadow p-3 mb-5 bg-white rounded">
        	<h2 align="center"> Recherche d'un médecin </h2>
      	</div>

        <div class="form-group"><i>/!\ Pour obtenir tous les médecins existant, laissez les espaces vides et cliquez sur envoyer /!\</i></div>

		<form method="Post" action="">
			<div class="shadow p-3 mb-5 bg-white rounded">
			    <center><p>
			       <div class="form-group">
				       <b>Mot clef :</b> <input type="text" name="rechercher" id="rechercher"/>
				   </div>
				   <div class="form-group">
			       	 	<input type="submit" value="Envoyer" class="btn btn-outline-success">    <input type="reset" value="Vider" id="reset" class="btn btn-outline-danger">
			       </div>
			    </p>
			</div>
		</form>
	</fieldset>
</center>
</html>




<?php

 require '../communs/config.php';
if(isset($_POST['rechercher'])){ // si le champs rechercher est rempli
		$recherche = $_POST['rechercher'];
		
		try{
			$requete = $BDD->query("SELECT * FROM medecin WHERE prenom LIKE '%$recherche%' OR nom LIKE '%$recherche%'");
		}catch(Exception $e){
			echo 'Erreur de la requête de recherche d\'un médecin : ', $e->getMessage(); //Affiche l'erreur lié à la requête
		}

		if($requete->rowCount()>0) //Si le nombre de ligne de la requête est supérieur à 0 -> Afficher le tableau avec les valeurs 
		{
			echo '<div class="alert alert-success" role="alert" style="width:20%;">Nombre de résultats : '.$requete->rowCount().'</div>';
		  while($data = $requete->fetch(PDO::FETCH_BOTH))
		  {
		  	echo'<table class="table table-bordered table-hover table-striped "><tr><h3><center>';
			echo '<td style="width:25%;"><b>Nom </b> : '.$data["nom"].' </td>';
			echo '<td style="width:25%;"><b>Prenom </b>: '.$data["prenom"].' </td>';
			echo '<td style="width:25%;"><b> Civilité </b> : '.$data["civilite"].' </td>';
			echo'<td style="width:10%;"><a href="modificationMedecin.php?id='.$data['id_medecin'].'"><button type="button" class="btn btn-warning">Modifier</button></a></td>';
			echo'<td style="width:10%;"><a href="suppressionMedecin.php?id='.$data['id_medecin'].'"><button type="button" class="btn btn-danger">Supprimer</button></a></td>';
			echo "</center></h3></tr></table>\n\n";


		  }
		  echo('</tr>');
		 $requete->closeCursor();
		}
	else
	{
	  echo '<div class="alert alert-warning" role="alert" style="width:20%;">Il y a aucun resultat</div>';
	}

}

 ?>