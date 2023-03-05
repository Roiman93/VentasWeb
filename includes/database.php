<?php
/**
 * @format
 */

$db = mysqli_connect("localhost", "root", "", "ventas_ms");

if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();

    exit();
}
