<?php
session_destroy();
$email = $_POST['email'];
$mdp = $_POST['mdp'];


session_start();
if($email == '' || $mdp == ''){
    $_SESSION['message'] = "Veuillez saisir un email et un mot de passe";
    header("Location: ../Vue/login.php");
    exit;

}else{
    //connection pdo
    require_once('../DAO/FestivalierDAO.php');
    require_once('../Model/Festivalier.php');
    $dbFile = '../DB/Donne.db';
    $pdo = new PDO('sqlite:' . $dbFile);
    $festi=new Festivalier();
    $festi->setEmail($email);
    $festi->setPwd($mdp);
    $daoFesti=new FestivalierDAO($pdo);
    $result=$daoFesti->exist($festi);
    if (isset($result)) {
        //si festivalier
        $_SESSION['utilisateur'] = $result; // Assigner l'objet festivalier trouvé à la session
        header("Location:../Vue/FestiVoiturage.php");
        exit;
    }
    else{
        require_once('../DAO/AdminDAO.php');
        require_once('../Model/Admin.php');
        $adm=new Admin();
        $adm->setemail($email);
        $adm->setMotDePasse($mdp);
        $daoAdm=new AdminDAO($pdo);
        $result = $daoAdm->exist($adm);
    }if(isset($result)){
        var_dump($result);
        $_SESSION['utilisateur'] = $result; // Assigner l'objet Admin trouvé à la session
        var_dump($_SESSION['utilisateur']);
        
        header("Location:../Vue/PrincipalAdmin.php");
        exit;
    }    
    else{
            $_SESSION['message'] = "Erreur de login/mot de passe";
            header("Location: ../Vue/login.php");
            exit;
    }
}

?>
