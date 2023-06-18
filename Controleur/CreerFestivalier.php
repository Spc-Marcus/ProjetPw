<?php
session_start();
require_once("../Model/Festivalier.php");
require_once("../Outils/allId.php");
require_once("../DAO/FestivalierDAO.php");
if($_POST['nom']==''||$_POST['prenom']==''||$_POST['email']==''||$_POST['mdp']==''){
    $_SESSION['message'] = "Veuillez saisir tous les champs";
    header("Location: ../Vue/login.php");
    exit;
}else {
    $nom=$_POST['nom'];
    $prenom=$_POST['prenom'];
    $email=$_POST['email'];
    $mdp=$_POST['mdp'];
    $userIds = getAllUserIds();
    if(in_array($email,$userIds)){
        $_SESSION['message'] = "L'adresse mail existe deja";
        header("Location: ../Vue/login.php");
        exit;
        }
    else{
        $new=new Festivalier($prenom,$nom,$email,$mdp);
        $dbFile = '../DB/Donne.db';
        $pdo = new PDO('sqlite:' . $dbFile);
        $dao=new FestivalierDAO($pdo);
        $_SESSION['utilisateur']=$dao->create($new);
        header("Location:../Vue/FestiVoiturage.php");
        exit;
    }
}
?>