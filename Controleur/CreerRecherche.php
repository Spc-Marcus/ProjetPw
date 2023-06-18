<?php
    /*
    C:\Users\Utilisateur\Desktop\Cours\Univ\L2\projet\ProjetPw\Controleur\CreerRecherche.php:2:
    array (size=7)
    'festivalId' => string '1' (length=1)
    'userId' => string '1' (length=1)
    'dateAller' => string '2023-06-23' (length=10)
    'dateRetour' => string '2023-06-15' (length=10)
    'rechercheAller' => string 'on' (length=2)
    'rechercheRetour' => string 'on' (length=2)
    'localisation' => string 'eee' (length=3)
    */
    // Check if the required POST data is set
    if (isset($_POST['userId'], $_POST['festivalId'], $_POST['dateAller'], $_POST['localisation'])) {
        $userId = $_POST['userId'];
        $festivalId = $_POST['festivalId'];
        $dateAller = $_POST['dateAller'];
        $dateRetour = $_POST['dateRetour'];
        $localisation = $_POST['localisation'];
    
        $aller = 0;
        if (isset($_POST['rechercheAller'])) {
            $aller = 1;
        }
    
        $retour = 0;
        if (isset($_POST['rechercheRetour'])) {
            $retour = 1;
        }
    
        // Validate and sanitize input data as needed
    
        $dbFile = '../DB/Donne.db';
        $pdo = new PDO('sqlite:' . $dbFile);
        require_once('../Model/Presence.php');
        require_once('../DAO/PresenceDAO.php');
        
        $new = new Presence($userId, $festivalId, $dateAller, $dateRetour, $aller, $retour,$localisation);
        //var_dump($new);
        $dao = new PresenceDAO($pdo);
        $dao->create($new);
        
        header('Location: ../Vue/Demande.php');
        exit;
    } else {
        // Handle the case when required POST data is missing
        echo "Missing required data.";
        // You can also redirect the user to an error page using header() or display a meaningful error message.
    }
    ?>
    