<?php

namespace touiteur\action;

use touiteur\compte\compteUtil;
use touiteur\message\touite;
use touiteur\bd\ConnectionFactory;

require_once 'vendor/autoload.php';

class ecrireTouite
{
    public function execute(): string
    {
        session_start();
        $s = "";
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $bd = ConnectionFactory::makeConnection();

            $touite = new touite($_POST['Nom'], $_POST['Prenom'], $_POST['contenu'], $_POST['date']);
            $taille = $touite->tailleTouite($touite->contenu);
            $st = $bd->prepare(<<<TOUITE
INSERT INTO touite (idUtil,tailleTouite,contenuTouite,datePubli,note) VALUES ((Select utilisateur.idUtil from email INNER JOIN utilisateur on utilisateur.idUtil = email.idUtil where nomUtil = '$touite->nom' AND prenomUtil ='$touite->prenom' ),$taille,'$touite->contenu','$touite->date ',$touite->note )

TOUITE);
            $st->execute();
            $s = "message publié";
        } else {
            if (isset($_SESSION['connection'])) {
                $s = $s . '<form id="f1" action="?action=ecrireTouite" method="post">
                <input type="text" name = "Nom" placeholder="<Nom>" >
                <input type="text" name = "Prenom" placeholder="<Prenom>" >
                <input type="text" name = "contenu" placeholder="<contenu>" >
                <input type="date" name = "date" placeholder="date" >
                <button type="submit">Valider</button>
              </form>';
            } else {
                $s .= '<a href="?action=pageCompte">
                        <button class="bouton">Page perso</button>
                        </a>';
            }
        }


        return $s;
    }
}