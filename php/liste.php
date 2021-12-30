<?php

include 'connectBDD.php';

$req = getBDD()->prepare("SELECT * FROM t_personne");
$req->execute();

$personne = $req->fetchAll();

$filteredData = "";

foreach($personne as $p) {
    $filteredData = $filteredData . $p['pk_personne'] . ",";
    $filteredData = $filteredData . $p['nom'] . ",";
    $filteredData = $filteredData . $p['prenom'] . ",";
    $filteredData = $filteredData . $p['adresse'] . ",";
    $filteredData = $filteredData . $p['telephone'] . ",";
    $filteredData = $filteredData . $p['present'] . ";";
}


echo substr($filteredData, 0, -1);

?>