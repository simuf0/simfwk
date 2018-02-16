<?php

namespace SimFWKLib\Utils;

/**
 * Security class
 * 
 * !Description here...
 * 
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
final class Security
{
    use \SimFWKLib\Factory\Singleton;

    private static $iv;

    private function __construct (\SimFWKLib\Core\Conf $conf)
    {
        if (empty(self::$iv)) {
            self::$iv = $conf->get("encrypt", "iv");
        }
    }

    public function token ()
    {
        $token = openssl_random_pseudo_bytes(32);
        $key = openssl_random_pseudo_bytes(32);
        return openssl_encrypt($token, "aes-256-cbc", $key, false, self::$iv);
    }

    public function encryptAES (string $message, string $key) : string
    {
        return openssl_encrypt(
            $message,
            "aes-256-cbc",
            $key,
            false,
            self::$iv
        );
    }

    public function decryptAES (string $message, string $key)
    {
        return openssl_decrypt($message, "aes-256-cbc", $key, false, self::$iv);
    }
}