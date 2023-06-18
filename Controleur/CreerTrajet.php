<?php
/*
C:\Users\Utilisateur\Desktop\Cours\Univ\L2\projet\ProjetPw\Controleur\CreerTrajet.php:2:
array (size=7)
  'festivalId' => string '4' (length=1)
  'userId' => string '1' (length=1)
  'vehicule' => string 'aa' (length=2)
  'places' => string '1' (length=1)
  'aller' => string '2023-06-29' (length=10)
  'retour' => string '2023-06-15' (length=10)
  'localisation' => string 'a' (length=1)
  */
  if (isset($_POST['userId'], $_POST['festivalId'], $_POST['vehicule'],$_POST['places'], $_POST['aller'],  $_POST['localisation'])) {
    $userId = $_POST['userId'];
    $festivalId = $_POST['festivalId'];
    $vehicule = $_POST['vehicule'];
    $places = $_POST['places'];
    $dateAller = $_POST['aller'];
    $dateRetour =null;
    if(isset($_POST['retour']))$dateRetour = $_POST['retour'];
    
    $localisation = $_POST['localisation'];

    $dbFile = '../DB/Donne.db';
    $pdo = new PDO('sqlite:' . $dbFile);
    require_once('../Model/Trajet.php');
    require_once('../DAO/TrajetDAO.php');
    
    $new = new Trajet($userId, $festivalId, $vehicule, $places, $dateAller, $dateRetour ,$localisation);
    $dao = new TrajetDAO($pdo);
    $new= $dao->create($new);
    header('Location: ../Vue/Demande.php');
    exit;
} else {
    // Handle the case when required POST data is missing
    echo "Missing required data.";
    // You can also redirect the user to an error page using header() or display a meaningful error message.
}
?>