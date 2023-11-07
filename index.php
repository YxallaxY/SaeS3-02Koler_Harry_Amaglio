<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Touiteur</title>
    <link rel="stylesheet" type
    "text/css" href="style.css">
</head>
<body>
<h1>Touiteur</h1>
<div>

<?php

require_once "vendor/autoload.php";


$salut = new \touiteur\message\touite("Matias", "Touite de test", "07/11/2023");
echo $salut->contenu;

$dispach = new \touiteur\dispatch\dispatcher();
$dispach->run();



