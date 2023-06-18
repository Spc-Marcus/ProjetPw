<!DOCTYPE html>
<html>
<head>
  <link href="Css/bootstrap.css" rel="stylesheet">
  <style>
    .navbar-brand {
      font-weight: bold;
    }

    .navbar-nav .nav-link {
      font-weight: bold;
    }

    .svg-icon {
      width: 1em;
      height: 1em;
    }

    .svg-icon + .btn {
      margin-left: 10px;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="FestiVoiturage.php">Festi-Voiturage</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="Festival.php">Festival</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Trajet.php">Trajet</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Recherche.php">Recherche</a>
          </li>
        </ul>
      </div>
      <?php 
      if(isset($_SESSION["utilisateur"])){
        require_once("../DAO/CovoitDAO.php");
        require_once("../Outils/Demmande.php");
        $user=$_SESSION['utilisateur'];
        $prenom=$user->getPrenom(  );
        $nom=$user->getNom();
        $id=$user->getId();
        $dbFile = '../DB/Donne.db';
        $pdo = new PDO('sqlite:' . $dbFile);
        $dao= new CovoitDAO($pdo);
        $demande=$dao->getByConducteurId($id);
        if(empty(enAttente($demande))){
          echo '<a href="Demande.php" style="margin-right: 5px;">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 17H22V19H2V17H4V10C4 5.58172 7.58172 2 12 2C16.4183 2 20 5.58172 20 10V17ZM9 21H15V23H9V21Z"></path></svg>        </a>
        ';  
        }
        else{
          echo '<a href="Demande.php" style="margin-right: 5px;">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 17H22V19H2V17H4V10C4 5.58172 7.58172 2 12 2C16.4183 2 20 5.58172 20 10V17ZM18 17V10C18 6.68629 15.3137 4 12 4C8.68629 4 6 6.68629 6 10V17H18ZM9 21H15V23H9V21Z"></path></svg>
        </a>
        '; 
        }
        echo '<div class="dropdown">
        <button class="btn btn-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false"> '
        .$nom.', '.$prenom.
        '</button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
        <li><a class="dropdown-item" href="Demande.php">Vos Demandes</a></li>
          <li><a class="dropdown-item" href="ModifCompte.php">Compte</a></li>
          <li><a class="dropdown-item" href="Login.php">Déconnexion</a></li>
        </ul>
      </div>';
      }
      else{
        echo '<a class="btn btn-dark" href="Login.php">Connexion/Inscription</a>';
      }
      ?>
    </div>
  </nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
