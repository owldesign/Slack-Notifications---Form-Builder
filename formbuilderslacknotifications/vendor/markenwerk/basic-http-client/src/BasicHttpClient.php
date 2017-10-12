<?php

namespace Markenwerk\BasicHttpClient;

use Markenwerk\BasicHttpClient\Request\RequestInterface;
use Markenwerk\BasicHttpClient\Request\Message\Body\Body;
use Markenwerk\BasicHttpClient\Request\Message\Message;
use Markenwerk\BasicHttpClient\Request\Request;
use Markenwerk\BasicHttpClient\Request\Transport\HttpsTransport;
use Markenwerk\BasicHttpClient\Request\Transport\HttpTransport;
use Markenwerk\BasicHttpClient\Response\ResponseInterface;
use Markenwerk\CommonException\NetworkException\Base\NetworkException;
use Markenwerk\CommonException\NetworkException\ConnectionTimeoutException;
use Markenwerk\UrlUtil\Url;

/**
 * Class BasicHttpClient
 *
 * @package Markenwerk\BasicHttpClient
 */
class BasicHttpClient implements HttpClientInterface
{

	/**
	 * @var RequestInterface
	 */
	private $request;

	/**
	 * BasicHttpClient constructor.
	 *
	 * @param string $endpoint
	 */
	public function __construct($endpoint)
	{
		if (!is_string($endpoint)) {
			$argumentType = (is_object($endpoint)) ? get_class($endpoint) : gettype($endpoint);
			throw new \InvalidArgumentException('Expected the endpoint as string. Got ' . $argumentType);
		}
		$url = new Url($endpoint);
		$transport = new HttpTransport();
		if (mb_strtoupper($url->getScheme()) == 'HTTPS') {
			$transport = new HttpsTransport();
		}
		$this->request = new Request();
		$this->request
			->setTransport($transport)
			->setMessage(new Message())
			->setUrl(new Url($endpoint));
	}

	/**
	 * @return RequestInterface
	 */
	public function getRequest()
	{
		return $this->request;
	}

	/**
	 * @param mixed[] $queryParameters
	 * @return ResponseInterface
	 * @throws NetworkException
	 * @throws ConnectionTimeoutException
	 */
	public function get(array $queryParameters = array())
	{
		$this->request
			->setMethod(RequestInterface::REQUEST_METHOD_GET)
			->getUrl()
			->setQueryParametersFromArray($queryParameters);
		$this->request->perform();
		return $this->request->getResponse();
	}

	/**
	 * @param mixed[] $queryParameters
	 * @return ResponseInterface
	 * @throws NetworkException
	 * @throws ConnectionTimeoutException
	 */
	public function head(array $queryParameters = array())
	{
		$this->request
			->setMethod(RequestInterface::REQUEST_METHOD_HEAD)
			->getUrl()
			->setQueryParametersFromArray($queryParameters);
		$this->request->perform();
		return $this->request->getResponse();
	}

	/**
	 * @param array $postData
	 * @return ResponseInterface
	 * @throws NetworkException
	 * @throws ConnectionTimeoutException
	 */
	public function post(array $postData = array())
	{
		$body = new Body();
		$body->setBodyTextFromArray($postData);
		$this->request
			->getMessage()
			->setBody($body);
		$this->request
			->setMethod(RequestInterface::REQUEST_METHOD_POST)
			->perform();
		return $this->request->getResponse();
	}

	/**
	 * @param array $putData
	 * @return ResponseInterface
	 * @throws NetworkException
	 * @throws ConnectionTimeoutException
	 */
	public function put(array $putData = array())
	{
		$body = new Body();
		$body->setBodyTextFromArray($putData);
		$this->request
			->getMessage()
			->setBody($body);
		$this->request
			->setMethod(RequestInterface::REQUEST_METHOD_PUT)
			->perform();
		return $this->request->getResponse();
	}

	/**
	 * @param array $patchData
	 * @return ResponseInterface
	 * @throws NetworkException
	 * @throws ConnectionTimeoutException
	 */
	public function patch(array $patchData = array())
	{
		$body = new Body();
		$body->setBodyTextFromArray($patchData);
		$this->request
			->getMessage()
			->setBody($body);
		$this->request
			->setMethod(RequestInterface::REQUEST_METHOD_PATCH)
			->perform();
		return $this->request->getResponse();
	}

	/**
	 * @param mixed[] $queryParameters
	 * @return ResponseInterface
	 * @throws NetworkException
	 * @throws ConnectionTimeoutException
	 */
	public function delete(array $queryParameters = array())
	{
		$this->request
			->setMethod(RequestInterface::REQUEST_METHOD_DELETE)
			->getUrl()
			->setQueryParametersFromArray($queryParameters);
		$this->request->perform();
		return $this->request->getResponse();
	}

}
