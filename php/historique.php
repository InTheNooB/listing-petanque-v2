<?php

include 'connectBDD.php';

$pk = $_GET['pk'];

// Récupère la personne dans la DB
$req = getBDD()->prepare("SELECT * FROM t_personne WHERE pk_personne='$pk'");
$req->execute();
$p = $req->fetch(PDO::FETCH_ASSOC);

// Récupère son historique
$req = getBDD()->prepare("SELECT * FROM t_presence WHERE fk_personne='$pk'");
$req->execute();
$historique = $req->fetchAll();

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- DataTable CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../js/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- DataTable JS -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>


    <title>Petanque 2020</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-2">Petanque 2020</h1>
        <p class="text-center mb-5"><a href="../index.php">Retour</a></p>
        <hr>
        <h2 class="text-center mt-2 mb-5"><u>Historique</u></h2>
        <p><b>Nom :</b> <?= $p['nom'] ?></p>
        <p><b>Prenom :</b> <?= $p['prenom'] ?></p>
        <p><b>Adresse :</b> <?= $p['adresse'] ?></p>
        <p><b>Telephone :</b> <?= $p['telephone'] ?></p>
        <div class="row left-content">
            <div class="col-md-auto">
                <p><b>Sur place :</b></p>
            </div>
            <div class="col-md-auto"><?php 
                if ($p['present'] == 1) {
                ?>
                <i style="color: #1cc88a" class="fas fa-check"></i>
                <?php
                } else {
                ?>
                <i style="color: #e74a3b" class="fas fa-times"></i>
                <?
                }
                ?>
            </div>
        </div>
        <hr class="mt-5 mb-5">
        <table id="historiqueTable" class="table">
            <thead>
                <tr>
                    <th scope="col">Période</th>
                    <th scope="col">Arrivé</th>
                    <th scope="col">Départ</th>
                    <th scope="col">Durée</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $dureeTotal = 0;
                foreach ($historique as $index => $h) {
                    echo "<tr>";
                    echo "<td>";
                    echo ($index + 1);
                    echo "</td>";
                    echo "<td>";
                    echo date_format(new DateTime($h['heure_debut']), "l H:i");
                    echo "</td>";
                    echo "<td>";
                    if ($h['heure_fin'] != "") {
                        echo date_format(new DateTime($h['heure_fin']), "l H:i");
                    }
                    echo "</td>";
                    echo "<td>";
                    if ($h['heure_fin'] != "") { 
                        $start_date = new DateTime($h['heure_debut']);
                        $since_start = $start_date->diff(new DateTime($h['heure_fin']));
                        $minutes = $since_start->days * 24 * 60;
                        $minutes += $since_start->i;
                        $dateTime = new DateTime($since_start->h.':'.$minutes);
                        echo date_format($dateTime, "H:i");
                        $dureeTotal += $minutes + ($since_start->h * 60);
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                
                echo "<tr>";
                echo "<td>";
                echo "</td>";
                echo "<td>";
                echo "</td>";
                echo "<td>";
                echo "</td>";
                echo "<td>";
                $dateTime = new DateTime(((int) ($dureeTotal / 60)).':'.$dureeTotal % 60);
                echo "<b>Total : ". date_format($dateTime, "H:i") . "</b>";
                echo "</td>";
                echo "</tr>";
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>