<?php

namespace touiteur\action;

use exception\CompteException;
use touiteur\compte\compteUtil;

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
}