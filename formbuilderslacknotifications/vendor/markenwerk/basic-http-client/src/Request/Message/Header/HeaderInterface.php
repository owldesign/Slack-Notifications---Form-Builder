<?php

namespace Markenwerk\BasicHttpClient\Request\Message\Header;

/**
 * Interface HeaderInterface
 *
 * @package Markenwerk\BasicHttpClient\Request\Message\Header
 */
interface HeaderInterface
{

	/**
	 * Header constructor.
	 *
	 * @param string $name
	 * @param string[] $values
	 */
	public function __construct($name, array $values);

	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @return string
	 */
	public function getNormalizedName();

	/**
	 * @param string $name
	 * @return $this
	 */
	public function setName($name);

	/**
	 * @return string[]
	 */
	public function getValues();

	/**
	 * @return string
	 */
	public function getValuesAsString();

	/**
	 * @param string[] $values
	 * @return $this
	 */
	public function setValues($values);

}
