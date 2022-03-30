<html>
<?php 
	session_start();

	require '../communs/config.php';

	if (!isset($_SESSION['user']) && !isset($_SESSION['pwd'])) {
	    header("Location: ../index.php?warning=Vous devez vous connecter pour accéder à cette page !");
	    exit;
	}
?>
<head>
	<title>Rechercher une consultation</title>
	<style type="text/css">
		table, td, tr { border: 1px solid black; border-collapse: separate;  } /* Mettre ligne */
	</style>
</head>
<?php require '../communs/header.php' ?>
	<fieldset>
		<div class="shadow p-3 mb-5 bg-white rounded">
        	<h2 align="center"> Recherche d'une consultation </h2>
      	</div>

        <div class="form-group"><i>/!\ Pour obtenir toutes les consultations existante, laissez les espaces vides et cliquez sur envoyer /!\</i></div>

		<form method="Post" action="">
			<div class="shadow p-3 mb-5 bg-white rounded">
			    <center><p>
			        <div class="form-group">
                 	   <b>Client :</b> 
                 	   <?php 
                 	   		try{
                 	   			$selection_usager = $BDD->query('SELECT id_usager, nom, prenom FROM usager');
                 	   		}catch(Exception $e){
                 	   			echo 'Erreur de la requête de sélection des usagers : ', $e->getMessage(); //Affiche l'erreur lié à la requête
                 	   		}

						    $resultat = $selection_usager->fetchAll();
						    echo '<select name="usager_referent" id="usager_referent">';
						    echo "<option value='all'>Tous les usagers</options>";
						    foreach ($resultat as $valeur) {
						    	echo "<option value=$valeur[id_usager]>";
						    	echo "$valeur[nom]";
						    	echo "   ";
						    	echo "$valeur[prenom]";
						    	echo "</option>";
						    }
						    echo "</select>";
                 	    ?>
              	   </div>

				   <div class="form-group">
                 	   <b>Médecin consultant :</b> 
                 	   <?php
                 	   		try{
                 	   			$selection_medecin = $BDD->query('SELECT id_medecin, nom, prenom FROM medecin');
                 	   		}catch(Exception $e){
                 	   			echo 'Erreur de la requête de sélection des médecins : ', $e->getMessage(); //Affiche l'erreur lié à la requête
                 	   		}
						    $resultat = $selection_medecin->fetchAll();
						    echo '<select name="medecin_referent" id="medecin_referent">';
						    echo "<option value='all'>Tous les médecins</option>";
						    foreach ($resultat as $valeur) {
						    	echo "<option value=$valeur[id_medecin]>";
						    	echo "Dr.$valeur[nom]";
						    	echo "</option>";
						    }
						    echo "</select>";
                 	   ?>
              	   </div>

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
 if(isset($_POST['rechercher'])){
		$recherche = $_POST['rechercher'];
		try{
			$requete = $BDD->query("SELECT * FROM consultation WHERE heureConsultation LIKE '%$recherche%' OR dureeConsultation LIKE '%$recherche%' ORDER BY dateConsultation DESC, heureConsultation DESC");
		}catch(Exception $e){
			echo 'Erreur de la requête de recherche des consultation connues : ', $e->getMessage();
		}

		if($requete->rowCount()>0)
		{
			echo '<div class="alert alert-success" role="alert" style="width:20%;">Nombre de résultats : '.$requete->rowCount().'</div>';
		  while($data = $requete->fetch(PDO::FETCH_BOTH))
		  {
		  	echo'<table class="table table-bordered table-hover table-striped"><tr><h3><center>';
		  	/****************[USAGER] Récupérer le nom via ID USAGER de la table consultation ******************/
		  	$id_usager = $data["id_usager"];
			$recherche_usagers = $BDD->prepare("SELECT prenom, nom FROM usager WHERE id_usager = :id_usager");

			try{
				$recherche_usagers->execute(array('id_usager' => $id_usager));
			}catch(Exception $e){
				echo 'Erreur de la requête de récupération des usagers', $e->getMessage();
			}

		  	while ($usager = $recherche_usagers->fetch()){
		  		echo '<td style="width:20%;"><b>Client </b> : '.$usager['nom'].' '.$usager['prenom'].' </td>';
		  	}

		  	/****************[MEDECIN] Récupérer le nom via ID USAGER de la table consultation ******************/
		  	$id_medecin = $data["id_medecin"];
			$recherche_medecin = $BDD->prepare("SELECT nom FROM medecin WHERE id_medecin = :id_medecin");

			try{
				$recherche_medecin->execute(array('id_medecin' => $id_medecin));
			}catch(Exception $e){
				echo 'Erreur de la requête de récupération des médecins : ', $e->getMessage();
			}

		  	while ($medecin = $recherche_medecin->fetch()){
		  		echo '<td style="width:20%;"><b>Médecin traitant </b> : Dr.'.$medecin['nom'].'</td>';
		  	}
		  	echo '<td style="width:25%;"><b>Date de la consultation </b> : '.date("d/m/Y", strtotime($data['dateConsultation'])).' </td>';
			echo '<td style="width:20%;"><b>Heure de la consultation </b> : '.$data["heureConsultation"].' </td>';
			echo '<td style="width:25%;"><b>Duree de la consultation </b>: '.$data["dureeConsultation"].' </td>';
			echo'<td style="width:10%;"><a href="modificationConsultation.php?id_usager='.$data['id_usager'].'&id_medecin='.$data['id_medecin'].'&heure='.$data['heureConsultation'].'"><button type="button" class="btn btn-warning">Modifier</button></a></td>';
			echo'<td style="width:10%;"><a href="suppressionConsultation.php?id_usager='.$data['id_usager'].'&id_medecin='.$data['id_medecin'].'&heure='.$data['heureConsultation'].'"><button type="button" class="btn btn-danger">Supprimer</button></a></td>';
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