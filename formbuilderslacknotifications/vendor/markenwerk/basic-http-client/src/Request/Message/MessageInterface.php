<?php

namespace Markenwerk\BasicHttpClient\Request\Message;

use Markenwerk\BasicHttpClient\Request\Base\CurlConfiguratorInterface;
use Markenwerk\BasicHttpClient\Request\Message\Body\BodyInterface;
use Markenwerk\BasicHttpClient\Request\Message\Cookie\CookieInterface;
use Markenwerk\BasicHttpClient\Request\Message\Header\HeaderInterface;

/**
 * Interface MessageInterface
 *
 * @package Markenwerk\BasicHttpClient\Request\Message
 */
interface MessageInterface extends CurlConfiguratorInterface
{

	/**
	 * @return HeaderInterface[]
	 */
	public function getHeaders();

	/**
	 * @param string $name
	 * @return HeaderInterface[]
	 */
	public function getHeadersByName($name);

	/**
	 * @param string $name
	 * @return HeaderInterface
	 */
	public function getHeaderByName($name);

	/**
	 * @return $this
	 */
	public function clearHeaders();

	/**
	 * @param HeaderInterface[] $headers
	 * @return $this
	 */
	public function setHeaders(array $headers);

	/**
	 * @param HeaderInterface $header
	 * @return $this
	 */
	public function addHeader(HeaderInterface $header);

	/**
	 * @param HeaderInterface $header
	 * @return $this
	 */
	public function setHeader(HeaderInterface $header);

	/**
	 * @param string $name
	 * @return $this
	 */
	public function removeHeadersByName($name);

	/**
	 * @param HeaderInterface $header
	 * @return $this
	 */
	public function removeHeader(HeaderInterface $header);

	/**
	 * @param $name
	 * @return bool
	 */
	public function hasHeaderWithName($name);

	/**
	 * @param HeaderInterface $header
	 * @return bool
	 */
	public function hasHeader(HeaderInterface $header);

	/**
	 * @return bool
	 */
	public function hasHeaders();

	/**
	 * @return int
	 */
	public function getHeaderCount();

	/**
	 * @return CookieInterface[]
	 */
	public function getCookies();

	/**
	 * @param $name
	 * @return CookieInterface
	 */
	public function getCookieByName($name);

	/**
	 * @return $this
	 */
	public function clearCookies();

	/**
	 * @param CookieInterface[] $cookies
	 * @return $this
	 */
	public function setCookies($cookies);

	/**
	 * @param CookieInterface $cookie
	 * @return $this
	 */
	public function addCookie(CookieInterface $cookie);

	/**
	 * @param string $name
	 * @return $this
	 */
	public function removeCookieByName($name);

	/**
	 * @param CookieInterface $cookie
	 * @return $this
	 */
	public function removeCookie(CookieInterface $cookie);

	/**
	 * @param $name
	 * @return bool
	 */
	public function hasCookieWithName($name);

	/**
	 * @param CookieInterface $cookie
	 * @return bool
	 */
	public function hasCookie(CookieInterface $cookie);

	/**
	 * @return bool
	 */
	public function hasCookies();

	/**
	 * @return int
	 */
	public function getCookieCount();

	/**
	 * @return BodyInterface
	 */
	public function getBody();

	/**
	 * @param BodyInterface $body
	 * @return $this
	 */
	public function setBody(BodyInterface $body);

	/**
	 * @return bool
	 */
	public function hasBody();

	/**
	 * @return $this
	 */
	public function removeBody();

}
