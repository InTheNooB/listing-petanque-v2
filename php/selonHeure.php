<?php
include 'connectBDD.php';

$h = new DateTime($_POST['heureChoisie']);

// Calcul l'heure pour correspondre à la DB
$dateDebut = date_format($h, "Y-m-d H:i:s");
$dateFin = $h->add(new DateInterval('PT1H'));
$dateFin = date_format($h, "Y-m-d H:i:s");

// Récupère tous les entrés de t_presence qui correspondent
$req = getBDD()->prepare("SELECT DISTINCT fk_personne FROM t_presence WHERE heure_debut >= '$dateDebut' AND heure_fin <= '$dateFin'");
$req->execute();
$results = $req->fetchAll();

$filteredData ="";

foreach ($results as $p) {
    $pk = $p['fk_personne'];
    // Récupère toutes les personnes concernés
    $req = getBDD()->prepare("SELECT * FROM t_personne WHERE pk_personne='$pk'");
    $req->execute();
    $personne = $req->fetchAll();
    
    $filteredData = $filteredData . $personne[0]['pk_personne'] . ",";
    $filteredData = $filteredData . $personne[0]['nom'] . ",";
    $filteredData = $filteredData . $personne[0]['prenom'] . ",";
    $filteredData = $filteredData . $personne[0]['adresse'] . ",";
    $filteredData = $filteredData . $personne[0]['telephone'] . ",";
    $filteredData = $filteredData . $personne[0]['present'] . ";";
}

echo substr($filteredData, 0, -1);