<?php

namespace Markenwerk\UrlUtil;

/**
 * Class UrlTest
 *
 * @package Markenwerk\UrlUtil
 */
class UrlTest extends \PHPUnit_Framework_TestCase
{

	public function testInvalidArgument1()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		new QueryParameter(1, 1);
	}

	public function testInvalidArgument2()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		new QueryParameter('arg1', new \Exception());
	}

	public function testInvalidArgument3()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		new Url(array());
	}

	public function testInvalidArgument4()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$url = new Url('https://john:secret@mydomain.com:8443/path/to/resource');
		$url->setScheme(1.4);
	}

	public function testInvalidArgument5()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$url = new Url('https://john:secret@mydomain.com:8443/path/to/resource');
		$url->setHostname(0);
	}

	public function testInvalidArgument6()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$url = new Url('https://john:secret@mydomain.com:8443/path/to/resource');
		$url->setPort('invalid');
	}

	public function testInvalidArgument7()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$url = new Url('https://john:secret@mydomain.com:8443/path/to/resource');
		$url->setPath(12);
	}

	public function testInvalidArgument9()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$url = new Url('https://john:secret@mydomain.com:8443/path/to/resource');
		$url->setQueryParameters(array('asd'));
	}

	public function testInvalidArgument11()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$url = new Url('https://john:secret@mydomain.com:8443/path/to/resource');
		$url->setQueryParametersFromArray(array(array()));
	}

	public function testInvalidArgument12()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$url = new Url('https://john:secret@mydomain.com:8443/path/to/resource');
		$url->removeQueryParameterByKey(1);
	}

	public function testInvalidArgument13()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$url = new Url('https://john:secret@mydomain.com:8443/path/to/resource');
		$url->setUsername(array());
	}

	public function testInvalidArgument14()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$url = new Url('https://john:secret@mydomain.com:8443/path/to/resource');
		$url->setPassword(array());
	}

	public function testInvalidArgument15()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$url = new Url('https://john:secret@mydomain.com:8443/path/to/resource');
		$url->setFragment(array());
	}

	public function testInvalidArgument16()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$url = new Url('https://john:secret@mydomain.com:8443/path/to/resource');
		$url->hasQueryParameterWithKey(array());
	}

	public function testParser()
	{
		$url = new Url('https://john:secret@mydomain.com:8443/path/to/resource');
		$url->buildQueryString();

		$url = new Url('https://john:secret@mydomain.com:8443/path/to/resource?arg1=123&arg2=test#fragment');

		$this->assertTrue($url->hasScheme());
		$this->assertTrue($url->hasHostname());
		$this->assertTrue($url->hasPath());
		$this->assertTrue($url->hasQueryParameterWithKey('arg1'));

		$this->assertEquals(2, $url->countQueryParameters());

		$scheme = $url->getScheme();
		fwrite(STDOUT, 'Scheme "' . $scheme . '"' . PHP_EOL);

		$hostname = $url->getHostname();
		fwrite(STDOUT, 'Hostname "' . $hostname . '"' . PHP_EOL);

		$port = $url->getPort();
		fwrite(STDOUT, 'Port "' . (string)$port . '"' . PHP_EOL);

		$username = $url->getUsername();
		fwrite(STDOUT, 'Username "' . $username . '"' . PHP_EOL);

		$password = $url->getPassword();
		fwrite(STDOUT, 'Password "' . $password . '"' . PHP_EOL);

		$path = $url->getPath();
		fwrite(STDOUT, 'Path "' . $path . '"' . PHP_EOL);

		$queryParameters = $url->getQueryParameters();
		foreach ($queryParameters as $queryParameter) {
			fwrite(STDOUT, 'Query parameter "' . $queryParameter->getKey() . '" is "' . $queryParameter->getValue() . '"' . PHP_EOL);
		}

		$url->setQueryParameters($queryParameters);

		$queryParameter = new QueryParameter('arrrrrg1', '789');
		$queryParameter
			->setKey('arg1')
			->setValue('456');
		$url
			->addQueryParameter($queryParameter)
			->removeQueryParameter($queryParameter);

		$fragment = $url->getFragment();
		fwrite(STDOUT, 'Fragment "' . $fragment . '"' . PHP_EOL);

		$queryParameter = new QueryParameter('arrrrrg1', '789');
		$queryParameter
			->setKey('arg1')
			->setValue('456');

		$url
			->setScheme('http')
			->setHostname('yourdomain.com')
			->setPort(8080)
			->setUsername('doe')
			->setPassword('supersecret')
			->setPath('path/to/another/resource')
			->removeQueryParameterByKey('arg2')
			->removeQueryParameterByKey('arg12')
			->removeQueryParameter(new QueryParameter('1', '2'))
			->addQueryParameter($queryParameter)
			->addQueryParameter(new QueryParameter('arg3', 'test'))
			->setFragment('target');

		fwrite(STDOUT, 'URL "' . $url->buildUrl() . '"' . PHP_EOL);

		$expected = 'http://doe:supersecret@yourdomain.com:8080/path/to/another/resource?arg1=456&arg3=test#target';
		$this->assertEquals($expected, $url->buildUrl());

		$url->clearQueryParameters();
		$this->assertFalse($url->hasQueryParameters());

		$url->setQueryParametersFromArray(array(
			'arg1' => 1,
			'arg2' => 2
		));

		$this->assertTrue($url->hasQueryParameters());
		$this->assertEquals(2, $url->countQueryParameters());

	}

}
