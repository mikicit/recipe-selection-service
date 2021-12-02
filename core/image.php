<?php

class Image
{
	public static function resize($path, $to, $new_width, $new_height)
	{
		list($width, $height, $extension) = getimagesize($path); // only jpeg :(

		$image = imagecreatefromjpeg($path);
		$scale = $width / $height;

		if ($scale >= 1) {
			$image = imagescale($image, -1, $new_height);
			$image = imagecrop($image, ['x' => (imagesx($image) - $new_width) / 2, 'y' => 0, 'height' => $new_height, 'width' => $new_width]);
		} else {
			$image = imagescale($image, $new_width);
			$image = imagecrop($image, ['x' => 0, 'y' => (imagesy($image) - $new_height) / 2, 'height' => $new_height, 'width' => $new_width]);
		}

		return imagejpeg($image, $to, 75);
	}
}