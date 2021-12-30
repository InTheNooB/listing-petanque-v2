<?php

session_start();
if ($_SESSION['logged'] == false) {
    $_SESSION['connectRequired'] = true;
    header('Location: ../index.php');
}

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

    <!-- Custom script -->
    <script src="../js/script.js"></script>

    <title>Petanque 2020</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-2">Petanque 2020</h1>
        <p class="text-center mb-5"><a href="../html/explications.html">Explications</a></p>
        <form method="post" action="./ajoutePersonne.php">
            <div class="form-group">
                <label for="inputNom">Nom</label>
                <input type="text" class="form-control" name="inputNom" aria-describedby="emailHelp" placeholder="Nom">
            </div>
            <div class="form-group">
                <label for="inputPrenom">Prenom</label>
                <input type="text" class="form-control" name="inputPrenom" placeholder="Prenom">
            </div>
            <div class="form-group">
                <label for="inputAdresse">Adresse</label>
                <input type="text" class="form-control" name="inputAdresse" placeholder="Adresse">
            </div>
            <div class="form-group">
                <label for="inputTelephone">Telephone</label>
                <input type="text" class="form-control" name="inputTelephone" placeholder="Telephone">
            </div>
            <button type="submit" class="btn btn-success">Ajouter</button>
        </form>

        <h5 class="text-center mt-4 mb-2 text-danger">Rechargez le site régulièrement pour s'assuré de voir des données à jour</h5>

        <div class="row justify-content-md-center mt-5 mb-5">
            <div class="col-md text-center">
                <button id="buttonListe" type="button" class="btn btn-primary btn-block">Voir Liste</button>
            </div>
        </div>

        <div class="row justify-content-md-center mt-5 mb-5">
            <div class="col-md text-center">
                <button id="buttonInfos" type="button" class="btn btn-info btn-block">Voir Informations</button>
            </div>
            <div class="col-md text-center">
                <button id="buttonHeure" type="button" class="btn btn-info btn-block">Selon heure</button>
            </div>
        </div>

        <div id="liste">
        </div>
        
        <img src="../assets/logo_jeunesse.png" class="rounded mt-5 img-fluid mx-auto d-block">
    </div>
</body>

</html>