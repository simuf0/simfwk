<?php

namespace SimFWKLib\File;

/**
 * JsonFileHandler class
 * 
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
final class JsonFileHandler extends FileHandler
{
    public function getContent ()
    {
        return json_decode(parent::getContent(), true);
    }

    public function setContent ($json)
    {
        parent::setContent(json_encode($json));
    }
}