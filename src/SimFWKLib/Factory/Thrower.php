<?php

namespace SimFWKLib\Factory;

/**
 * Throws an exception.
 *
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
trait Thrower
{
    final protected function throws (
        string $message,
        ...$args
    ) {
        $exception = self::class . "Exception";
        if (!class_exists($exception)) {
            $msg = "Failed throwing exception : missing class `%s`";
            throw new \LogicException(sprintf($msg, $exception));
        }
        if (!@constant("$exception::$message")) {
            $msg = "Failed throwing exception : missing constant `%s`";
            throw new \LogicException(sprintf($msg, "$exception::$message"));
        }
        $message = constant("$exception::$message");
        throw new $exception(sprintf($message, ...$args));
    }
}