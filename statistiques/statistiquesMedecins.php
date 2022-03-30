<?php
session_start();
require '../communs/config.php';

/* Fonction pour recomposer des secondes en un temps */
function secondes_en_temps($secondes) {
	$h = floor($secondes / 3600); //Fonction floor arrondi à l'entier inférieur
	$m = floor(($secondes % 3600) / 60); //Fonction floor arrondi à l'entier inférieur
	return sprintf('%d h %02d min', $h, $m); //sprint f retourne une chaîne formatée - $02d pour obtenir par ex : 09min et pas 9min
}


$statsMedecins = $BDD->prepare("SELECT m.civilite, m.nom, m.prenom, SUM(TIME_TO_SEC(c.dureeConsultation)) as totalSecondes
FROM medecin m, consultation c
WHERE c.id_medecin = m.id_medecin
GROUP BY m.civilite, m.nom, m.prenom");

require '../communs/header.php';
?>

<html>
<title>Statistiques médecins</title>
<meta charset="utf-8">
<div class="shadow p-3 mb-5 bg-white rounded">
	<h2 align="center"> Répartition des consultations effectuées par chaque médecin</h2>
</div>

<div class="shadow p-3 mb-5 bg-white rounded">
	<table class="table table-bordered table-hover table-striped">
		<thead>
	        <tr class=bg-info>
	        	<th style="color: white">Nom </th>
	            <th style="color: white">Prénom </th>
	            <th style="color: white">Nombres d'heure totales </th>
	        </tr>
	    </thead>
	    <tbody>
			<?php
			
			try{
				$statsMedecins->execute(null);
			}catch(Exception $e){
				echo 'Erreur de récupération des statistiques des médecins : ', $e->getMessage(); //Affiche l'erreur lié à la requête
			}

			$resultats = $statsMedecins->fetchAll(); //Resultat contient un tableau de toutes les lignes du jeu d'enregistrement de la requête statsMedecins
			 foreach ($resultats as $res) { //Affiche les valeurs dans un tableau
			 	$heures = secondes_en_temps($res['totalSecondes']);
			 	echo "<tr>";
			    echo "<td>$res[nom]</td>";
			    echo "<td>$res[prenom]</td>";
			    echo "<td>$heures</td>";
			    echo "<br />";
			}?>
		</tbody>
</div>