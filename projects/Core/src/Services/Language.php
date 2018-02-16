<?php

namespace Assets\Core\Services;

use \SimFWKLib\Http\HttpRequest;

final class Language extends \SimFWKLib\Core\Service
{
    /**
     * @var string Current language.
     */
    protected $current;

    public function __construct (\Assets\Core $app)
    {
        parent::__construct($app);
        $this->iniLang();
    }

    public function getCurrent () : string
    {
        return $this->current;
    }

    private function iniLang ()
    {
        $server = HttpRequest::getInstance()->dataServer();
        $lang = $this->parseAccept($server["HTTP_ACCEPT_LANGUAGE"]);
        $this->current = $lang;
    }

    private function parseAccept (string $accept) : string
    {
        $parsed = explode(";", $accept);
        if (strpos($parsed[0], ",") === false) {
            return $parsed[0];
        } else {
            return explode(",", $parsed[0])[0];
        }
    }
}
