<?php

namespace touiteur\action;

use touiteur\compte\compteUtil;

require_once 'vendor/autoload.php';

class afficherTouite
{
    public function __construct()
    {

    }

    public function execute(): string
    {

        session_start();
        $pdo = \touiteur\bd\ConnectionFactory::makeConnection();
        $touite = $_SESSION['tabTouite'][$_GET['courrant']];
        $query = $pdo->query("SELECT * FROM `Utilisateur` Inner join touite on utilisateur.idUtil = touite.idUtil
                                                            Inner join email on email.idutil = touite.idutil 
                                                            WHERE nomUtil = '" . $touite->nom . "' AND prenomUtil ='" . $touite->prenom . "'");
        while ($data = $query->fetch()) {
            $compte = new compteUtil($data['nomUtil'], $data['prenomUtil'], $data['mdpUtil'],$data['adresseUtil']);

        }

        $_SESSION['compteCourrant'] = $compte;
        $s = '<div class="container"><div class="content_element"><a href="?action=pageCompte"> ' . $touite->prenom . " " . $touite->nom . "</a><div>" . $touite->contenu . "</div>" . "Likes : " . $touite->note . " " . "date :" . $touite->date . '</br></div></a>';
        return $s;
    }
}