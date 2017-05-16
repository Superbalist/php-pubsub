<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Superbalist\PubSub\Utils;

class UtilsTest extends TestCase
{
    public function testSerializeMessage()
    {
        $this->assertEquals('"hello world"', Utils::serializeMessage('hello world'));
        $this->assertEquals('{"hello":"world"}', Utils::serializeMessage(['hello' => 'world']));
        $this->assertEquals('false', Utils::serializeMessage(false));
    }

    public function testUnserializeMessagePayload()
    {
        $this->assertEquals('hello world', Utils::unserializeMessagePayload('"hello world"'));
        $this->assertEquals(['hello' => 'world'], Utils::unserializeMessagePayload('{"hello":"world"}'));
        $this->assertEquals(false, Utils::unserializeMessagePayload('false'));
    }
}
