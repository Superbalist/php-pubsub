<?php

namespace Superbalist\PubSub;

abstract class Utils
{
    /**
     * Serialize a message as a string.
     *
     * @param mixed $message
     * @return string
     */
    public static function serializeMessage($message)
    {
        if (!is_string($message)) {
            return serialize($message);
        } else {
            return $message;
        }
    }

    /**
     * Unserialize the message payload.
     *
     * This function first tries to `unserialize()` the message.
     * If unserializing fails, it tries to `json_decode()` the message.
     * If this doesn't work, the payload is returned as is.
     *
     * @param string $payload
     * @return mixed
     */
    public static function unserializeMessagePayload($payload)
    {
        // first, try unserialize it
        // it'll return false and throw an E_NOTICE if the string can't be unserialized
        $message = @unserialize($payload);
        if ($message !== false || $payload === 'b:0;') {
            return $message;
        }

        // now check whether we can decode it using json_decode
        $message = json_decode($payload, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $message;
        }

        return $payload;
    }
}
