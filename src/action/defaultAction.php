<?php

namespace touiteur\action;

require_once 'vendor/autoload.php';

class defaultAction
{
    public function __construct()
    {

    }

    public function execute(): string
    {
        //inserere un touite
        ////$pdo->query("INSERT INTO touite (idUtil,tailleT,datePubli,chemin,note,contenue) VALUES (1,36,07/11/23,'blabla',36,'Touite de test #SALUT #SAE');");

        $pdo = \touiteur\bd\ConnectionFactory::makeConnection();
        $s="";

        $query = $pdo->query('SELECT * FROM `touite` ORDER BY note desc limit 10');
        $s = $s . "<div class='container'>";
        $s = $s . "<h2>Affiche les 10 touite avec le plus de like</h2>";
        while ($data = $query->fetch()) {
            $s = $s . "<div class='content_element'>" . $data['idTouite'] . " " . $data['idUtil'] . "</br>" . $data['contenuTouite'] . "</br>" . "Likes : " . $data['note'] . " " . "date :" . $data['datePubli'] . "</br></div>";
        }
        $s = $s . "</div>";
        return $s;
    }
}
