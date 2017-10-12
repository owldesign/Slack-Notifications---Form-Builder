<?php

namespace Markenwerk\BasicHttpClient\Response;

use Markenwerk\BasicHttpClient\Request\RequestInterface;
use Markenwerk\BasicHttpClient\Response\Header\Header;
use Markenwerk\BasicHttpClient\Response\Statistics\Statistics;
use Markenwerk\BasicHttpClient\Util\HeaderNameUtil;

/**
 * Class AbstractResponse
 *
 * @package Markenwerk\BasicHttpClient\Response
 */
abstract class AbstractResponse implements ResponseInterface
{

	/**
	 * @var RequestInterface
	 */
	private $request;

	/**
	 * @var int
	 */
	private $statusCode;

	/**
	 * @var string
	 */
	private $statusText;

	/**
	 * @var Header[]
	 */
	private $headers;

	/**
	 * @var mixed
	 */
	private $body;

	/**
	 * @var Statistics
	 */
	private $statistics;

	/**
	 * Response constructor.
	 *
	 * @param RequestInterface $request
	 */
	public function __construct(RequestInterface $request)
	{
		$this->request = $request;
	}

	/**
	 * @param resource $curl
	 * @param string $responseBody
	 * @return $this
	 */
	public function populateFromCurlResult($curl, $responseBody)
	{
		if (!is_resource($curl)) {
			$argumentType = (is_object($curl)) ? get_class($curl) : gettype($curl);
			throw new \InvalidArgumentException('curl argument invalid. Expected a valid resource. Got ' . $argumentType);
		}
		if (!is_string($responseBody)) {
			$argumentType = (is_object($responseBody)) ? get_class($responseBody) : gettype($responseBody);
			throw new \InvalidArgumentException('Expected the response body as string. Got ' . $argumentType);
		}
		$this->statusCode = intval(curl_getinfo($curl, CURLINFO_HTTP_CODE));
		$this->setStatistics($curl);
		$this->setResponseData($responseBody);
		return $this;
	}

	/**
	 * @return RequestInterface
	 */
	public function getRequest()
	{
		return $this->request;
	}

	/**
	 * @return int
	 */
	public function getStatusCode()
	{
		return $this->statusCode;
	}

	/**
	 * @return string
	 */
	public function getStatusText()
	{
		return $this->statusText;
	}

	/**
	 * @return Header[]
	 */
	public function getHeaders()
	{
		return $this->headers;
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function hasHeader($name)
	{
		return !is_null($this->getHeader($name));
	}

	/**
	 * @param string $name
	 * @return Header
	 */
	public function getHeader($name)
	{
		$headers = $this->getHeaders();
		$headerNameUtil = new HeaderNameUtil();
		$name = $headerNameUtil->normalizeHeaderName($name);
		foreach ($headers as $header) {
			if ($header->getNormalizedName() == $name) {
				return $header;
			}
		}
		return null;
	}

	/**
	 * @return mixed
	 */
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * @return Statistics
	 */
	public function getStatistics()
	{
		return $this->statistics;
	}

	/**
	 * @param resource $curl
	 * @return $this
	 */
	protected function setStatistics($curl)
	{
		$this->statistics = new Statistics();
		$this->statistics->populateFromCurlResult($curl);
		return $this;
	}

	/**
	 * @param string $responseBody
	 * @return $this
	 */
	protected function setResponseData($responseBody)
	{
		// Parse response
		$responseHeaders = array();
		$responseStatusText = null;
		$responseStatusCode = null;
		if (strpos($responseBody, "\r\n\r\n") !== false) {
			do {
				list($responseHeader, $responseBody) = explode("\r\n\r\n", $responseBody, 2);
				$responseHeaderLines = explode("\r\n", $responseHeader);
				$responseStatusText = $responseHeaderLines[0];
				$responseStatusCode = (int)substr(
					trim($responseStatusText),
					strpos($responseStatusText, ' ') + 1,
					3
				);
			} while (
				strpos($responseBody, "\r\n\r\n") !== false
				&& (
					!($responseStatusCode >= 200 && $responseStatusCode < 300)
					|| !$responseStatusCode >= 400
				)
			);
			$responseHeaders = preg_split('/\r\n/', $responseHeader, null, PREG_SPLIT_NO_EMPTY);
		}
		$this->setResponseHeader($responseHeaders);
		if (!is_null($responseStatusCode)) {
			$this->setStatusCode($responseStatusCode);
		}
		if (!is_null($responseStatusText)) {
			$this->setStatusText($responseStatusText);
		}
		$this->setBody($responseBody);
		return $this;
	}

	/**
	 * @param int $statusCode
	 * @return $this
	 */
	protected function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;
		return $this;
	}

	/**
	 * @param string $statusText
	 * @return $this
	 */
	protected function setStatusText($statusText)
	{
		$this->statusText = $statusText;
		return $this;
	}

	/**
	 * @param mixed $body
	 * @return $this
	 */
	protected function setBody($body)
	{
		$this->body = $body;
		return $this;
	}

	/**
	 * @param string[] $responseHeaders
	 * @return $this
	 */
	protected function setResponseHeader(array $responseHeaders)
	{
		foreach ($responseHeaders as $responseHeader) {
			if (strpos($responseHeader, ':') !== false) {
				$headerName = mb_substr($responseHeader, 0, strpos($responseHeader, ':'));
				$headerValue = mb_substr($responseHeader, strpos($responseHeader, ':') + 1);
				$headerValues = explode(',', $headerValue);
				$this->headers[] = new Header($headerName, $headerValues);
			}
		}
		return $this;
	}

}
