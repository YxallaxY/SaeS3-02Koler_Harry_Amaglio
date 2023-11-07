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
            default:
                $action_class = new Action\DefaultAction();

        }

        $html = $action_class->execute();

        $this->renderPage($html);
    }

    private function renderPage(string $html): void
    {
        echo $html;
    }
}





