<?php

namespace touiteur\action;

require_once 'vendor/autoload.php';

class afficherListTouites
{
    public function __construct()
    {

    }

    public function execute(): string
    {
        $pdo = \touiteur\bd\ConnectionFactory::makeConnection();
        $s = "<h2>Affiche les touite les plus recent</h2></br>";

        $query = $pdo->query('SELECT * FROM `touite` ORDER BY datePubli desc');
        $s = $s . "<div class='container'>";
        while ($data = $query->fetch()) {
            $s = $s . "<div class='content_element'><br>" . $data['idTouite'] . " " . $data['idUtil'] . "</br>" . $data['contenueTouite'] . "</br>" . "Likes : " . $data['note'] . " " . "date :" . $data['datePubli'] . "</br></div>";
        }
        $s = $s . "</div>";


        $s = $s .
            "<script>
                window.addEventListener('load', (event) => {
                let divCont = document.querySelectorAll('.content_element');
                divCont.forEach(item => {
                    item.addEventListener('click', (event) => (window.location = '?action=defaultAction.php'))}
                    );
                });</script>";


        return $s;
    }
}