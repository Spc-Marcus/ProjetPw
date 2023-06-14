<?php
require_once('../Model/Admin.php');
session_start();

if (!isset($_SESSION['utilisateur']) || !($_SESSION['utilisateur'] instanceof Admin)) {
    $_SESSION['message'] = "Connection admin obligatoire dans cette partie du site !";
    header("Location: Login.php");
    exit;
}

?>
