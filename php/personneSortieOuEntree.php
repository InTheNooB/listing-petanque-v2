
<?php
include 'connectBDD.php';

// Récupère les informations de la personne
$pk = htmlspecialchars($_POST['a'][0]);
$nom = htmlspecialchars($_POST['a'][1]);
$prenom = htmlspecialchars($_POST['a'][2]);
$adresse = htmlspecialchars($_POST['a'][3]);
$telephone = htmlspecialchars($_POST['a'][4]);

// Change la valeur "present"
$present = 0;

if (htmlspecialchars($_POST['a'][5]) == "true") {
    $present = 1;
}

// Met a jour la table t_personne (present / non present)
$req = getBDD()->prepare("UPDATE t_personne SET present=$present WHERE pk_personne='$pk'");
$req->execute();

if ($present == 1) {
    // Si la personne arrive, on crée un t_presence

    // Récupère la date actuelle
    $date = date("Y-m-d H:i:s");

    $req = getBDD()->prepare("INSERT INTO t_presence(fk_personne,heure_debut) VALUES('$pk', '$date')");
    $req->execute();

    // Récupère la pk de la présence créée
    $req = getBDD()->prepare("SELECT * FROM t_presence ORDER BY pk_presence DESC");
    $req->execute();

    // Récupère les infos de la presence
    $added_presence = $req->fetch(PDO::FETCH_ASSOC);
    $pk_presence = $added_presence['pk_presence'];

    // Et on update la FK chez la personne
    $req = getBDD()->prepare("UPDATE t_personne SET fk_presence=$pk_presence WHERE pk_personne='$pk'");
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
} else {
    // Si la personne part, on met fin à la t_presence actuel

    // On récupère la pk_presence actuelle
    $req = getBDD()->prepare("SELECT * FROM t_presence WHERE heure_fin IS NULL AND fk_personne='$pk'");
    $req->execute();
    $last_presence = $req->fetch(PDO::FETCH_ASSOC);
    $pk_presence = $last_presence['pk_presence'];

    // Récupère la date actuelle
    $date = date("Y-m-d H:i:s");

    $req = getBDD()->prepare("UPDATE t_presence SET heure_fin='$date' WHERE pk_presence='$pk_presence'");
    $req->execute();

    // Et on change la fk de la personne 
    $req = getBDD()->prepare("UPDATE t_personne SET fk_presence=NULL WHERE pk_personne='$pk'");
    $req->execute();
}



?>