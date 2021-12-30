<?php
function getBDD()
{
    $_bdd = new PDO('mysql:host=f99e8.myd.infomaniak.com;dbname=f99e8_petanque_v2;charset=utf8', 'f99e8_admin', 'U4QfuewjaQKF');
    $_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    return $_bdd;
}

?>
