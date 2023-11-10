<?php

namespace touiteur\action;

use exception\CompteException;

class Inscription
{
    private $email;
    private $passwd;
    private $role;
    private $nom;
    private $prenom;

    /**
     * @param $email
     * @param $passwd
     * @param $role
     */
    public function __construct($email, $passwd, $role)
    {
        $this->email = $email;
        $this->passwd = $passwd;
        $this->role = $role;
    }

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

    public function CreerCompte($nom,$prenom,$email, $passwd, $role){
        // Vérifie la qualité du mot de passe
        if ($this->checkPasswordStrength($passwd,3)) {
            throw new CompteException("Le mot de passe doit avoir au moins 3 caractères.");
        }

        // Vérifie si l'utilisateur avec cet email existe déjà
        $bd = ConnectionFactory::makeConnection();
        $st = $bd->prepare("SELECT * FROM email WHERE adresseUtil = :email");
        $st->bindParam(':email', $email);
        $st->execute();
        $existingUser = $st->fetch();

        if ($existingUser) {
            throw new CompteException("Un compte avec cet email existe déjà.");
        }

        // Encode le mot de passe
        $hashedPassword = password_hash($passwd, PASSWORD_DEFAULT);

        // Insère le nouvel utilisateur dans la base de données
        $st = $bd->prepare("INSERT INTO email (adresseUtil) VALUES (:adr)");
        $st->bindParam(':adr',$email);
        $st = $bd->prepare("INSERT INTO utilisateur (nomUtil,prenomUtil,mdpUtil) VALUES (:nom,;prenom,:mdp)");
        $st->bindParam(':nom',$nom);
        $st->bindParam(':prenom',$prenom);
        $st->bindParam(':mdp', $hashedPassword);

        if ($st->execute()) {
            // Succès de l'inscription
            return true;
        } else {
            // Échec de l'inscription
            return false;
        }
    }
}