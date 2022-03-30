<?php
  require '../communs/config.php';

  session_start();

   //Si l'utilisateur n'a pas de sessions user et pwd créees -> Redirection pour se connecter
  if (!isset($_SESSION['user']) || !isset($_SESSION['pwd'])) {
      header("Location: ../index.php?warning=Vous devez vous connecter pour accéder à cette page !");
      exit;
  }

/*********************************************************************************************************/
/***************** CODE PHP AVANT LE HTML CAR PROBLEME DE HEADER SiNON ET DONC DE REDIRECTION ************/
/*********************************************************************************************************/

   //REGARDE SI TOUT LE FORMULAIRE EST REMPLI
  if(isset($_POST['usager_referent']) && isset($_POST['medecin_referent']) && isset($_POST['dateConsultation']) && isset($_POST['heureConsultation']) && isset($_POST['dureeConsultation'])){

    //PREPARATION DES REQUETES
    $requete = $BDD->prepare("UPDATE consultation SET id_usager=:usager_referent, id_medecin = :medecin_referent, dateConsultation = :dateConsultation, heureConsultation = :heureConsultation, dureeConsultation = :dureeConsultation WHERE id_medecin = :id_medecin AND id_usager = :id_usager AND heureConsultation = :verifconsult");

    
    if (empty($_POST['dateConsultation']) || empty($_POST['heureConsultation']) || empty($_POST['dureeConsultation'])) {
      header("Location: rechercherConsultations.php?warning=Veuillez remplir tous les champs requis");
    }

    
    if (!empty($_POST['dateConsultation']) && !empty($_POST['heureConsultation']) && !empty($_POST['dureeConsultation'])) {
      try{
        $requete->execute(array('usager_referent' => $_POST['usager_referent'],
                  'medecin_referent' => $_POST['medecin_referent'],
                  'dateConsultation' => $_POST['dateConsultation'],
                  'heureConsultation' => $_POST['heureConsultation'],
                  'dureeConsultation' => $_POST['dureeConsultation'],
                  'id_medecin' => $_GET['id_medecin'],
                  'id_usager' => $_GET['id_usager'],
                  'verifconsult' => $_GET['heure']));
      }catch(Exception $e){
        echo 'Erreur de la requête de modification d\'un médecin  : ', $e->getMessage();
      }
      
      header("Location: rechercherConsultations.php?success=La consultation à bien été modifé !");

    }
  }
  require "../communs/header.php";

  $formulaire = $BDD->prepare("SELECT * FROM consultation WHERE id_medecin = :id_medecin AND id_usager = :id_usager AND heureConsultation = :heure");
  try{
    $formulaire->execute(array('id_medecin' => $_GET['id_medecin'], 'id_usager' => $_GET['id_usager'], 'heure' => $_GET['heure']));
  }catch(Exception $e){
    echo 'Erreur de la requête de récupération de l\'id d\'un médecin : ', $e->getMessage();
  }

  while ($data = $formulaire->fetch()) {
?>
  <html>
    <head>
        <meta charset="utf-8">
        <title> Modification d'une consultation </title>
    </head>
    <form method="Post" action="">
        <div class="shadow p-3 mb-5 bg-white rounded">
          <h2 align="center"> Modification d'une consultation </h2>
        </div>
         <center><p>
            <div class="shadow p-3 mb-5 bg-white rounded" style="width: 50%;">
              <div class="form-group">
                 <b>Client  :</b>
                 <?php require 'choixUsager.php'; ?>
              </div>
              <div class="form-group">
                 <b>Médecin consultant :</b>
                 <?php require 'choixMedecin.php'; ?>
              </div>
              <div class="form-group">
                 <b>Date de consultation :</b> <input type="date" name="dateConsultation" id="dateConsultation" value="<?php echo $data['dateConsultation'];?>" />
                 <br />
              </div>
              <div class="form-group">
                 <b>Heure de consultation :</b> <input type="time"  name="heureConsultation" id="heureConsultation" min="08:00" max="18:00" required value="<?php echo $data['heureConsultation'];?>" />
                 <br />
              </div>
              <div class="form-group">
                 <b>Durée de la consultation :</b> <input type="time" name="dureeConsultation" id="dureeConsultation" required value="<?php echo $data['dureeConsultation'];?>"/>
              </div>
              <div class="form-group">
                  <input type="submit" value="Envoyer" class="btn btn-outline-success">  <input type="reset" value="Vider" id="reset" class="btn btn-outline-danger">
              </div>
            </div>
         </p></center>
      </form>
  </html>
<?php 
}

?>


