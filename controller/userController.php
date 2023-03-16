<?php
class UserController {
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    public function index() {
        include 'views/index.php';
    }

    public function register() {
        try{
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Jeton CSRF invalide, afficher une erreur ou rediriger vers une page d'erreur
                if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                
                    // Enregistrer l'erreur dans un fichier journal
                    $message = '[' . date('Y-m-d H:i:s') . '] ' . 'Tentative de penetration Register: '.getIPAddress(). "\n";
                    file_put_contents('logs/errors.log', $message, FILE_APPEND);
                    
                    // Afficher un message d'erreur à l'utilisateur
                    die('Erreur : jeton CSRF invalide. <a href="index.php?action=register">Retour</a>');
                }
                // Récupérer les données du formulaire
                $username = escape($_POST['username']);
                $email = escape($_POST['email']);
                $password = escape($_POST['password']);

                // Vérifier si les données sont valides
                $errors = array();

                if (!isSafe($username)) {
                    $errors[] = 'Le nom d\'utilisateur contient des caractères dangereux.';
                }

                if (!isValidEmail($email)) {
                    $errors[] = 'L\'adresse email n\'est pas valide.';
                }

                if (!isSafe($password)) {
                    $errors[] = 'Le mot de passe contient des caractères dangereux.';
                }

                if (count($errors) == 0) {
                    // Créer l'utilisateur
                    $this->user->createUser($username, $email, $password);

                    // Rediriger vers la page de connexion
                    header('Location: index.php?action=login');
                    exit();
                } else {
                    // Afficher les erreurs
                    include 'views/register.php';
                }
            } else {
                // Afficher le formulaire d'inscription
                include 'views/register.php';
            }
        }catch(Exception $e){
            
            // Enregistrer l'erreur dans un fichier journal
            $message = '[' . date('Y-m-d H:i:s') . '] ' . $e->getMessage() . "\n";
            file_put_contents('logs/errors.log', $message, FILE_APPEND);
            // Afficher un message d'erreur à l'utilisateur
            die('Une erreur est survenue : contacter l\'admin : nassim.bougtib@hotmail.com <a href="index.php?action=register">Retour</a>');
        }
    }

    public function login() {
        try{
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Vérifier le jeton CSRF
                if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {

                    // Enregistrer l'erreur dans un fichier journal
                    $message = '[' . date('Y-m-d H:i:s') . '] ' . 'Tentative de penetration Login : '.getIPAddress(). "\n";
                    file_put_contents('logs/errors.log', $message, FILE_APPEND);
                    die('Erreur : jeton CSRF invalide. <a href="index.php?action=login">Retour</a>');

                }
                // Récupérer les données du formulaire
                $username = escape($_POST['username']);
                $password = escape($_POST['password']);

                // Vérifier si les données sont valides
                $errors = array();

                if (!isSafe($username)) {
                    $errors[] = 'Le nom d\'utilisateur contient des caractères dangereux.';
                }

                if (!isSafe($password)) {
                    $errors[] = 'Le mot de passe contient des caractères dangereux.';
                }

                if (count($errors) == 0) {
                    // Récupérer l'utilisateur depuis la base de données
                    $user = $this->user->getUserByUsername($username);

                    if ($user && password_verify($password, $user['password'])) {
                        // Enregistrer l'utilisateur dans la session
                        $_SESSION['user_id'] = $user['id'];

                        // Rediriger vers la page de profil
                        header('Location: index.php?action=profile');
                        exit();
                    } else {
                        // Afficher un message d'erreur
                        $errors[] = 'Le nom d\'utilisateur ou le mot de passe est incorrect.';
                        include 'views/login.php';
                    }
                } else {
                    // Afficher les erreurs
                    include 'views/login.php';
                }
            } else {
                // Afficher le formulaire de connexion
                include 'views/login.php';
            }
        }catch(Exception $e){

            // Enregistrer l'erreur dans un fichier journal
            $message = '[' . date('Y-m-d H:i:s') . '] ' . $e->getMessage() . "\n";
            file_put_contents('logs/errors.log', $message, FILE_APPEND);
            // Afficher un message d'erreur à l'utilisateur
            die('Une erreur est survenue : contacter l\'admin : nassim.bougtib@hotmail.com <a href="index.php?action=login">Retour</a>');
        }
    }

    public function logout() {
        try{
            // Détruire la session et rediriger vers la page d'accueil
            session_destroy();
            header('Location: index.php');
            exit();
        }catch(Exception $e){

            // Enregistrer l'erreur dans un fichier journal
            $message = '[' . date('Y-m-d H:i:s') . '] ' . $e->getMessage() . "\n";
            file_put_contents('logs/errors.log', $message, FILE_APPEND);
            // Afficher un message d'erreur à l'utilisateur
            die('Une erreur est survenue : contacter l\'admin : nassim.bougtib@hotmail.com <a href="index.php">Retour</a>');
        }
    }

    public function profile() {
        try{
            // Vérifier si l'utilisateur est connecté
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?action=login');
                exit();
            }

            // Récupérer l'utilisateur depuis la base de données
            $user = $this->user->getUserById($_SESSION['user_id']);

            // Afficher le profil de l'utilisateur
            include 'views/profile.php';
        }catch(Exception $e){

            // Enregistrer l'erreur dans un fichier journal
            $message = '[' . date('Y-m-d H:i:s') . '] ' . $e->getMessage() . "\n";
            file_put_contents('logs/errors.log', $message, FILE_APPEND);
            // Afficher un message d'erreur à l'utilisateur
            die('Une erreur est survenue : contacter l\'admin : nassim.bougtib@hotmail.com <a href="index.php">Retour</a>');
        }
    }
}
?>

