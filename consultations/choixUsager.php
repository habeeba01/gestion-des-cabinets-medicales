<?php
    
    /* ChoixUsager sert à établir la liste des differents usager connu dans la BDD dans un <SELECT> */

    require '../communs/config.php';

    try{
        $selection_usager = $BDD->query('SELECT id_usager, nom, prenom FROM usager');
    }catch(Exception $e){
        echo 'Erreur de la requête de séléction d\' un médecin : ', $e->getMessage();
    }
    $resultat = $selection_usager->fetchAll();

    $getter = $_GET['id_usager'];

    if(!empty($getter)){

         try{
            $selection_usager2 = $BDD->query('SELECT id_usager, nom, prenom FROM usager WHERE '.$getter.' LIKE id_usager');
         }catch(Exception $e){
            echo 'Erreur de la requête de séléction d\' un médecin : ', $e->getMessage();
         }
         
         $resultat2 = $selection_usager2->fetchAll();

        echo '<select name="usager_referent" id="usager_referent">';
        foreach ($resultat2 as $val) {
            echo "<option value=$val[id_usager]>";
            echo "$val[nom]";
            echo "      ";
            echo "$val[prenom]";;
            echo "</option>";
        }

        echo "<option value=''> ---- Autre usagers ---</option>";
        
        foreach ($resultat as $valeur) {
            echo "<option value=$valeur[id_usager]>";
            echo "$valeur[nom]";
            echo "      ";
            echo "$valeur[prenom]";
            echo "</option>";
        }

        echo "</select>";

    }else{

        echo '<select name="usager_referent" id="usager_referent">';

        foreach ($resultat as $valeur) {
            echo "<option value=$valeur[id_usager]>";
            echo "$valeur[nom]";
            echo "      ";
            echo "$valeur[prenom]";
            echo "</option>";
        }

        echo "</select>";

    }

?>
