<?php
// Démarrer la session
session_start();

// Charger les fichiers nécessaires
require_once 'inc/config.php';
require_once 'inc/helpers.php';
require_once 'model/user.php';
require_once 'controller/userController.php';

// Instancier le contrôleur utilisateur
$userController = new UserController();

// Router la demande en fonction de l'action demandée
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'register':
            $userController->register();
            break;
        case 'login':
            $userController->login();
            break;
        case 'logout':
            $userController->logout();
            break;
        case 'profile':
            $userController->profile();
            break;
        default:
            $userController->index();
            break;
    }
} else {
    $userController->index();
}
?>
