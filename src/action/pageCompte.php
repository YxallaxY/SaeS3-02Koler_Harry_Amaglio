<?php

namespace touiteur\action;

use touiteur\compte\compteUtil;
use touiteur\message\touite;

require_once 'vendor/autoload.php';

class pageCompte
{
    public function __construct()
    {

    }


    public function execute()
    {
        session_start();
        $pdo = \touiteur\bd\ConnectionFactory::makeConnection();

        $compte = new compteUtil("amaglio", "matias", "123456", "matias@ama.com");
        $s = "<div class = container><h2>" . $compte->prenomUtil . "  " . $compte->nomUtil . "</h2>";
        $query = $pdo->query('SELECT * FROM `touite` Inner join Utilisateur on utilisateur.idUtil = touite.idUtil
                       Inner join email on email.idutil = touite.idutil 
                       WHERE adresseUtil = "' . $compte->emailUtil . '" ORDER BY datePubli desc');
        $s = $s . "<div id='pageDiv'>";
        $touites = [];
        $indice = 0;
        $s = $s . "<div> <p id='pageContenue'>Touite Perso</p>";
        while ($data = $query->fetch()) {
            $touites[$indice] = new touite($data['nomUtil'], $data['prenomUtil'], $data['contenuTouite'], $data['datePubli'], $data['note']);
            $s = $s . "<a href='?action=afficherTouite&courrant=$indice'><div class='content_element' xmlns=\"http://www.w3.org/1999/html\">" . $touites[$indice]->nom . " " . $touites[$indice]->prenom ."<div class='boxPage'>".$touites[$indice]->contenu . "</div> Likes : " . $touites[$indice]->note . " " . "date :" . $touites[$indice]->date . '</br></div></a>';
            $indice += 1;
        }
        $s = $s . "</div>";

        $query = $pdo->query("SELECT * FROM `touite` Inner join Utilisateur on utilisateur.idUtil = touite.idUtil
                                        INNER JOIN htags on touite.idTouite = htags.idTouite 
						                Inner join suittag on suittag.idTag = htags.idTag
                                        where suittag.idUtil = (Select idUtil from email where adresseUtil = '" . $compte->emailUtil . "')");
        $s = $s . "<div><p id='pageContenue'>Tag Abonné</p>";
        while ($data = $query->fetch()) {
            $touites[$indice] = new touite($data['nomUtil'], $data['prenomUtil'], $data['contenuTouite'], $data['datePubli'], $data['note']);
            $s = $s . "<a href='?action=afficherTouite&courrant=$indice'><div class='content_element' xmlns=\"http://www.w3.org/1999/html\">" . $touites[$indice]->nom . " " . $touites[$indice]->prenom . "<div class='boxPage'>" . $touites[$indice]->contenu . "</div>Likes : " . $touites[$indice]->note . " " . "date :" . $touites[$indice]->date . '</br></div></a>';
            $indice += 1;
        }
        $s = $s . "</div>";
        $query = $pdo->query('SELECT * FROM `touite` Inner join Utilisateur on utilisateur.idUtil = touite.idUtil 
                                                      INNER JOIN SuitUtil on SuitUtil.idUtil = touite.idUtil  
                                                      where SuitUtil.idUtilSuivi = (Select idUtil from email where adresseUtil = "' . $compte->emailUtil . '")');
        $s = $s . "<div> <p id='pageContenue'>Personne Suivit</p>";
        while ($data = $query->fetch()) {
            $touites[$indice] = new touite($data['nomUtil'], $data['prenomUtil'], $data['contenuTouite'], $data['datePubli'], $data['note']);
            $s = $s . "<a href='?action=afficherTouite&courrant=$indice'><div class='content_element' xmlns=\"http://www.w3.org/1999/html\">" . $touites[$indice]->nom . " " . $touites[$indice]->prenom . "<div class='boxPage'>" . $touites[$indice]->contenu . "</div>Likes : " . $touites[$indice]->note . " " . "date :" . $touites[$indice]->date . '</br></div></a>';
            $indice += 1;
        }
        $s = $s . "</div>";
        $_SESSION['tabTouite'] = $touites;
        $s = $s . "</div>";

        return $s;
    }

}