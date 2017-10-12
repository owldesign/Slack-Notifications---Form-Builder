<?php

namespace Markenwerk\UrlUtil;

/**
 * Interface UrlInterface
 *
 * @package Markenwerk\UrlUtil
 */
interface UrlInterface
{

	const URL_SCHEME_SEPARATOR = '://';
	const URL_CREDENTIALS_SEPARATOR = ':';
	const URL_AUTHENTICATION_SEPARATOR = '@';
	const URL_PORT_SEPARATOR = ':';
	const URL_QUERYSTRING_SEPARATOR = '?';
	const URL_QUERY_SEPARATOR = '&';
	const URL_FRAGMENT_SEPARATOR = '#';

	/**
	 * Url constructor.
	 *
	 * @param string $url
	 */
	public function __construct($url = null);

	/**
	 * @param string $url
	 * @return $this
	 */
	public function parseUrl($url);

	/**
	 * @param string $queryString
	 * @return $this
	 */
	public function parseQueryString($queryString);

	/**
	 * @return string
	 */
	public function buildUrl();

	/**
	 * @return string
	 */
	public function buildQueryString();

	/**
	 * @return string
	 */
	public function getScheme();

	/**
	 * @return bool
	 */
	public function hasScheme();

	/**
	 * @param string $scheme
	 * @return $this
	 */
	public function setScheme($scheme);

	/**
	 * @return string
	 */
	public function getHostname();

	/**
	 * @return bool
	 */
	public function hasHostname();

	/**
	 * @param string $hostname
	 * @return $this
	 */
	public function setHostname($hostname);

	/**
	 * @return int
	 */
	public function getPort();

	/**
	 * @return bool
	 */
	public function hasPort();

	/**
	 * @param int $port
	 * @return $this
	 */
	public function setPort($port);

	/**
	 * @return string
	 */
	public function getPath();

	/**
	 * @return bool
	 */
	public function hasPath();

	/**
	 * @param string $path
	 * @return $this
	 */
	public function setPath($path);

	/**
	 * @return QueryParameterInterface[]
	 */
	public function getQueryParameters();

	/**
	 * @return bool
	 */
	public function hasQueryParameters();

	/**
	 * @return int
	 */
	public function countQueryParameters();

	/**
	 * @param QueryParameterInterface[] $queryParameters
	 * @return $this
	 */
	public function setQueryParameters(array $queryParameters);

	/**
	 * @param mixed[] $queryParameters
	 * @return $this
	 */
	public function setQueryParametersFromArray(array $queryParameters);

	/**
	 * @param QueryParameterInterface $queryParameter
	 * @return $this
	 */
	public function addQueryParameter(QueryParameterInterface $queryParameter);

	/**
	 * @param QueryParameterInterface $queryParameter
	 * @return $this
	 */
	public function removeQueryParameter(QueryParameterInterface $queryParameter);

	/**
	 * @param string $key
	 * @return $this
	 */
	public function removeQueryParameterByKey($key);

	/**
	 * @return $this
	 */
	public function clearQueryParameters();

	/**
	 * @return string
	 */
	public function getUsername();

	/**
	 * @return bool
	 */
	public function hasUsername();

	/**
	 * @param string $username
	 * @return $this
	 */
	public function setUsername($username);

	/**
	 * @return string
	 */
	public function getPassword();

	/**
	 * @return bool
	 */
	public function hasPassword();

	/**
	 * @param string $password
	 * @return $this
	 */
	public function setPassword($password);

	/**
	 * @return string
	 */
	public function getFragment();

	/**
	 * @return bool
	 */
	public function hasFragment();

	/**
	 * @param string $fragment
	 * @return $this
	 */
	public function setFragment($fragment);

}
