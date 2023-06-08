<?php
session_start();

if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur'] !== 'Admin') {
    header("Location: ../Vue/Page/FestiVoiturage.php");
    exit;
}
?>
