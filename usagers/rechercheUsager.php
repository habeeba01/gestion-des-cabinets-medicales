<html>
	<?php 
		session_start();
		if (!isset($_SESSION['user']) && !isset($_SESSION['pwd'])) {
		    header("Location: ../index.php?warning=Vous devez vous connecter pour accéder à cette page !");
		    exit;
		}
		require "../communs/header.php"; 
	?>
<head>
	<title>Rechercher un usager</title>
</head>
	<fieldset>
		<div class="shadow p-3 mb-5 bg-white rounded">
            <div class="form-group">
          		<h2 align="center"> Recherche d'un usager </h2>
          	</div>
      	</div>

      	<div class="form-group"><i>/!\ Pour obtenir tous les usagers existant, laissez les espaces vides et cliquez sur envoyer /!\</i></div>

      	<form method="Post" action="">
      	   <div class="shadow p-3 mb-5 bg-white rounded">
			   <center><p>
			       <b>Mot clef :</b> <input type="text" name="rechercher" id="rechercher"/>
			       <br />
	               <div class="form-group">
			       		<input type="submit" value="Envoyer" class="btn btn-outline-success"> <input type="reset" value="Vider" id="reset" class="btn btn-outline-danger">
			       </div>
			   </p></center>
		  </div>

		</form>
	</fieldset>
</center>
</html>




<?php

 require '../communs/config.php';
if(isset($_POST['rechercher'])){ // Si le champs rechercher est rempli
		$recherche = $_POST['rechercher'];

		try{
			$requete = $BDD->query("SELECT * FROM usager WHERE nom LIKE '%$recherche%' OR prenom LIKE '%$recherche%' OR lieuNaissance LIKE '%$recherche%' OR adresse LIKE '%$recherche%' OR ville LIKE '%$recherche%' OR codePostal LIKE '%$recherche%'");
		}catch(Exception $e){
			echo 'Erreur de la requête de recherche d\'un usager : ', $e->getMessage(); //Affiche l'erreur lié à la requête
		}

		if($requete->rowCount()>0) //Si le nombre de ligne de la requête est supérieur à 0 -> Afficher le tableau avec les valeurs
		{
			echo '<div class="alert alert-success" role="alert" style="width:20%;">Nombre de résultat : '.$requete->rowCount().'</div>';
		  while($data = $requete->fetch(PDO::FETCH_BOTH))
		  {
		  	echo'<table class="table table-bordered table-hover table-striped"><tr><h3><center>';
			echo "<td><b>Nom</b><br /> $data[nom] </td> ";
			echo "<td><b>Prenom</b><br />  $data[prenom] </td> ";
			echo "<td><b>Civilité</b><br />  $data[civilite] </td>";
			echo '<td><b>Date de naissance</b><br />  '.date("d/m/Y", strtotime($data['dateNaissance'])).' </td>';
			echo "<td><b>Lieu de naissance</b><br />  $data[lieuNaissance] </td>";
			echo "<td><b>Adresse</b><br />  $data[adresse] </td>";
			echo "<td><b>Ville</b><br />  $data[ville] </td>";
			echo "<td><b>Code Postal</b><br />  $data[codePostal] </td>";
			//echo "<td><b>Numero sécurité social</b><br />  $data[numeroSC] </td>"; //Numero social caché normalement c'est une information personnelle
			echo'<td><a href="modificationUsager.php?id='.$data['id_usager'].'&id_medecin='.$data['id_medecin'].'"><button type="button" class="btn btn-warning">Modifier</button></a></td>';
			echo'<td><a href="suppressionUsager.php?id='.$data['id_usager'].'"><button type="button" class="btn btn-danger">Supprimer</button></a></td>';
			echo "</center></h3></tr></table>\n\n";


		  }
		  echo('</tr>');
		 $requete->closeCursor();
		}

		//Si il y a aucun résultat à la recherche
	else
	{
	  echo '<div class="alert alert-warning alert-dismissible fade show" role="alert" style="width:20%;">Il y a aucun resultat</div>';
	}

}
 ?>