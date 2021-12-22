<?php

/**
 * [Description Image]
 */
class Image
{
	/**
	 * @param string $path
	 * @param string $to
	 * @param int $new_width
	 * @param int $new_height
	 * 
	 * @return [type]
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

		return imagejpeg($image, $to, 75);
	}
}