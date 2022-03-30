
<?php session_start(); ?>

<html>
  <head>
    <meta charset="utf-8">

    <title>Page de connexion - Cabinet médical</title>

    <link rel="shortcut icon" href="/communs/img/favicon.ico" />

    <!-- Bootstrap CSS -->
    <link href="communs/css/bootstrap.min.css" rel="stylesheet">
    <!-- Connexion CSS -->
    <link href="communs/css/connexion.css" rel="stylesheet">

  </head>
    <body class="text-center">
        <form class="form-signin" method="Post">
          <img class="mb-2" src="communs/img/logo_cabinet.jpg" alt="" width="120" height="120">
          <h1 class="h3 mb-3 font-weight-normal" style="color: white">Cabinet médical</h1>
          <label for="labelUtilisater" class="sr-only">Nom d'utilisateur</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="Nom d'utilisateur" required autofocus>
          <label for="labelPassword" class="sr-only">Mot de passe</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Mot de passe" required>
          <button class="btn btn-lg btn-primary btn-block" type="submit">Se connecter </button>
        </form>
    </body>
</html>

<?php
require 'communs/config.php';
$verif_compte = $BDD->prepare("SELECT username, password FROM users WHERE username = :username AND password = :password");

//Si les deux champs sont remplis
if(isset($_POST['username']) && isset($_POST['password'])){
	$verif_compte->execute(array('username' => $_POST['username'],'password' => $_POST['password'])); //requête de vérification si le compte est existant ou pas
	 if($verif_compte->rowCount() >= 1) { //Si retourne une ligne ou plus, alors le compte est existant
        $_SESSION['user'] = $_POST['username']; //Création de la session user
        $_SESSION['pwd'] = $_POST['password']; //Création de la session password
        header("Location: medecins/FormulaireMedecin.php?success=Vous êtes connecté !"); //Redirection vers le site principal
        exit;
	 }
}
  if(isset($_GET['logout'])){ //Si nous obtenu un get dans l'url de type 'logout', la session est détruite
    session_destroy();
  }
  
  if(isset($_SESSION['user']) && isset($_SESSION['pwd'])){ //Si les sessions sont déjà crée, l'utilisateur est déjà connecté
    header("Location: medecins/FormulaireMedecin.php?warning=Vous êtes déjà connecté !");
  }
?>
