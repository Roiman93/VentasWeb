<?php
namespace Classes;

class Cache
{
	protected static $cacheDir = __DIR__ . "\..\public\cache";

	public function __construct($cacheDir)
	{
	}

	public static function get($key)
	{
		$filename = self::getFilename($key);
		if (file_exists($filename)) {
			$data = unserialize(file_get_contents($filename));
			if ($data["ttl"] == 0 || time() < $data["ttl"]) {
				return $data["value"];
			} else {
				self::delete($key);
			}
		}
		return null;
	}

	public static function set($key, $value, $ttl = 0)
	{
		$filename = self::getFilename($key);
		// debuguear($filename);

		// exit();

		$data = [
			"value" => $value,
			"ttl" => $ttl == 0 ? 0 : time() + $ttl,
		];

		file_put_contents($filename, serialize($data));
	}

	public static function delete($key)
	{
		$filename = self::getFilename($key);
		if (file_exists($filename)) {
			unlink($filename);
		}
	}

	protected static function getFilename($key)
	{
		$hash = md5($key);
		$path = implode("/", str_split(substr($hash, 0, 16), 2));
		$full_path = self::$cacheDir . "/" . rtrim($path, "/");

		if (!is_dir($full_path)) {
			mkdir($full_path, 0777, true);
		}

		return $full_path . "/" . $hash . ".cache";
	}
}
