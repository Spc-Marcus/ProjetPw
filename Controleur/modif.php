<?php
    const HTTP_OK=200;
    const HTTP_BAD_REQUEST=400;
    const HTTP_METHODE_NOT_ALLOWED=405;
    const HTTP_UNAUTHORIZED=401;
    if($_SERVER['REQUEST_METHOD']==="POST"){
        $dbFile = '../DB/Donne.db';
        $pdo = new PDO('sqlite:' . $dbFile);
        $origine=$_POST["origine"];
        switch ($origine) {

            case 'Admin':
                require_once('../DAO/AdminDAO.php');
                $dao=new AdminDAO($pdo);
                $action = $_POST['action'];
            
                switch ($action) {
                    case 'ajouter':
                        // Appel la fonction d'ajout
                        require_once('../Model/Admin.php');
                        $nouveau= new Admin($_POST['nom'],$_POST['prenom'],$_POST['email'],$_POST['mot de passe']);
                        $dao->create($nouveau);
                        break;
                    case 'modifier':
                        // Appel la fonction de modification
                        require_once('../Model/Admin.php');
                        $modif= new Admin($_POST['nom'],$_POST['prenom'],$_POST['email'],$_POST['mot de passe']);
                        $modif->setAdminId($_POST['id']);
                        $dao->update($nouveau);
                        break;
                    case 'supprimer':
                        // Appel la fonction de suppression
                        $dao->delete($_POST['id']);
                        break;
                }
                break;
            case 'Festivalier':
                require_once('../DAO/FestivalierDAO.php');
                $dao=new FestivalierDAO($pdo);
                $action = $_POST['action'];
            
                switch ($action) {
                    case 'ajouter':
                        // Appel la fonction d'ajout
                        require_once('../Model/Festivalier.php');
                        $nouveau= new Festivalier($_POST['nom'],$_POST['prenom'],$_POST['email'],$_POST['mot de passe']);
                        $dao->create($nouveau);
                        break;
                    case 'modifier':
                        // Appel la fonction de modification
                        require_once('../Model/Festivalier.php');
                        $modif= new Festivalier($_POST['nom'],$_POST['prenom'],$_POST['email'],$_POST['mot de passe']);
                        $modif->setID($_POST['id']);
                        $dao->update($modif);
                        break;
                    case 'supprimer':
                        // Appel la fonction de suppression
                        $dao->delete($_POST['id']);
                        break;
                }
                break;
                case 'Festival':
                    require_once('../DAO/FestivalDAO.php');
                    $dao=new FestivalDAO($pdo);
                    $action = $_POST['action'];
                
                    switch ($action) {
                        case 'ajouter':
                            // Appel la fonction d'ajout
                            require_once('../Model/Festival.php');
                            $nouveau= new Festival($_POST['nom'],$_POST['date_debut'],$_POST['date_fin'],$_POST['localisation'],$_POST['photo']);
                            $dao->create($nouveau);
                            break;
                        case 'modifier':
                            // Appel la fonction de modification
                            require_once('../Model/Festival.php');
                            $modif= new Festival($_POST['nom'],$_POST['date_debut'],$_POST['date_fin'],$_POST['localisation'],$_POST['photo']);
                            $modif->setFestivalId($_POST['id']);
                            $dao->update($modif);
                            break;
                        case 'supprimer':
                            // Appel la fonction de suppression
                            $dao->delete($_POST['id']);
                            break;
                    }
                    break;
                case 'Covoit':
                    require_once('../DAO/CovoitDAO.php');
                    $dao=new CovoitDAO($pdo);
                    $action = $_POST['action'];
                
                    switch ($action) {
                        case 'ajouter':
                            // Appel la fonction d'ajout
                            require_once('../Model/Covoit.php');
                            $nouveau= new Covoit($_POST['accepter'],$_POST['trajet_id'],$_POST['user_id'],$_POST['aller'],$_POST['retour']);
                            $dao->create($nouveau);
                            break;
                        case 'modifier':
                            // Appel la fonction de modification
                            require_once('../Model/Covoit.php');
                            $modif= new Covoit($_POST['accepter'],$_POST['trajet_id'],$_POST['user_id'],$_POST['aller'],$_POST['retour']);
                            $modif->setCovoitId($_POST['id']);
                            $dao->update($modif);
                            break;
                        case 'supprimer':
                            // Appel la fonction de suppression
                            $dao->delete($_POST['id']);
                            break;
                    }
                    break;
                case 'Presence':
                    require_once('../DAO/PresenceDAO.php');
                    $dao=new PresenceDAO($pdo);
                    $action = $_POST['action'];
                
                    switch ($action) {
                        case 'ajouter':
                            // Appel la fonction d'ajout
                            require_once('../Model/Presence.php');
                            $nouveau= new Presence($_POST['festivalier_id'],$_POST['festival_id'],$_POST['date_aller'],$_POST['date_retour'],$_POST['aller'],$_POST['retour']);
                            $dao->create($nouveau);
                            break;
                        case 'modifier':
                            // Appel la fonction de modification
                            require_once('../Model/Presence.php');
                            $modif= new Presence($_POST['festivalier_id'],$_POST['festival_id'],$_POST['date_aller'],$_POST['date_retour'],$_POST['aller'],$_POST['retour']);
                            $dao->update($modif);
                            break;
                        case 'supprimer':
                            // Appel la fonction de suppression
                            $dao->delete($_POST['festivalier_id'],$_POST['festival_id']);
                            break;
                    }
                    break;
                case 'trajet':
                    require_once('../DAO/TrajetDAO.php');
                    $dao=new TrajetDAO($pdo);
                    $action = $_POST['action'];
                
                    switch ($action) {
                        case 'ajouter':
                            // Appel la fonction d'ajout
                            require_once('../Model/Trajet.php');
                            $nouveau= new Trajet($_POST['festivalier_id'],$_POST['festival_id'],$_POST['type_vehicule'],$_POST['places_disponible'],$_POST['date_aller'],null,$_POST['festival_id']);
                            if($_POST['date_retour'])$nouveau->setDateRetour($_POST['date_retour']);
                            $nouveau->setTrajetId($_POST['id']);
                            $dao->create($nouveau);
                            break;
                        case 'modifier':
                            // Appel la fonction de modification
                            require_once('../Model/Trajet.php');
                            $modif= new Trajet($_POST['festivalier_id'],$_POST['festival_id'],$_POST['type_vehicule'],$_POST['places_disponible'],$_POST['date_aller'],null,$_POST['festival_id']);
                            if($_POST['date_retour'])$modif->setDateRetour($_POST['date_retour']);
                            $modif->setTrajetId($_POST['id']);
                            $dao->update($modif);
                            break;
                        case 'supprimer':
                            // Appel la fonction de suppression
                            $dao->delete($_POST['id']);
                            break;
                    }
                    break;
            }
            $pdo=null;
        }

    function($code,$message){
        header("Content-Type : application/json");
        http_response_code($code);
        $reponse=[
            "code"=>$code,
            "message"=>$message];
        echo json_encode($reponse);
        
    }
    ?>