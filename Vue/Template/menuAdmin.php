<?php 
//session_start();
//$nom=$_SESSION['nom'];
//$prenom=$_SESSION['prenom'];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Menu Admin</title>
  <link href="Css/bootstrap.css" rel="stylesheet">
  <style>
    .navbar-brand {
      font-weight: bold;
    }

    .navbar-nav .nav-link {
      font-weight: bold;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="PrincipalAdmin.php">Festi-Voiturage</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="PrincipalAdmin.php">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="FestivalAdmin.php">Festival</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="UtilisateurAdmin.php">Utilisateur</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="TrajetAdmin.php">Trajet</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Autre
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="PresenceAdmin.php">Présent</a></li>
              <li><a class="dropdown-item" href="CovoitAdmin.php">Demande</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <div class="dropdown">
        <button class="btn btn-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <?php //echo $prenom.", ".$nom;
          echo "nom , Prenom"
          ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
          <li><a class="dropdown-item" href="#">Compte</a></li>
          <li><a class="dropdown-item" href="#">Déconnexion</a></li>
        </ul>
      </div>
    </div>
  </nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
