<?php
require_once 'config/config.php';
require_once 'libs/database.php';

$db = new Database();
$conn = $db->connect();

if ($conn) {
    echo " Conexión a la base de datos 'proyectoweb' exitosa.";
}
?>
