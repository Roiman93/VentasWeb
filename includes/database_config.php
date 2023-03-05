<?php
/**
 * @format
 */

$db_conf = mysqli_connect("localhost", "root", "", "sistem_confg");

if (!$db_conf) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    exit();
}
