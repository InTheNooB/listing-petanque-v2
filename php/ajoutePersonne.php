<?php

header('Location:./main.php');

include 'connectBDD.php';

// Récupère ses infos
$nom =  htmlspecialchars($_POST['inputNom']);
$prenom =  htmlspecialchars($_POST['inputPrenom']);
$adresse =  htmlspecialchars($_POST['inputAdresse']);
$telephone =  htmlspecialchars($_POST['inputTelephone']);


// Ajoute la personne
$req = getBDD()->prepare("INSERT INTO t_personne(nom, prenom, adresse, telephone,present) VALUES('$nom', '$prenom', '$adresse', '$telephone', 1)");
$req->execute();

// Récupère la personne créée
$req = getBDD()->prepare("SELECT * FROM t_personne WHERE nom='$nom' AND prenom='$prenom' AND adresse='$adresse' AND telephone='$telephone' AND present=1");
$req->execute();

// Récupère les infos pour créer la présence
$added_personne = $req->fetch(PDO::FETCH_ASSOC);
$pk_personne = $added_personne['pk_personne'];

// Crée la présence avec l'heure actuelle

$date = date("Y-m-d H:i:s");

$req = getBDD()->prepare("INSERT INTO t_presence(fk_personne,heure_debut) VALUES('$pk_personne', '$date')");
$req->execute();

// Récupère la pk de la présence créée
$req = getBDD()->prepare("SELECT * FROM t_presence ORDER BY pk_presence DESC");
$req->execute();

// Récupère les infos de la presence
$added_presence = $req->fetch(PDO::FETCH_ASSOC);
$pk_presence = $added_presence['pk_presence'];

// Update la fk_presence de la personne
$req = getBDD()->prepare("UPDATE t_personne SET fk_presence=$pk_presence WHERE nom='$nom' AND prenom='$prenom' AND adresse='$adresse' AND telephone='$telephone'");
$req->execute();

// On update le compteur si on a dépasser le nombre max de personnes en même temps
//1. Récupéré le nombre max actuel
$req = getBDD()->prepare("SELECT * FROM t_compteur");
$req->execute();
$compteur = $req->fetch(PDO::FETCH_ASSOC);
$maxActuel = $compteur['nombreMax'];

//2. Récupéré le nombre de personnes actuellement en fête
$req = getBDD()->prepare("SELECT COUNT(*) FROM t_personne WHERE present=1");
$req->execute();

$nombrePresent = $req->fetchColumn();

//3. Si ce nombre est plus élevé, alors on update le compteur
if ($nombrePresent > $maxActuel) {
    $req = getBDD()->prepare("UPDATE t_compteur SET nombreMax=$nombrePresent");
    $req->execute();
}
