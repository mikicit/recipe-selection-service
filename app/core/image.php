<?php

/**
 * Image
 * 
 * This class is responsible for working with the image. 
 * Includes both direct methods for working with the image itself and auxiliary methods.
 */
class Image
{
	/**
	 * This function resizes the image, taking into account its orientation as well.
	 * 
	 * @static
	 * @param string $path
	 * @param string $to
	 * @param int $new_width
	 * @param int $new_height
	 * 
	 * @return bool Depends on imagejpeg function
	 */
	public static function resize(string $path, string $to, int $new_width, int $new_height)
	{
		list($width, $height, $extension) = getimagesize($path); // only jpeg :(

		$image = imagecreatefromjpeg($path);
		$ratio = $width / $height;
		$new_ration = $new_width / $new_height;

		if ($ratio >= $new_ration) {
			$image = imagescale($image, -1, $new_height);
			$image = imagecrop($image, ['x' => (imagesx($image) - $new_width) / 2, 'y' => 0, 'height' => $new_height, 'width' => $new_width]);
		} else {
			$image = imagescale($image, $new_width);
			$image = imagecrop($image, ['x' => 0, 'y' => (imagesy($image) - $new_height) / 2, 'height' => $new_height, 'width' => $new_width]);
		}

        // Create a directory if it does not exist
        if (!file_exists(dirname($to))) {
            mkdir(dirname($to), 0777, true);
        }

		return imagejpeg($image, $to, 75);
	}

	/**
	 * This function returns the original or a reduced version of the image. 
	 * In the case of a thumbnail image, it first searches for them in the cache, 
	 * if the image was found, then it returns a link to it, if not, then decreases it, 
	 * puts it in the cache and returns the link.
	 * 
	 * @static
	 * @param string $url
	 * @param int $width
	 * @param int $height
	 * 
	 * @return string Returns the public path to the image or an empty string if the image was not found or could not be processed.
	 */
	public static function getImage(string $url, int $width = 0, int $height = 0)
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

		$result = self::resize($local_original, $local_cached, $width, $height);

		if ($result) {
			return $public_cached;
		}

		return '';
	}
}