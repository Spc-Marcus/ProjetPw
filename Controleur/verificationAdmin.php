<?php
require_once('../Model/Admin.php');
session_start();

if (!isset($_SESSION['utilisateur']) || !($_SESSION['utilisateur'] instanceof Admin)) {
    header("Location: Login.php");
    session_destroy();
    exit;
}

?>
