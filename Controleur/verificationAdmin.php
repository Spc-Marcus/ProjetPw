<?php
session_start();

if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur'] !== 'Admin') {
    header("Location: Login.php");
    exit;
}
session_destroy();
?>
