<?php
class User {
    private $db;

    public function __construct() {
        // Création de l'objet PDO
        try {

            $this->db = new PDO(DSN, DB_USER, DB_PASSWORD);
            
        } catch (PDOException $e) {
            // Enregistrer l'erreur dans un fichier journal
            $message = '[' . date('Y-m-d H:i:s') . '] ' . $e->getMessage() . "\n";
            file_put_contents('logs/errors.log', $message, FILE_APPEND);
            // Afficher un message d'erreur à l'utilisateur
            die('Une erreur est survenue : contacter l\'admin : nassim.bougtib@hotmail.com <a href="index.php">Réessayer</a>');
        }
        // Mode de récupération des erreurs : exception
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function createUser($username, $email, $password) {
        try{

            // Vérifier si l'email ou le nom d'utilisateur existe déjà
            $stmt = $this->db->prepare('SELECT * FROM users WHERE username = :username OR email = :email');
            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            $result = $stmt->fetch();

            if ($result) {
                // L'email ou le nom d'utilisateur existe déjà, renvoyer une erreur
                die('Cet email ou ce nom d\'utilisateur est déjà utilisé. <a href="index.php?action=register">Retour</a>');
            }

            $stmt = $this->db->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':password', password_hash($password, PASSWORD_BCRYPT));
            $stmt->execute();

        }catch(Exception $e){

            // Enregistrer l'erreur dans un fichier journal
            $message = '[' . date('Y-m-d H:i:s') . '] ' . $e->getMessage() . "\n";
            file_put_contents('logs/errors.log', $message, FILE_APPEND);

            // Afficher un message d'erreur à l'utilisateur
            die('Une erreur est survenue : contacter l\'admin : nassim.bougtib@hotmail.com <a href="index.php?action=register">Retour</a>');
        }

    }

    public function getUserByUsername($username) {
        try{
            $stmt = $this->db->prepare('SELECT * FROM users WHERE username = :username');
            $stmt->bindValue(':username', $username);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){

            // Enregistrer l'erreur dans un fichier journal
            $message = '[' . date('Y-m-d H:i:s') . '] ' . $e->getMessage() . "\n";
            file_put_contents('logs/errors.log', $message, FILE_APPEND);

            // Afficher un message d'erreur à l'utilisateur
            die('Une erreur est survenue : contacter l\'admin : nassim.bougtib@hotmail.com <a href="index.php">Retour</a>');
        }
    }

    public function getUserById($id) {
        try{
            $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id');
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){

            // Enregistrer l'erreur dans un fichier journal
            $message = '[' . date('Y-m-d H:i:s') . '] ' . $e->getMessage() . "\n";
            file_put_contents('logs/errors.log', $message, FILE_APPEND);

            // Afficher un message d'erreur à l'utilisateur
            die('Une erreur est survenue : contacter l\'admin : nassim.bougtib@hotmail.com <a href="index.php">Retour</a>');
        }
    }
}
