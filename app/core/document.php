<?php

/**
 * Document
 * 
 * This object is responsible for managing the basic properties of the document, 
 * such as meta information (title, description), plug-in scripts, styles.
 */
class Document
{
	/**
	 * @var string $title
	 */
	private $title = '';

	/**
	 * @var array $scripts
	 */
	private $scripts = [];

	/**
	 * @var array $styles
	 */
	private $styles = [];

	/**
	 * This method sets the title of the document, 
	 * can be called from anywhere in any controller.
	 * 
	 * @param string $title
	 * 
	 * @return void
	 */
	public function setTitle(string $title)
	{
		$this->title = $title;
	}

	/**
	 * This method returns the actual title of the document,
	 * can be called from anywhere in any controller.
	 * 
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Adds links to pluggable scripts with attributes.
	 * 
	 * @param string $url
	 * @param array $attributes
	 * 
	 * @return void
	 */
	public function addScript(string $url, array $attributes = [])
	{
		$this->scripts[] = [
			'href' => $url,
			'attributes' => $this->attrsToString($attributes)
		];
	}

	/**
	 * Returns an array of scripts with attributes.
	 * 
	 * @return array
	 */
	public function getScripts()
	{
		return $this->scripts;
	}

	/**
	 * Adds links to pluggable styles with attributes.
	 * 
	 * @param string $url
	 * @param array $attributes
	 * 
	 * @return void
	 */
	public function addStyle(string $url, array $attributes = [])
	{
		$this->styles[] = [
			'href' => $url,
			'attributes' => $this->attrsToString($attributes)
		];
	}

	/**
	 * Returns an array of styles with attributes.
	 * 
	 * @return array
	 */
	public function getStyles()
	{
		return $this->styles;
	}

	/**
	 * Helper method for converting an array of attributes to a string.
	 * 
	 * @param array $attributes
	 * 
	 * @return string
	 */
	private function attrsToString(array $attributes)
	{
		$attributes_string = '';

		foreach ($attributes as $key => $value) {
			$attributes_string .= $key . '="' . $value . '" ';
		}

		return $attributes_string;
	}
}