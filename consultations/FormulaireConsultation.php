<?php
  require '../communs/config.php';
  session_start();
   //Si l'utilisateur n'a pas de sessions user et pwd créees -> Redirection pour se connecter
  if (!isset($_SESSION['user']) && !isset($_SESSION['pwd'])) {
      header("Location: ../index.php?warning=Vous devez vous connecter pour accéder à cette page !");
      exit;
  }
?>
<html>
    <head>
        <meta charset="utf-8">
        <title> Ajout d'une consultation </title>
    </head>
    <body>
      <?php require "../communs/header.php";?>
      <form method="Post" action="ajouterConsultation.php">
        <div class="shadow p-3 mb-5 bg-white rounded">
          <h2 align="center"> Ajout d'une consultation </h2>
        </div>
         <center><p>
            <div class="shadow p-3 mb-5 bg-white rounded" style="width: 50%;">
              <div class="form-group">
                 <b>Client  :</b> 
                   <?php
                      //Récupère la liste des usagers connu dans la BDD et les places dans un <SELECT>
                      try{
                          $selection_usager = $BDD->query('SELECT id_usager, nom, prenom FROM usager');
                      }catch(Exception $e){
                          echo 'Erreur de la requête de sélection des usagers', $e->getMessage();
                      }
                      
                      $resultat = $selection_usager->fetchAll();
                      echo '<select name="usager_referent" id="usager_referent">';
                      foreach ($resultat as $valeur) {
                        echo "<option value=$valeur[id_usager]>";
                        echo "$valeur[nom]";
                        echo "   ";
                        echo "$valeur[prenom]";
                        echo "</option>";
                      }
                      echo "</select>";
                    ?>
                 <br />
              </div>
              <div class="form-group">
                 <b>Médecin consultant :</b> 
                 <?php
                      //Récupère la liste des médecins connu dans la BDD et les places dans un <SELECT>
                    try{
                        $selection_medecin = $BDD->query('SELECT id_medecin, nom, prenom FROM medecin');
                    }catch(Exception $e){
                        echo 'Erreur de la requête de sélection des médecins', $e->getMessage();
                    }
                    
                    $resultat = $selection_medecin->fetchAll();
                    echo '<select name="medecin_referent" id="medecin_referent">';
                    foreach ($resultat as $valeur) {
                      echo "<option value=$valeur[id_medecin]>";
                      echo "Dr.$valeur[nom]";
                      echo "</option>";
                    }
                    echo "</select>";
                  ?>
                 <br />
              </div>
              <div class="form-group">
                 <b>Date de consultation :</b> <input type="date" name="dateConsultation" id="dateConsultation"/>
                 <br />
              </div>
              <div class="form-group">
                 <b>Heure de consultation :</b> <input type="time"  name="heureConsultation" id="heureConsultation" min="08:00" max="18:00" required/>
                 <br />
              </div>
              <div class="form-group">
                 <b>Durée de la consultation :</b> <input type="time" name="dureeConsultation" id="dureeConsultation" required/>
              </div>
              <div class="form-group">
                  <input type="submit" value="Envoyer" class="btn btn-outline-success">  <input type="reset" value="Vider" id="reset" class="btn btn-outline-danger">
              </div>
            </div>
         </p></center>
      </form>
    </body>
</html>
