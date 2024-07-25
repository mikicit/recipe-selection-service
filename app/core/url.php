<?php

/**
 * Url
 * 
 * This class is responsible for working with urls. 
 * Includes helper methods for getting urls, for parsing and manipulating query variables.
 */
class Url
{
	/**
	 * This method converts a relative public path to an absolute one and returns a url.
	 * 
	 * @param string $path
	 * 
	 * @return string
	 */
	public static function getUrl(string $path = '/') 
	{
		return BASE_URL . $path;
	}

	/**
	 * This method returns the actual url of the request.
	 * 
	 * @return string
	 */
	public static function getCurrentUrl()
	{
		return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	}

	/**
	 * This method parses the url and returns a query string.
	 * 
	 * @param string $url
	 * 
	 * @return string
	 */
	public static function getVars(string $url)
	{
		$parsed_url = parse_url($url);
		return isset($parsed_url['query']) ? $parsed_url['query'] : '';
	}

	/**
	 * This method parses the query string and sets or updates the new query variables passed as the second argument.
	 * 
	 * @param string $url
	 * @param array $query_vars
	 * 
	 * @return string
	 */
	public static function setVars(string $url, array $query_vars) {
		$query_string = self::getVars($url);
		$current_vars = self::varsToArray($query_string);
		$new_url = strtok($url, '?');

		$current_vars = array_merge($current_vars, $query_vars);

		if (!empty($current_vars)) {
			$new_url .= '?' . self::varsToString($current_vars);
		}

		return $new_url;
	}

	/**
	 * This method converts an array of queries to a query string.
	 * 
	 * @param array $query_vars
	 * 
	 * @return string
	 */
	public static function varsToString(array $query_vars)
	{
		return http_build_query($query_vars, '', '&amp;');
	}

	/**
	 * This method converts a query string to an array of query variables.
	 * 
	 * @param string $query_string
	 * 
	 * @return array
	 */
	public static function varsToArray(string $query_string)
	{
		parse_str($query_string, $result);
		return $result;
	}
}