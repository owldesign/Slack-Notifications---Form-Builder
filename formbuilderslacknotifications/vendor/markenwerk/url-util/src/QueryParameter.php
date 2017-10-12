<?php

namespace Markenwerk\UrlUtil;

/**
 * Class QueryParameter
 *
 * @package Markenwerk\UrlUtil
 */
class QueryParameter implements QueryParameterInterface
{

	/**
	 * @var string
	 */
	private $key;

	/**
	 * @var mixed
	 */
	private $value;

	/**
	 * QueryParameter constructor.
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	public function __construct($key, $value)
	{
		$this
			->setKey($key)
			->setValue($value);
	}

	/**
	 * @return string
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * @param string $key
	 * @return $this
	 */
	public function setKey($key)
	{
		if (!is_string($key)) {
			$argumentType = (is_object($key)) ? get_class($key) : gettype($key);
			throw new \InvalidArgumentException('Expected query parameter names as string; got ' . $argumentType);
		}
		$this->key = $key;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @return string
	 */
	public function getEscapedValue()
	{
		return urlencode((string)$this->value);
	}

	/**
	 * @param mixed $value
	 * @return $this
	 */
	public function setValue($value)
	{
		if (!is_scalar($value)) {
			$argumentType = (is_object($value)) ? get_class($value) : gettype($value);
			throw new \InvalidArgumentException('Expected query parameter value as scalar; got ' . $argumentType);
		}
		$this->value = $value;
		return $this;
	}

}
