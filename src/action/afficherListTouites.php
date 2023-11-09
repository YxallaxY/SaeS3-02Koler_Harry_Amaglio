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
        $s = $s . "<h2>Affiche les touite les plus recent</h2>";

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
            $s = $s . "<div class='content_element'><br>" . $touites[$indice]->nom . " " . $touites[$indice]->prenom . "</br>" . $touites[$indice]->contenu . "</br>" . "Likes : " . $touites[$indice]->note . " " . "date :" . $touites[$indice]->date . '</br></div>';
            $indice += 1;
            //$s = $s . "<div class='content_element'><br>" . $data['idTouite'] . " " . $data['idUtil'] . "</br>" . $data['contenuTouite'] . "</br>" . "Likes : " . $data['note'] . " " . "date :" . $data['datePubli'] . "</br></div>";
        }
        if (sizeof($touites) == 10) {
            $i = $i+10;
            $s = $s . "<a href='?action=afficherListTouites&start=$i'><button class='page'>next</button> </a>";
        } else {
            if (isset($_GET["start"])) {
                if ($_GET["start"] >= 10) {
                    $i = $i-10;
                    $s = $s . "<a href='?action=afficherListTouites&start=$i'><button class='page'>prev</button> </a>";
                }
            }
        }
        $s = $s .'</div>';
        $s = $s . <<<TEXT
                <script>
                window.addEventListener('load', (event) => {
                let boutounAv = document.querySelectorAll('#avancer');
                let divCont = document.querySelectorAll('.content_element');
                divCont.forEach(item => {
                    item.addEventListener('click', (event) => (window.location = '?action=defaultAction.php'))}
                    );
                });</script>
                TEXT;

        return $s;
    }
}