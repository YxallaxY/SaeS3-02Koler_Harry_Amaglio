<?php

namespace touiteur\action;

require_once 'vendor/autoload.php';

class DefaultAction{
    public function __construct()
    {

    }

    public function execute():string
    {
        $s = "<h2>Action par défaut</h2>";
        return $s;
    }
}
