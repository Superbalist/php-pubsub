# php-pubsub

A PHP abstraction for the pub-sub pattern

[![Author](http://img.shields.io/badge/author-@superbalist-blue.svg?style=flat-square)](https://twitter.com/superbalist)
[![Build Status](https://img.shields.io/travis/Superbalist/php-pubsub/master.svg?style=flat-square)](https://travis-ci.org/Superbalist/php-pubsub)
[![StyleCI](https://styleci.io/repos/67251788/shield?branch=master)](https://styleci.io/repos/67251788)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/superbalist/php-pubsub.svg?style=flat-square)](https://packagist.org/packages/superbalist/php-pubsub)
[![Total Downloads](https://img.shields.io/packagist/dt/superbalist/php-pubsub.svg?style=flat-square)](https://packagist.org/packages/superbalist/php-pubsub)


## Installation

```bash
composer require superbalist/php-pubsub
```

## Adapters

* Local (bundled)
* /dev/null (bundled)
* Redis - https://github.com/Superbalist/php-pubsub-redis
* Kafka - https://github.com/Superbalist/php-pubsub-kafka
* Google Cloud - https://github.com/Superbalist/php-pubsub-google-cloud
* HTTP - https://github.com/Superbalist/php-pubsub-http
* AMPQ - https://github.com/LiFeAiR/php-pubsub-ampqp

## Integrations

Want to get started quickly? Check out some of these integrations:

* Laravel - https://github.com/Superbalist/laravel-pubsub

## Usage

```php
$adapter = new \Superbalist\PubSub\Adapters\LocalPubSubAdapter();

// consume messages
$adapter->subscribe('my_channel', function ($message) {
    var_dump($message);
});

// publish messages
$adapter->publish('my_channel', 'Hello World!');

// publish multiple messages
$messages = [
    'message 1',
    'message 2',
];
$adapter->publishBatch('my_channel', $messages);
```

## Writing an Adapter

You can easily write your own custom adapter by implementing the [PubSubAdapterInterface](src/PubSubAdapterInterface.php) interface.

Your adapter must implement the following methods:

```php
/**
 * Subscribe a handler to a channel.
 *
 * @param string $channel
 * @param callable $handler
 */
public function subscribe($channel, callable $handler);

/**
 * Publish a message to a channel.
 *
 * @param string $channel
 * @param mixed $message
 */
public function publish($channel, $message);

/**
 * Publish multiple messages to a channel.
 *
 * @param string $channel
 * @param array $messages
 */
public function publishBatch($channel, array $messages);
```

## Examples

The library comes with [examples](examples) for all adapters and a [Dockerfile](Dockerfile) for
running the example scripts.

Run `make up`.

You will start at a `bash` prompt in the `/opt/php-pubsub` directory.

If you need another shell to publish a message to a blocking consumer, you can run `docker-compose run php-pubsub /bin/bash`

To run the examples:
```bash
$ php examples/LocalExample.php
```
