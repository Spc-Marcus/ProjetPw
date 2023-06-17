<?php
    const HTTP_OK = 200;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_UNAUTHORIZED = 401;
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $dbFile = '../DB/Donne.db';
        $pdo = new PDO('sqlite:' . $dbFile);
        $origine = $_POST["origine"];

        switch ($origine) {
            case 'Admin':
                require_once('../DAO/AdminDAO.php');
                $dao = new AdminDAO($pdo);
                $action = $_POST['action'];

                switch ($action) {
                    case 'ajouter':
                        // Vérifier les valeurs nécessaires
                        if (!isset($_POST['nom']) || !isset($_POST['prenom']) || !isset($_POST['email']) || !isset($_POST['mdp'])) {
                            retour(HTTP_BAD_REQUEST, "Valeurs manquantes pour l'action d'ajout d'Admin");
                        }

                        // Appel de la fonction d'ajout
                        require_once('../Model/Admin.php');
                        $nouveau = new Admin($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['mdp']);
                        $dao->create($nouveau);
                        retour(HTTP_OK, "Opération effectuée avec succès");
                        break;

                    case 'modifier':
                        // Vérifier les valeurs nécessaires
                        if (!isset($_POST['id']) || !isset($_POST['nom']) || !isset($_POST['prenom']) || !isset($_POST['email']) || !isset($_POST['mdp'])) {
                            retour(HTTP_BAD_REQUEST, "Valeurs manquantes pour l'action de modification d'Admin");
                        }

                        // Appel de la fonction de modification
                        require_once('../Model/Admin.php');
                        $modif = new Admin($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['mdp']);
                        $modif->setAdminId($_POST['id']);
                        $dao->update($modif);
                        retour(HTTP_OK, "Opération effectuée avec succès");
                        break;

                    case 'supprimer':
                        // Vérifier les valeurs nécessaires
                        if (!isset($_POST['id'])) {
                            retour(HTTP_BAD_REQUEST, "Valeur manquante pour l'action de suppression d'Admin");
                        }

                        // Appel de la fonction de suppression
                        $dao->delete($_POST['id']);
                        retour(HTTP_OK, "Opération effectuée avec succès");
                        break;

                    default:
                        retour(HTTP_BAD_REQUEST, "Action inconnue pour l'origine Admin");
                        break;
                }
                break;

            case 'Festivalier':
                require_once('../DAO/FestivalierDAO.php');
                $dao = new FestivalierDAO($pdo);
                $action = $_POST['action'];

                switch ($action) {
                    case 'ajouter':
                        // Vérifier les valeurs nécessaires
                        if (!isset($_POST['nom']) || !isset($_POST['prenom']) || !isset($_POST['email']) || !isset($_POST['mdp'])) {
                            retour(HTTP_BAD_REQUEST, "Valeurs manquantes pour l'action d'ajout de Festivalier");
                        }

                        // Appel de la fonction d'ajout
                        require_once('../Model/Festivalier.php');
                        $nouveau = new Festivalier($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['mdp']);
                        $dao->create($nouveau);
                        retour(HTTP_OK, "Opération effectuée avec succès");
                        break;

                    case 'modifier':
                        // Vérifier les valeurs nécessaires
                        if (!isset($_POST['id']) || !isset($_POST['nom']) || !isset($_POST['prenom']) || !isset($_POST['email']) || !isset($_POST['mdp'])) {
                            retour(HTTP_BAD_REQUEST, "Valeurs manquantes pour l'action de modification de Festivalier");
                        }

                        // Appel de la fonction de modification
                        require_once('../Model/Festivalier.php');
                        $modif = new Festivalier($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['mdp']);
                        $modif->setID($_POST['id']);
                        $dao->update($modif);
                        retour(HTTP_OK, "Opération effectuée avec succès");
                        break;

                    case 'supprimer':
                        // Vérifier les valeurs nécessaires
                        if (!isset($_POST['id'])) {
                            retour(HTTP_BAD_REQUEST, "Valeur manquante pour l'action de suppression de Festivalier");
                        }

                        // Appel de la fonction de suppression
                        $dao->delete($_POST['id']);
                        retour(HTTP_OK, "Opération effectuée avec succès");
                        break;

                    default:
                        retour(HTTP_BAD_REQUEST, "Action inconnue pour l'origine Festivalier");
                        break;
                }
                break;

            case 'Festival':
                require_once('../DAO/FestivalDAO.php');
                $dao = new FestivalDAO($pdo);
                $action = $_POST['action'];

                switch ($action) {
                    case 'ajouter':
                        // Vérifier les valeurs nécessaires
                        if (!isset($_POST['nom']) || !isset($_POST['date_debut']) || !isset($_POST['date_fin']) || !isset($_POST['localisation']) || !isset($_POST['photo'])) {
                            retour(HTTP_BAD_REQUEST, "Valeurs manquantes pour l'action d'ajout de Festival");
                        }

                        // Appel de la fonction d'ajout
                        require_once('../Model/Festival.php');
                        $nouveau = new Festival($_POST['nom'], $_POST['date_debut'], $_POST['date_fin'], $_POST['localisation'], $_POST['photo']);
                        $new=$dao->create($nouveau);
                        retour(HTTP_OK, "Opération effectuée avec succès",$new->getFestivalId());
                        break;

                    case 'modifier':
                        // Vérifier les valeurs nécessaires
                        if (!isset($_POST['id']) || !isset($_POST['nom']) || !isset($_POST['date_debut']) || !isset($_POST['date_fin']) || !isset($_POST['localisation']) || !isset($_POST['photo'])) {
                            retour(HTTP_BAD_REQUEST, "Valeurs manquantes pour l'action de modification de Festival");
                        }

                        // Appel de la fonction de modification
                        require_once('../Model/Festival.php');
                        $modif = new Festival($_POST['nom'], $_POST['date_debut'], $_POST['date_fin'], $_POST['localisation'], $_POST['photo']);
                        $modif->setFestivalId($_POST['id']);
                        $dao->update($modif);
                        retour(HTTP_OK, "Opération effectuée avec succès",);
                        break;

                    case 'supprimer':
                        // Vérifier les valeurs nécessaires
                        if (!isset($_POST['id'])) {
                            retour(HTTP_BAD_REQUEST, "Valeur manquante pour l'action de suppression de Festival");
                        }

                        // Appel de la fonction de suppression
                        $dao->delete($_POST['id']);
                        retour(HTTP_OK, "Opération effectuée avec succès");
                        break;

                    default:
                        retour(HTTP_BAD_REQUEST, "Action inconnue pour l'origine Festival");
                        break;
                }
                break;

                case 'Covoit':
                    require_once('../DAO/CovoitDAO.php');
                    $dao = new CovoitDAO($pdo);
                    $action = $_POST['action'];
                
                    switch ($action) {
                        case 'ajouter':
                            // Vérifier les valeurs nécessaires
                            if (!isset($_POST['accepter']) || !isset($_POST['trajet_id']) || !isset($_POST['user_id']) || !isset($_POST['aller']) || !isset($_POST['retour'])) {
                                retour(HTTP_BAD_REQUEST, "Valeurs manquantes pour l'action d'ajout de Covoit");
                            }
                
                            // Appel de la fonction d'ajout
                            require_once('../Model/Covoit.php');
                            $nouveau = new Covoit($_POST['accepter'], $_POST['trajet_id'], $_POST['user_id'], $_POST['aller'], $_POST['retour']);
                            $dao->create($nouveau);
                            retour(HTTP_OK, "Opération effectuée avec succès");
                            break;
                
                        case 'modifier':
                            // Vérifier les valeurs nécessaires
                            if (!isset($_POST['accepter']) || !isset($_POST['trajet_id']) || !isset($_POST['user_id']) || !isset($_POST['aller']) || !isset($_POST['retour'])) {
                                retour(HTTP_BAD_REQUEST, "Valeurs manquantes pour l'action de modification de Covoit");
                            }
                
                            // Appel de la fonction de modification
                            require_once('../Model/Covoit.php');
                            $modif = new Covoit($_POST['accepter'], $_POST['trajet_id'], $_POST['user_id'], $_POST['aller'], $_POST['retour']);
                            $modif->setCovoitId($_POST['id']);
                            $dao->update($modif);
                            retour(HTTP_OK, "Opération effectuée avec succès");
                            break;
                
                        case 'supprimer':
                            // Vérifier les valeurs nécessaires
                            if (!isset($_POST['id'])) {
                                retour(HTTP_BAD_REQUEST, "Valeur manquante pour l'action de suppression de Covoit");
                            }
                
                            // Appel de la fonction de suppression
                            $dao->delete($_POST['id']);
                            retour(HTTP_OK, "Opération effectuée avec succès");
                            break;
                
                        default:
                            retour(HTTP_BAD_REQUEST, "Action inconnue pour l'origine Covoit");
                            break;
                    }
                    break;
                

                case 'Presence':
                    require_once('../DAO/PresenceDAO.php');
                    $dao = new PresenceDAO($pdo);
                    $action = $_POST['action'];
                
                    switch ($action) {
                        case 'ajouter':
                            // Vérifier les valeurs nécessaires
                            if (!isset($_POST['festivalier_id']) || !isset($_POST['festival_id']) || !isset($_POST['date_aller']) || !isset($_POST['date_retour']) || !isset($_POST['aller']) || !isset($_POST['retour'])) {
                                retour(HTTP_BAD_REQUEST, "Valeurs manquantes pour l'action d'ajout de Presence");
                            }
                
                            // Appel de la fonction d'ajout
                            require_once('../Model/Presence.php');
                            $nouveau = new Presence($_POST['festivalier_id'], $_POST['festival_id'], $_POST['date_aller'], $_POST['date_retour'], $_POST['aller'], $_POST['retour']);
                            $dao->create($nouveau);
                            retour(HTTP_OK, "Opération effectuée avec succès");
                            break;
                
                        case 'modifier':
                            // Vérifier les valeurs nécessaires
                            if (!isset($_POST['id'])||!isset($_POST['festivalier_id']) || !isset($_POST['festival_id']) || !isset($_POST['date_aller']) || !isset($_POST['date_retour']) || !isset($_POST['aller']) || !isset($_POST['retour'])) {
                                
                                retour(HTTP_BAD_REQUEST, "Valeurs manquantes pour l'action de modification de Presence");
                            }
                            // Appel de la fonction de modification
                            require_once('../Model/Presence.php');
                            $modif = new Presence($_POST['festivalier_id'], $_POST['festival_id'], $_POST['date_aller'], $_POST['date_retour'], $_POST['aller'], $_POST['retour']);
                            $modif->setId($_POST["id"]);
                            $dao->update($modif);
                            retour(HTTP_OK, "Opération effectuée avec succès");
                            break;
                
                        case 'supprimer':
                            // Vérifier les valeurs nécessaires
                            if (!isset($_POST['id'])) {
                                retour(HTTP_BAD_REQUEST, "Valeurs manquantes pour l'action de suppression de Presence");
                            }
                
                            // Appel de la fonction de suppression
                            $dao->delete($_POST['id']);
                            retour(HTTP_OK, "Opération effectuée avec succès");
                            break;
                
                        default:
                            retour(HTTP_BAD_REQUEST, "Action inconnue pour l'origine Presence");
                            break;
                    }
                    break;
                
                

            case 'Trajet':
                require_once('../DAO/TrajetDAO.php');
                $dao = new TrajetDAO($pdo);
                $action = $_POST['action'];

                switch ($action) {
                    case 'ajouter':
                        // Vérifier les valeurs nécessaires
                        if (!isset($_POST['user_id']) || !isset($_POST['festival_id']) || !isset($_POST['type_vehicule']) || !isset($_POST['places_disponibles']) || !isset($_POST['date_aller']) || !isset($_POST['localisation'])) {
                            retour(HTTP_BAD_REQUEST, "Valeurs manquantes pour l'action d'ajout de Trajet");
                        }
            
                        // Créer un nouvel objet Trajet avec les valeurs fournies
                        $nouveau = new Trajet($_POST['user_id'], $_POST['festival_id'], $_POST['type_vehicule'], $_POST['places_disponibles'], $_POST['date_aller'], $_POST['date_retour'], $_POST['localisation']);
            
                        // Appeler la méthode de création dans le DAO
                        $new=$dao->create($nouveau);
                        retour(HTTP_OK, "Opération effectuée avec succès",$new->getTrajetId());
                        break;

                    case 'modifier':
                            // Vérifier les valeurs nécessaires
                            if (!isset($_POST['id']) || !isset($_POST['user_id']) || !isset($_POST['festival_id']) || !isset($_POST['type_vehicule']) || !isset($_POST['places_disponibles']) || !isset($_POST['date_aller']) || !isset($_POST['localisation']) ) {
                                retour(HTTP_BAD_REQUEST, "Valeurs manquantes pour l'action de modification de Trajet");
                            }
                
                            // Créer un objet Trajet avec les valeurs fournies
                            $modif = new Trajet($_POST['user_id'], $_POST['festival_id'], $_POST['type_vehicule'], $_POST['places_disponibles'], $_POST['date_aller'], $_POST['date_retour'], $_POST['localisation']);
                
                            // Définir l'ID du trajet à modifier
                            $modif->setTrajetId($_POST['id']);
                
                            // Appeler la méthode de mise à jour dans le DAO
                            $dao->update($modif);
                            retour(HTTP_OK, "Opération effectuée avec succès");
                            break;

                    case 'supprimer':
                            // Vérifier les valeurs nécessaires
                            if (!isset($_POST['id'])) {
                                retour(HTTP_BAD_REQUEST, "Valeur manquante pour l'action de suppression de Trajet");
                            }
                
                            // Appeler la méthode de suppression dans le DAO
                            $dao->delete($_POST['id']);
                            retour(HTTP_OK, "Opération effectuée avec succès");
                            break;
                
                        default:
                            retour(HTTP_BAD_REQUEST, "Action inconnue pour l'origine Trajet");
                            break;
                    }
                break;

            default:
                retour(HTTP_BAD_REQUEST, "Origine inconnue");
                break;
        }
    } else {
        retour(HTTP_METHOD_NOT_ALLOWED, "Méthode non autorisée");
    }

    function retour($code, $message,$id=null) {
        http_response_code($code);
        header("Content-Type: application/json");
        echo json_encode(array("message" => $message,"id"=>$id));
        exit;
    }
?>
