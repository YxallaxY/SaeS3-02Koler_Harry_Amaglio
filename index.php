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


$salut = new \touiteur\message\touite("Matias", "Touite de test #SALUT #SAE", "07/11/2023");
foreach ($salut->tag as $vp){
    echo $vp."</br>";
}

$dispach = new \touiteur\dispatch\dispatcher();
$dispach->run();



