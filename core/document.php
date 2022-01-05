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
	private $title;

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
}