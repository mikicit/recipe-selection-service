<?php

class Helper
{
	public static function getImage($url, $width = 0, $height = 0)
	{
		if (!$width && !$height) {
			return $url;
		}
	
		$resized_name = pathinfo($url, PATHINFO_FILENAME) . '-resized-' . $width . '-' . $height . '.' . pathinfo($url, PATHINFO_EXTENSION);
		$local_cached = ROOT . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $resized_name;
		$public_cached = BASE_URL . '/cache/images/' . $resized_name;

		if (file_exists($local_cached)) {
			return $public_cached;
		}

		$local_original = str_replace([BASE_URL, '/'], [ROOT, DIRECTORY_SEPARATOR], $url);

		$result = Image::resize($local_original, $local_cached, $width, $height);

		if ($result) {
			return $public_cached;
		}

		return '';
	}
}