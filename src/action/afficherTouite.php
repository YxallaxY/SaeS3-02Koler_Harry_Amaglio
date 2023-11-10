<?php

namespace touiteur\action;

require_once 'vendor/autoload.php';
class afficherTouite
{
    public function __construct()
    {

    }

    public function execute(): string
    {
        session_start();

        $touite = $_SESSION['tabTouite'][$_GET['courrant']];

        $s= '<div class="container"><div class="content_element">'. $touite->nom . " " . $touite->prenom . "<div>" . $touite->contenu . "</div>" . "Likes : " . $touite->note . " " . "date :" . $touite->date . '</br></div></a>';
        return $s;
    }
}