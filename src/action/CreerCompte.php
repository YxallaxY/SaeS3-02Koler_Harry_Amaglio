<?php

namespace action;

use exception\CompteException;
use iutnc\deefy\db\ConnectionFactory;
use iutnc\deefy\exception\AuthException as AuthExceptionAlias;

class CreerCompte
{
    private $email;
    private $passwd;
    private $role;
    
    public function checkPasswordStrength(string $pass,
                                          int $minimumLength): bool {

        $length = (strlen($pass) < $minimumLength); // longueur minimale
        $digit = preg_match("#[\d]#", $pass); // au moins un digit
        $special = preg_match("#[\W]#", $pass); // au moins un car. spécial
        $lower = preg_match("#[a-z]#", $pass); // au moins une minuscule
        $upper = preg_match("#[A-Z]#", $pass); // au moins une majuscule
        if (!$length || !$digit || !$special || !$lower || !$upper)return false;
        return true;
    }

    public function CreerCompte($email, $passwd, $role){
        // Vérifie la qualité du mot de passe
        if ($this->checkPasswordStrength($passwd,3)) {
            throw new CompteException("Le mot de passe doit avoir au moins 10 caractères.");
        }

        // Vérifie si l'utilisateur avec cet email existe déjà
        $bd = ConnectionFactory::makeConnection();
        $st = $bd->prepare("SELECT * FROM user WHERE email = :email");
        $st->bindParam(':email', $email);
        $st->execute();
        $existingUser = $st->fetch();

        if ($existingUser) {
            throw new CompteException("Un compte avec cet email existe déjà.");
        }

        // Encode le mot de passe
        $hashedPassword = password_hash($passwd, PASSWORD_DEFAULT);

        // Insère le nouvel utilisateur dans la base de données
        $st = $bd->prepare("INSERT INTO user (email, passwd, role) VALUES (:email, :passwd, 1)");
        $st->bindParam(':email', $email);
        $st->bindParam(':passwd', $hashedPassword);

        if ($st->execute()) {
            // Succès de l'inscription
            return true;
        } else {
            // Échec de l'inscription
            return false;
        }
    }

    public static function Connection($email, $password)
    {
        $bd = ConnectionFactory::makeConnection();
        $st = $bd->prepare("SELECT * FROM user WHERE email = :email");
        $st->bindParam(':email', $email);
        $st->execute();

        $user = $st->fetch();

        if ($user && password_verify($password, $user['passwd'])) {
            // Authentification réussie, renvoyer l'utilisateur
            return new User($user['email'], $user['passwd'], $user['role']);
        } else {
            throw new CompteException("La connexion a échoué.");
        }
    }
}