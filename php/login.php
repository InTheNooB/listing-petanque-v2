<?php
session_start();
include 'connectBDD.php';

// Recupère les infos
$pass = $_POST['inputPass'];
$login = $_POST['inputLogin'];

// Encode le mot de passe 10 fois
for ($i = 0; $i < 10; $i++) {
    $pass = hash('sha512', $pass);
}

// Control si les identifiants sont correctes
if (($login == "1521") && ($pass == "46e64fce6aa16e1e9436498e856619724404afa095c639b1b2538ef509095e44e752f21525f2657ff25baa997adf2f3eaede4e2cbf1b3885aa1d449f035695a0")) {
    $_SESSION['logged'] = true;
    $_SESSION['wrongLogin'] = false;
    header('Location: ./main.php');
} else {
    $_SESSION['logged'] = false;
    $_SESSION['wrongLogin'] = true;
    header('Location: ../index.php');
}
?>
