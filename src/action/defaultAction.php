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
        echo "<h2>Affiche les 10 touite avec le plus de like</h2></br>";

        $query = $pdo->query('SELECT * FROM `touite` ORDER BY note desc limit 10');
        while ($data = $query->fetch()) {
            echo $data['contenue'] . " </br>";
        }

        $s = '';
        return $s;
    }
}
