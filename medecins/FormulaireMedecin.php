<?php
  session_start();
  
  //Si l'utilisateur n'a pas de sessions user et pwd créees -> Redirection pour se connecter
  if (!isset($_SESSION['user']) && !isset($_SESSION['pwd'])) {
      header("Location: ../index.php?warning=Vous devez vous connecter pour accéder à cette page !");
      exit;
  }
?>
<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8">
      <title> Ajout d'un médecin </title>
  </head>
  <body>
    <?php require "../communs/header.php"; ?>
    <form method="Post" action="ajouterMedecin.php">
      <div class="shadow p-3 mb-5 bg-white rounded">
        <h2 align="center"> Ajout d'un médecin </h2>
      </div>
      <br />
        <center><p>
             <div class="shadow p-3 mb-5 bg-white rounded" style="width: 50%;">

              <div class="form-group">
                  <b>Nom  :</b> <input type="text" name="nom" id="nom"/>
              </div>

              <div class="form-group">
                  <b>Prénom :</b> <input type="text" name="prenom" id="prenom"/>
              </div>

              <div class="form-group">
                 <b>Civilité  :</b>
                 <input type="radio" id="civilite" name="civilite" value="H" checked> <label for="H">Monsieur</label> 
                 <input type="radio" id="civilite" name="civilite" value="F" checked> <label for="F">Madame</label>
              </div>

              <div class="form-group">
                <input type="submit" value="Envoyer" class="btn btn-outline-success">
                <input type="reset" value="Vider" id="reset" class="btn btn-outline-danger">
             </div>
            </div>
            </p>
    </form>
  </body>
</html>