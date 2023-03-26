<?php
/**
 * @format
 */

try {
    $db = mysqli_connect("localhost", "root", "", "ventas_ms");
    if (!$db) {
        throw new Exception(mysqli_connect_error());
    }
} catch (Exception $e) {
    echo "<div class='ui error message'>
          <div class='header'>Error de conexión</div>
          <p>" .
        $e->getMessage() .
        "</p>
        </div>";
}
