<?php

namespace touiteur\action;

use touiteur\bd\ConnectionFactory;
use touiteur\message\touite;

require_once 'vendor/autoload.php';

class afficherListTouites
{
    public function __construct()
    {

    }

    public function execute(): string
    {
        session_start();

        $s = '<div class="container">';
        $s = $s . "<h2>Affiche les touites les plus récents</h2>";

        $pdo = ConnectionFactory::makeConnection();

        if (isset($_GET["start"])) {
            $i = $_GET["start"];
        } else {
            $i = 0;
        }
        $query = $pdo->query('SELECT * FROM `touite` Inner join Utilisateur on utilisateur.idUtil = touite.idUtil ORDER BY datePubli desc LIMIT 10 OFFSET ' . $i);

        $touites = [];
        $indice = 0;
        while ($data = $query->fetch()) {

            $touites[$indice] = new touite($data['nomUtil'], $data['prenomUtil'], $data['contenuTouite'], $data['datePubli'], $data['note']);
            $s = $s . "<a href='?action=afficherTouite&courrant=$indice'><div class='content_element' xmlns=\"http://www.w3.org/1999/html\">" . $touites[$indice]->nom . " " . $touites[$indice]->prenom . "</br>" . $touites[$indice]->contenu . "</br>" . "Likes : " . $touites[$indice]->note . " " . "date :" . $touites[$indice]->date . '</br></div></a>';
            $indice += 1;
        }
        $_SESSION['tabTouite'] = $touites;
        if (sizeof($touites) == 10) {
            $i = $i + 10;
            $s = $s . "<a href='?action=afficherListTouites&start=$i'><button class='page'>next</button> </a>";
        } else {
            if (isset($_GET["start"])) {
                if ($_GET["start"] >= 10) {
                    $i = $i - 10;
                    $s = $s . "<a href='?action=afficherListTouites&start=$i'><button class='page'>prev</button> </a>";
                }
            }
        }
        $s = $s . '</div>';

        return $s;
    }
}