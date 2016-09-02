<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Superbalist\PubSub\Utils;

class UtilsTest extends TestCase
{
    public function testSerializeMessage()
    {
        $this->assertEquals('hello world', Utils::serializeMessage('hello world'));
        $this->assertEquals('a:1:{s:5:"hello";s:5:"world";}', Utils::serializeMessage(['hello' => 'world']));
        $this->assertEquals('b:0;', Utils::serializeMessage(false));
        $this->assertEquals('{ "hello": "world" }', Utils::serializeMessage('{ "hello": "world" }'));
    }

    public function testUnserializeMessagePayload()
    {
        $this->assertEquals('hello world', Utils::unserializeMessagePayload('hello world'));
        $this->assertEquals(['hello' => 'world'], Utils::unserializeMessagePayload('a:1:{s:5:"hello";s:5:"world";}'));
        $this->assertEquals(false, Utils::unserializeMessagePayload('b:0;'));
        $this->assertEquals(['hello' => 'world'], Utils::unserializeMessagePayload('{ "hello": "world" }'));
    }
}
