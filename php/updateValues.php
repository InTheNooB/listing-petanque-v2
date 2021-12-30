
<?php
include 'connectBDD.php';

// Compte le nombre de personnes dans la fete
$req = getBDD()->prepare("SELECT COUNT(*) FROM t_personne WHERE present=1");
$req->execute();

$nombrePresent = $req->fetchColumn();

// Récupère le compteur
$req = getBDD()->prepare("SELECT * FROM t_compteur");
$req->execute();

$compteur = $req->fetch(PDO::FETCH_ASSOC);

// Compte le nombre de personne total
$req = getBDD()->prepare("SELECT COUNT(*) FROM  t_personne");
$req->execute();

$nombreTotal = $req->fetchColumn();

// Filtre les données
$filteredData = $nombrePresent . "," . $compteur['nombreMax'] . "," . $nombreTotal;

echo $filteredData;

?>