<?php

namespace touiteur\dispatch;

use touiteur\action as Action;

require_once 'vendor/autoload.php';

class dispatcher
{
    private string $action = "";

    public function __construct()
    {
        if (isset($_GET["action"])) {
            $this->action = $_GET["action"];
        }

    }

    public function run(): void
    {
        switch ($this->action) {
            case("afficherListTouites"):
                $action_class = new Action\afficherListTouites();
                break;
            case("connexion"):
                $action_class = new Action\Connexion();
                break;
            case("inscription"):
                $action_class = new Action\Inscription();
                break;
            case("afficherTouite"):
                $action_class = new Action\afficherTouite();
                break;
            case("pageCompte"):
                $action_class = new Action\pageCompte();
                break;
            case("ecrireTouite"):
                $action_class = new Action\ecrireTouite();
                break;
            default:
                $action_class = new Action\defaultAction();
                break;

        }

        $html = $action_class->execute();

        $this->renderPage($html);
    }

    private function renderPage(string $html): void
    {
        echo $html;
    }
}





