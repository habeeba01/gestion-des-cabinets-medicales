
<?php
session_start();
require '../communs/header.php';
require '../communs/config.php';

$statsUsagers = $BDD->prepare("SELECT
(
    SELECT COUNT(*)/(SELECT COUNT(*) FROM usager)*100
    FROM usager
    WHERE civilite = 'H'
    AND DATEDIFF(CURDATE(), dateNaissance) < 25*365.25
) as nbHommesMoins25ans,
(
    SELECT COUNT(*)/(SELECT COUNT(*) FROM usager)*100
    FROM usager
    WHERE civilite = 'F'
    AND DATEDIFF(CURDATE(), dateNaissance) < 25*365.25
) as nbFemmesMoins25ans,
(
    SELECT COUNT(*)/(SELECT COUNT(*) FROM usager)*100
    FROM usager
    WHERE civilite = 'H'
    AND DATEDIFF(CURDATE(), dateNaissance) >= 25*365.25
    AND DATEDIFF(CURDATE(), dateNaissance) <= 50*365.25
) as nbHommesEntre25ansEt50ans,
(
    SELECT COUNT(*)/(SELECT COUNT(*) FROM usager)*100
    FROM usager
    WHERE civilite = 'F'
    AND DATEDIFF(CURDATE(), dateNaissance) >= 25*365.25
    AND DATEDIFF(CURDATE(), dateNaissance) <= 50*365.25
) as nbFemmesEntre25ansEt50ans,
(
    SELECT COUNT(*)/(SELECT COUNT(*) FROM usager)*100
    FROM usager
    WHERE civilite = 'H'
    AND DATEDIFF(CURDATE(), dateNaissance) >= 50*365.25
) as nbHommesPlus50ans,
(
    SELECT COUNT(*)/(SELECT COUNT(*) FROM usager)*100
    FROM usager
    WHERE civilite = 'F'
    AND DATEDIFF(CURDATE(), dateNaissance) > 50*365.25
) as nbFemmesPlus50ans");
 
?>

<html>
<title>Statistiques usagers</title>
<div class="shadow p-3 mb-5 bg-white rounded">
	<h2 align="center"> Répartition des usagers selon le sexe et l'âge </h2>
</div>

<div class="shadow p-3 mb-5 bg-white rounded">
	<table class="table table-bordered table-hover table-striped">
		<thead>
	        <tr class=bg-info>
	        	<th style="color: white">Tranches d'âge </th>
	            <th style="color: white">Nombre d'hommes </th>
	            <th style="color: white">Nombre de femmes </th>
	        </tr>
	    </thead>
	    <tbody>

			<?php
				try{
					$statsUsagers->execute(null);
				}
				catch(Exception $e){
					echo 'Erreur de la requête pour obtenir les stats des usagers', $e->getMessage(); //Affiche l'erreur lié à la requête
				}
				
				$res = $statsUsagers->fetchAll()['0'];  //Resultat contient un tableau de toutes les lignes du jeu d'enregistrement de la requête statsUsagers

			 	echo "<tr>";
				    echo "<th>Moins de 25 ans</th>";
					    echo '<td> '.round($res['nbHommesMoins25ans'],1).' %'; //round affiche la valeur rentrée en paramètre 1 chiffre après la virgule
					    echo '<td> '.round($res['nbFemmesMoins25ans'],1).' %';
			    echo "</tr>";

			    echo "<tr>";
				    echo "<th>Entre 25 ans et 50 ans </th>";
					    echo '<td> '.round($res['nbHommesEntre25ansEt50ans'],1).' %';
					    echo '<td> '.round($res['nbFemmesEntre25ansEt50ans'],1).' %';
			    echo "</tr>";

			    echo "<tr>";
				    echo "<th> Plus de 50 ans </th>";
					    echo '<td> '.round($res['nbHommesPlus50ans'],1).' %';
					    echo '<td> '.round($res['nbFemmesPlus50ans'],1).' %';
			    echo "</tr>";
			?>

		</tbody>
</div>