<?php

class Url
{
	public static function getUrl($path = '/') 
	{
		return BASE_URL . $path;
	}

	public static function getCurrentUrl()
	{
		return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	}

	public static function getVars($url)
	{
		$parsed_url = parse_url($url);
		return $parsed_url['query'];
	}

	public static function setVars($url, $query_vars) {
		$parsed_url = parse_url($url);
		$query_string = isset($parsed_url['query']) ? $parsed_url['query'] : '';
		$current_vars = [];
		$new_url = strtok($url, '?');

		if ($query_string) {
			$current_vars = Self::varsToArray($query_string);
		}

		foreach ($query_vars as $key => $value) {
			$current_vars[$key] = $value;
		}

		if ($current_vars) {
			$new_url .= '?' . Self::varsToString($current_vars);
		}

		return $new_url;
	}

	public static function varsToString($query_vars)
	{
		$result = [];

		foreach ($query_vars as $key => $value) {
			if (is_array($value)) {
				foreach ($value as $item) {
					$result[] = "$key=$item";
				}
				continue;
			}

			$result[] = "$key=$value";
		}

		return implode('&', $result);
	}

	public static function varsToArray($query_string)
	{
		$result = [];
		$array_1 = explode('&', $query_string);

		foreach ($array_1 as $value) {
			$array_2 = explode('=', $value);
			$var = $array_2[0];
			$value = $array_2[1];

			if (isset($result[$var])) {
				if (is_array($result[$var])) {
					$result[$var][] = $value;
				} else {
					$result[$var] = [$result[$var]];
					$result[$var][] = $value;
				}

				continue;
			}
			$result[$array_2[0]] = $array_2[1];
		}

		return $result;
	}
}