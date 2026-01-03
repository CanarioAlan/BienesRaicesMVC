<?php
function conectarDB(): mysqli
{
    $db = new mysqli("localhost", "root", "9056", "bienraices_crud");

    if (!$db) {
        echo "Error al conetar";
        exit;
    }
    return $db;
}
