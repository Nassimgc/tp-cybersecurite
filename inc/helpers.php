<?php
// Fonction d'échappement pour éviter les attaques d'injection SQL
function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Fonction pour vérifier si une chaîne contient des caractères dangereux
function isSafe($string) {
    return !preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $string);
}

// Fonction pour vérifier si un email est valide
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}


// Fonction pour récupérer l'adresse IP de la personne
function getIPAddress() {  
    //whether ip is from the share internet  
     if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
    }  
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
     }  
    //whether ip is from the remote address  
    else{  
         $ip = $_SERVER['REMOTE_ADDR'];  
     }  
     return $ip;  
}
