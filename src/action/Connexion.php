<?php

namespace touiteur\action;

use exception\CompteException;
use touiteur\compte\compteUtil;
require_once 'vendor/autoload.php';

class Connexion
{
    public static function Connexion($email, $password)
    {
        $bd = ConnectionFactory::makeConnection();
        $st = $bd->prepare("SELECT nom,prenom,email,mdpUtil FROM email 
                                    INNER JOIN utilisateur ON email.idUtil = utilisateur.idUtil
                                    WHERE email = :email");
        $st->bindParam(':email', $email);
        $st->execute();

        $user = $st->fetch();

        if ($user && password_verify($password, $user['mdpUtil'])) {
            // Authentification réussie, renvoyer l'utilisateur
            return new compteUtil($user['nom'], $user['prenom'], $user['mdpUtil'], $user['email']);
        } else {
            throw new CompteException("La connexion a échoué.");
        }
    }

    public function execute():string
    {
        session_start();

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $pwd = $_POST['Passord'];
            $em = $_POST['email'];
            $_SESSION['connection']=self::Connexion($em,$pwd);
        }

        $s = '<div class="container">';
        $s = $s . "<h2>Connexion</h2>";
        $s .= '<form><input type="text" placeholder="<email>" >
              <input type="password" placeholder="<Password>" >
              <button type="submit">Valider</button></form>';

        return $s;
    }
}