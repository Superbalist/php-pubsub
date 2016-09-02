<?php

include __DIR__ . '/../vendor/autoload.php';

$adapter = new \Superbalist\PubSub\Adapters\LocalPubSubAdapter();
$adapter->subscribe('my_channel', function ($message) {
    var_dump($message);
});

$adapter->publish('my_channel', 'Hello World!');
