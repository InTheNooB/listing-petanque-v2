<?php

session_start();

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
    <script src="js/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- DataTable JS -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <!-- Custom script -->
    <script src="js/script.js"></script>



    <title>Petanque 2020</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-2 mb-5">Petanque 2020</h1>
        <?php

        if ($_SESSION['wrongLogin']) {
        ?>
            <div class='alert alert-danger alert-dismissible fade show'>
                <strong>Error!</strong> Mauvais mot de passe ou login.
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
            </div>
        <?php
        } else if ($_SESSION['connectRequired']) {
            $_SESSION['connectRequired'] = false;
        ?>
            <div class='alert alert-danger alert-dismissible fade show'>
                <strong>Error!</strong> Veuillez vous connecter.
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
            </div>
        <?php
        }

        ?>
        <form method="post" action="./php/login.php">
            <div class="form-group">
                <label for="inputNom">Login</label>
                <input type="text" class="form-control" name="inputLogin" aria-describedby="emailHelp" placeholder="Login">
            </div>
            <div class="form-group">
                <label for="inputPrenom">Password</label>
                <input type="password" class="form-control" name="inputPass" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-success">Connexion</button>
        </form>

        <img src="./assets/logo_jeunesse.png" class="rounded mt-5 img-fluid mx-auto d-block">
    </div>
</body>

</html>