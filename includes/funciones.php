<?php
/**
 * @format
 */

function debuguear($variable): string
{
	echo "<pre>";
	var_dump($variable);
	echo "</pre>";
	exit();
}

// Escapa / Sanitizar el HTML
function s($html): string
{
	$s = htmlspecialchars($html);
	return $s;
}

function esUltimo(string $actual, string $proximo): bool
{
	if ($actual !== $proximo) {
		return true;
	}
	return false;
}

// Función que revisa que el usuario este autenticado
function isAuth(): void
{
	if (!isset($_SESSION["login"])) {
		header("Location: /");
	}
}

function isAdmin(): void
{
	if (!isset($_SESSION["admin"])) {
		header("Location: /");
	}
}

/* busca la ruta absoluta de un archivo */
function getAbsolutePath($file_path)
{
	return realpath($file_path);
}
