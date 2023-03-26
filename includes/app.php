<?php
/**
 * @format
 */

require "funciones.php";
require "database.php";
require "database_config.php";
require __DIR__ . "/../vendor/autoload.php";

/*  Conectarnos a la base de datos */
use Model\ActiveRecord;
isset($db) ? ActiveRecord::setDB($db) : "";
isset($db_conf) ? ActiveRecord::setDB_config($db_conf) : "";
