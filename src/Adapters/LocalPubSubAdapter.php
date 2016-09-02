<?php

namespace Superbalist\PubSub\Adapters;

use Superbalist\PubSub\PubSubAdapterInterface;

class LocalPubSubAdapter implements PubSubAdapterInterface
{
    /**
     * @var array
     */
    protected $subscribers = [];

    /**
     * Subscribe a handler to a channel.
     *
     * @param string $channel
     * @param callable $handler
     */
    public function subscribe($channel, callable $handler)
    {
        if (!isset($this->subscribers[$channel])) {
            $this->subscribers[$channel] = [];
        }
        $this->subscribers[$channel][] = $handler;
    }

    /**
     * Publish a message to a channel.
     *
     * @param string $channel
     * @param mixed $message
     */
    public function publish($channel, $message)
    {
        foreach ($this->getSubscribersForChannel($channel) as $handler) {
            call_user_func($handler, $message);
        }
    }

    /**
     * Return all subscribers on the given channel.
     *
     * @param string $channel
     * @return array
     */
    public function getSubscribersForChannel($channel)
    {
        return isset($this->subscribers[$channel]) ? $this->subscribers[$channel] : [];
    }
}
