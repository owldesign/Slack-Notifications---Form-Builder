# PHP URL Util

[![Build Status](https://travis-ci.org/markenwerk/php-url-util.svg?branch=master)](https://travis-ci.org/markenwerk/php-url-util)
[![Test Coverage](https://codeclimate.com/github/markenwerk/php-url-util/badges/coverage.svg)](https://codeclimate.com/github/markenwerk/php-url-util/coverage)
[![Dependency Status](https://www.versioneye.com/user/projects/57272fdaa0ca35005083f1e6/badge.svg)](https://www.versioneye.com/user/projects/57272fdaa0ca35005083f1e6)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/df239ecc-f336-4669-a017-fc826497115a.svg)](https://insight.sensiolabs.com/projects/df239ecc-f336-4669-a017-fc826497115a)
[![Code Climate](https://codeclimate.com/github/markenwerk/php-url-util/badges/gpa.svg)](https://codeclimate.com/github/markenwerk/php-url-util)
[![Latest Stable Version](https://poser.pugx.org/markenwerk/url-util/v/stable)](https://packagist.org/packages/markenwerk/url-util)
[![Total Downloads](https://poser.pugx.org/markenwerk/url-util/downloads)](https://packagist.org/packages/markenwerk/url-util)
[![License](https://poser.pugx.org/markenwerk/url-util/license)](https://packagist.org/packages/markenwerk/url-util)

A PHP library providing common URL implementation.

## Installation

```{json}
{
   	"require": {
        "markenwerk/url-util": "~2.0"
    }
}
```

## Usage

### Autoloading and namesapce

```{php}  
require_once('path/to/vendor/autoload.php');
```

### Parsing an URL

```{php}
use Markenwerk\UrlUtil;

$url = new UrlUtil\Url('https://john:secret@mydomain.com:8443/path/to/resource?arg1=123&arg2=test#fragment');

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

$fragment = $url->getFragment();
fwrite(STDOUT, 'Fragment "' . $fragment . '"' . PHP_EOL);

$url
	->setScheme('http')
	->setHostname('yourdomain.com')
	->setPort(8080)
	->setUsername('doe')
	->setPassword('supersecret')
	->setPath('path/to/another/resource')
	->removeQueryParameterByKey('arg2')
	->addQueryParameter(new UrlUtil\QueryParameter('arg1', '456'))
	->addQueryParameter(new UrlUtil\QueryParameter('arg3', 'test'))
	->setFragment('target');

fwrite(STDOUT, 'URL "' . $url->buildUrl() . '"' . PHP_EOL);
```

will output the following

```{http}
Scheme "https"
Hostname "mydomain.com"
Port "8443"
Username "john"
Password "secret"
Path "/path/to/resource"
Query parameter "arg1" is "123"
Query parameter "arg2" is "test"
Fragment "fragment"
URL "http://doe:supersecret@yourdomain.com:8080/path/to/another/resource?arg1=456&arg3=test#target"
```

---

## Contribution

Contributing to our projects is always very appreciated.  
**But: please follow the contribution guidelines written down in the [CONTRIBUTING.md](https://github.com/markenwerk/php-url-util/blob/master/CONTRIBUTING.md) document.**

## License

PHP URL Util is under the MIT license.
