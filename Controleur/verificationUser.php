<?php
require_once('../Model/Admin.php');
require_once('../Model/Festivalier.php');
session_start();

if (isset($_SESSION['utilisateur']) &&$_SESSION['utilisateur'] instanceof Admin) {
    $_SESSION['message'] = "Un admin ne peut-etre connecter sur le site principal !";
    header("Location: ../Vue/Login.php");
    exit;
}

?>