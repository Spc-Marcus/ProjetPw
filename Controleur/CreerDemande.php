<?php
$user=$_POST['userId'];
$trajet=$_POST['trajetId'];
$aller = 0;
if (isset($_POST['aller'])) {
    $aller = 1;
}

$retour = 0;
if (isset($_POST['retour'])) {
    $retour = 1;
}

$dbFile = '../DB/Donne.db';
$pdo = new PDO('sqlite:' . $dbFile);
require_once('../Model/Covoit.php');
require_once('../DAO/CovoitDAO.php');
$new=new Covoit(0,$trajet,$user,$aller,$retour);
$dao=new CovoitDAO($pdo);
$dao->create($new);
header('Localisation : Demande.php');
exit;
?>