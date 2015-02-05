Codeigniter Basic HTTP Client
=============================
Simplfying GET/POST requests using PHP cURL
Only supports JSON format for now. XML, Images feature will be available soon.

## Installation

Place **HttpClient.php** into your application/libraries

## Usages

**Initialization**

```php

$this->load->library('HttpClient', array(
	'headers' => array(
		 'Authorization: SomekeyHere',
         'Content-Type: application/json',
	),
	'data' => array(
		'somekey' => 'somedata',
		'anotherkey' => 'anotherkeydata'
	),
	'url' => 'http://somesite.com/api/1.0',
));

```

**POST**

```php

if($this->httpclient->post()){
	var_dump($this->httpclient->getResults());
} else {
	echo $this->httpclient->getErrorMsg();
}

```

**GET**

```php
//the only difference is ->get()
if($this->httpclient->get()){
	var_dump($this->httpclient->getResults());
} else {
	echo $this->httpclient->getErrorMsg();
}

```

**Set Options**

During library load, supplying parameters is optional. You can do it later with setOptions() method.

```php
$this->load->library('HttpClient');
$this->httpclient->setOptions(
	array(
	'headers' => array(
		 'Authorization: SomekeyHere',
         'Content-Type: application/json',
	),
	'data' => array(
		'somekey' => 'somedata',
		'anotherkey' => 'anotherkeydata'
	),
	'url' => 'http://somesite.com/api/1.0',
));
```

**Getting Results**

This library provide two ways to obtain results.

1. getResults(); which returns string
2. getResultsArray(); which returns results in array if response is in JSON format.

**Errors**

To check for error :

```php
if($this->httpclient->getError()){
	echo 'Error!'
}
```

To get error message :

```php
	echo $this->httpclient->getErrorMsg();
```

## Enjoy
**Follow me on Twitter [@elsodev](http://twitter.com/elsodev) for more updates**
