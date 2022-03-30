<?php
	 /* choixMedecin sert à établir la liste des differents médecins connu dans la BDD dans un <SELECT> */
 	require '../communs/config.php';

    try{
        $selection_medecin = $BDD->query('SELECT id_medecin, nom, prenom FROM medecin');
    }catch(Exception $e){
        echo 'Erreur de la requête de séléction d\' un médecin : ', $e->getMessage();
    }
    $resultat = $selection_medecin->fetchAll();

    $getter = $_GET['id_medecin'];

    if(!empty($getter)){

         try{
            $selection_medecin2 = $BDD->query('SELECT id_medecin, nom, prenom FROM medecin WHERE '.$getter.' LIKE id_medecin');
         }catch(Exception $e){
            echo 'Erreur de la requête de séléction d\' un médecin : ', $e->getMessage();
         }
         
         $resultat2 = $selection_medecin2->fetchAll();

        echo '<select name="medecin_referent" id="medecin_referent">';
        foreach ($resultat2 as $val) {
            echo "<option value=$val[id_medecin]>";
            echo "Dr.$val[nom]";;
            echo "</option>";
        }

        echo "<option value=''> ---- Autre médecins ---</option>";
        foreach ($resultat as $valeur) {
            echo "<option value=$valeur[id_medecin]>";
            echo "Dr.$valeur[nom]";
            echo "</option>";
        }

        echo "</select>";

    }else{

        echo '<select name="medecin_referent" id="medecin_referent">';
        foreach ($resultat as $valeur) {
            echo "<option value=$valeur[id_medecin]>";
            echo "Dr.$valeur[nom]";
            echo "</option>";
        }

        echo "</select>";

    }

?>
