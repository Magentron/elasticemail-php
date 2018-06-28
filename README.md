# ElasticEmailPHP 
[![CircleCI](https://circleci.com/gh/Magentron/elasticemail-php.svg?style=svg)](https://circleci.com/gh/Magentron/elasticemail-php)
[![Coverage Status](https://coveralls.io/repos/github/Magentron/elasticemail-php/badge.svg?branch=master)](https://coveralls.io/github/Magentron/elasticemail-php?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Magentron/elasticemail-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Magentron/elasticemail-php/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/f056bb61-1cfc-480c-b50f-5ab9dfacf1a1/mini.png)](https://insight.sensiolabs.com/projects/f056bb61-1cfc-480c-b50f-5ab9dfacf1a1)
[![StyleCI](https://styleci.io/repos/138987623/shield)](https://github.styleci.io/repos/138987623)
  
This is a fork of [rdok/elasticemail-php](https://github.com/rdok/elasticemail-php)
by [Jeroen Derks](https://www.phpfreelancer.nl), a.k.a [Magentron](https://github.com/Magentron).
This fork was created in order to have be able to use with PHPUnit 7+ and to have author- and environment-independent tests.

ElasticEmailPHP is a PHP Library for interacting with [Elastic Email platform API](http://api.elasticemail.com/public/help).

## Example
```
$elasticEmail = new \ElasticEmail\ElasticEmail('your_elastic_api_key');

$elasticEmail->email()->send([
    'to'      => 'to_email',
    'subject' => 'subject',
    'from'    => 'from_email'
]);
```

Installation
------------
Using [composer](https://getcomposer.org/download/)
```bash
composer require magentron/elasticemail-php
```

