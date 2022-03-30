<html>

	<meta charset="utf-8">

	<!-- Importation d'include JS et CSS -->
	<link rel="shortcut icon" href="../communs/img/favicon.ico" />
	<link href="../communs/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="../communs/js/jquery-3.3.1.slim.min.js"></script>
    <script src="../communs/js/popper.min.js"></script>
    <script src="../communs/js/bootstrap.min.js"></script>

    <!-- NAVIGATION BAR -->
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  	<a class="navbar-brand" href="../medecins/FormulaireMedecin.php">Cabinet médical</a>

  	<ul class="navbar-nav">
	    <!-- Menu Usager -->
	    <li class="nav-item dropdown">
	     	<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Usagers</a>
	      	<div class="dropdown-menu">
		        <a class="dropdown-item" href="../usagers/FormulaireUsager.php">Ajouter un usager</a>
		        <a class="dropdown-item" href="../usagers/rechercheUsager.php">Rechercher un usager</a>
	      	</div>
	    </li>

	    <!-- Menu Medecin -->
	    <li class="nav-item dropdown">
	     	<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Médecins</a>
	      	<div class="dropdown-menu">
		        <a class="dropdown-item" href="../medecins/FormulaireMedecin.php">Ajouter un médecin</a>
		        <a class="dropdown-item" href="../medecins/rechercheMedecin.php">Rechercher un médecin</a>
	      	</div>
	    </li>

	    <!-- Menu Consultation -->
	    <li class="nav-item dropdown">
	     	<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Consultation</a>
	      	<div class="dropdown-menu">
		        <a class="dropdown-item" href="../consultations/FormulaireConsultation.php">Ajouter une consultation</a>
		        <a class="dropdown-item" href="../consultations/rechercherConsultations.php">Rechercher une consultation</a>
	      	</div>
	    </li>

	    <!-- Menu Statistiques -->
	    <li class="nav-item dropdown">
	     	<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Statistiques</a>
	      	<div class="dropdown-menu">
		        <a class="dropdown-item" href="../statistiques/statistiquesUsagers.php">Statistiques répartition des usagers</a>
		        <a class="dropdown-item" href="../statistiques/statistiquesMedecins.php">Statistiques consultations par médecin</a>
	      	</div>
	    </li>

	  </ul>
	  <ul class="navbar-nav ml-auto">
	  	<?php
            if (isset($_SESSION['user']) && isset($_SESSION['pwd'])) { //Si les sessions user et pwd sont remplies et connues
                echo "<a href='../index.php?logout'><button class='btn btn-outline-danger my-2 my-sm-0' type='button'>Se déconnecter</button></a>";
            }else{
            	header("Location: ../index.php?success=Veuillez vous connecter !"); //Sinon il faut se connecter
            }?>
  	  </ul>
</nav>
</html>
<?php
//Si l'url reçoit un GET de ces cases la, alors affiche un message sous la forme définie
if (isset($_GET)) {
    foreach ($_GET as $geter => $donnee) {
        switch ($geter) {
            case 'error':
                echo "<div class='alert alert-danger' role='alert'>$donnee</div>";
                break;
            case 'success':
                echo "<div class='alert alert-success' role='alert'>$donnee</div>";
                break;
            case 'info':
                echo "<div class='alert alert-info' role='alert'>$donnee</div>";
                break;
            case 'warning':
                echo "<div class='alert alert-warning' role='alert'>$donnee</div>";
                break;
        }
    }
}
?>