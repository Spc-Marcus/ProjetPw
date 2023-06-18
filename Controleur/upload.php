<?php
$targetDir = "../Image/"; // Chemin vers le dossier de destination
$targetFile = $targetDir . basename($_FILES["image"]["name"]); // Chemin complet du fichier de destination
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION)); // Extension du fichier

// Vérifier si le fichier est une image réelle ou une fausse image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        echo "Le fichier est une image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "Le fichier n'est pas une image.";
        $uploadOk = 0;
    }
}

// Vérifier si le fichier existe déjà
if (file_exists($targetFile)) {
    echo "Désolé, le fichier existe déjà.";
    $uploadOk = 0;
}

// Limiter la taille du fichier
$maxFileSize = 5 * 1024 * 1024; // 5 Mo
if ($_FILES["image"]["size"] > $maxFileSize) {
    echo "Désolé, le fichier est trop volumineux. La taille maximale autorisée est de 5 Mo.";
    $uploadOk = 0;
}

// Autoriser certains formats de fichiers uniquement
$allowedExtensions = array("jpg", "jpeg", "png", "gif");
if (!in_array($imageFileType, $allowedExtensions)) {
    echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
    $uploadOk = 0;
}

// Vérifier si $uploadOk est défini à 0 par une erreur
if ($uploadOk == 0) {
    echo "Désolé, votre fichier n'a pas été téléchargé.";
// Si tout est ok, télécharger le fichier
} else {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        echo "Le fichier " . basename($_FILES["image"]["name"]) . " a été téléchargé avec succès.";
    } else {
        echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
    }
}
?>
