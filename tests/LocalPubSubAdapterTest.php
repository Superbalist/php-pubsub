<?php

namespace Tests;

use Mockery;
use PHPUnit\Framework\TestCase;
use Superbalist\PubSub\Adapters\LocalPubSubAdapter;

class LocalPubSubAdapterTest extends TestCase
{
    public function testSubscribe()
    {
        $adapter = new LocalPubSubAdapter();

        $subscribers = $adapter->getSubscribersForChannel('test_channel');
        $this->assertInternalType('array', $subscribers);
        $this->assertEmpty($subscribers);

        $handler = function ($message) {
        };

        $adapter->subscribe('test_channel', $handler);

        $subscribers = $adapter->getSubscribersForChannel('test_channel');
        $this->assertEquals(1, count($subscribers));
        $this->assertSame($handler, $subscribers[0]);
    }

    public function testPublish()
    {
        $adapter = new LocalPubSubAdapter();

        $handler1 = Mockery::mock(\stdClass::class);
        $handler1->shouldReceive('handle')
            ->with('This is a message sent to handler1 & handler2')
            ->once();
        $adapter->subscribe('test_channel', [$handler1, 'handle']);

        $handler2 = Mockery::mock(\stdClass::class);
        $handler2->shouldReceive('handle')
            ->with('This is a message sent to handler1 & handler2')
            ->once();
        $adapter->subscribe('test_channel', [$handler2, 'handle']);

        $handler3 = Mockery::mock(\stdClass::class);
        $handler3->shouldNotReceive('handle');
        $adapter->subscribe('some_other_channel_that_should_not_receive_anything', [$handler3, 'handle']);

        $adapter->publish('test_channel', 'This is a message sent to handler1 & handler2');
    }

    public function testPublishBatch()
    {
        $adapter = new LocalPubSubAdapter();

        $handler1 = Mockery::mock(\stdClass::class);
        $handler1->shouldReceive('handle')
            ->with('This is a message sent to handler1 & handler2')
            ->once();
        $handler1->shouldReceive('handle')
            ->with('This is another message!')
            ->once();
        $adapter->subscribe('test_channel', [$handler1, 'handle']);

        $handler2 = Mockery::mock(\stdClass::class);
        $handler2->shouldReceive('handle')
            ->with('This is a message sent to handler1 & handler2')
            ->once();
        $handler2->shouldReceive('handle')
            ->with('This is another message!')
            ->once();
        $adapter->subscribe('test_channel', [$handler2, 'handle']);

        $messages = [
            'This is a message sent to handler1 & handler2',
            'This is another message!',
        ];
        $adapter->publishBatch('test_channel', $messages);
    }
}
