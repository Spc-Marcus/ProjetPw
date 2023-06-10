<?php
require_once("../Outils/allId.php");
// Récupérer l'e-mail envoyé depuis la requête AJAX
$email = $_POST['email'];

// Vérification de l'existence de l'e-mail dans votre fonction getAllUserIds()
$userIds = getAllUserIds();
$exists = in_array($email, $userIds);

// Renvoyer la réponse JSON
$response = array('exists' => $exists);
echo json_encode($response);
?>
