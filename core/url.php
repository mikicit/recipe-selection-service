<?php

/**
 * [Description Url]
 */
class Url
{
	/**
	 * @param string $path
	 * 
	 * @return string
	 */
	public static function getUrl(string $path = '/') 
	{
		return BASE_URL . $path;
	}

	/**
	 * @return string
	 */
	public static function getCurrentUrl()
	{
		return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	}

	/**
	 * @param string $url
	 * 
	 * @return [type]
	 */
	public static function getVars(string $url)
	{
		$parsed_url = parse_url($url);
		return $parsed_url['query'];
	}

	/**
	 * @param string $url
	 * @param array $query_vars
	 * 
	 * @return string
	 */
	public static function setVars(string $url, array $query_vars) {
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

	/**
	 * @param array $query_vars
	 * 
	 * @return string
	 */
	public static function varsToString(array $query_vars)
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

	/**
	 * @param string $query_string
	 * 
	 * @return array
	 */
	public static function varsToArray(string $query_string)
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