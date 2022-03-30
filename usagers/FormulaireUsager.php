<?php
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
      <title> Ajout d'un usager </title>
  </head>

  <body>
    <?php require "../communs/header.php"; ?>
    <form method="Post" action="ajouterUsager.php">
        <div class="shadow p-3 mb-5 bg-white rounded">
            <h2 align="center"> Ajout d'un usager </h2>
        </div>
        <center>
            <div class="shadow p-3 mb-2 bg-white rounded" style="width: 50%">
              <p class='text-center'>
                  <div class="form-group">
                      <b>Nom  :</b> <input type="text" name="nom" id="nom"/>
                      <b>Prénom :</b> <input type="text" name="prenom" id="prenom"/>
                  </div>

                  <div class="form-group">
                      <b>Date de naissance :</b> <input type="date" name="dateNaissance" id="dateNaissance"/>
                  </div>

                  <div class="form-group">
                     <b>Lieu de naissance :</b> <input type="text" name="lieuNaissance" id="lieuNaissance"/>
                  </div>

                   <div class="form-group">
                      <b>Adresse :</b> <input type="text" name="adresse" id="adresse"/>
                   </div>

                   <div class="form-group">
                      <b>Ville :</b> <input type="text" name="ville" id="ville"/>
                   </div>

                   <div class="form-group">
                      <b>Code Postal :</b> <input type="text" name="codePostal" id="Codepostal" maxlength="5" minlength="5"/>
                   </div>

                   <div class="form-group">
                      <b>Numero Sécurité sociale :</b> <input type="number" name="numeroSC" id="numeroSC" maxlength="15" minlength="15" />
                   </div>

                   <div class="form-group">
                      <b>Médecin réferent :</b> 
                      <?php
        
                          require '../communs/config.php';
                          try{
                            $selection_medecin = $BDD->query('SELECT id_medecin, nom, prenom FROM medecin');
                          }catch(Exception $e){
                            echo 'Erreur de la requête de séléction d\' un médecin : ', $e->getMessage(); //Affiche l'erreur lié à la requête
                          }
                          $resultat = $selection_medecin->fetchAll(); //Resultat contient un tableau de toutes les lignes du jeu d'enregistrement de la requête selection_medecin

                          echo '<select name="medecin_referent" id="medecin_referent">';
                          echo '<option value="">Aucun</option>';
                          foreach ($resultat as $valeur) {
                            echo "<option value=$valeur[id_medecin]>";
                            echo "Dr.$valeur[nom]";
                            echo "</option>";
                          }
                          echo "</select>";
                      ?>
                   </div>

                   <div class="form-group">
                      <b>Civilité  :</b>
                      <input type="radio" id="civilite" name="civilite" value="H" checked> <label for="H">Monsieur</label> 
                      <input type="radio" id="civilite" name="civilite" value="F" checked> <label for="F">Madame</label>
                   </div>

                  <div class="form-group">
                     <input type="submit" value="Envoyer" class="btn btn-outline-success">   <input type="reset" value="Vider" id="reset" class="btn btn-outline-danger">
                  </div>
              </p>
          </div>
        </center>
    </form>
  </body>
</html>