<?php
/**
 * @format
 */

try {
    $db_conf = mysqli_connect("localhost", "root", "", "sistem_confg");
    if (!$db_conf) {
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
