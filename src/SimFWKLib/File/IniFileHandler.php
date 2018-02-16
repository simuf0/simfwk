<?php

namespace SimFWKLib\File;

/**
 * IniFileHandler class
 * 
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
final class IniFileHandler extends FileHandler
{
    public function getContent (bool $hasSections = false)
    {
        return parse_ini_file($this->file->getPathname(), $hasSections);
    }

    public function setContent ($content, bool $hasSections = false)
    {
        parent::setContent($this->encode($content, $hasSections));
    }

    public function encode (array $params, bool $hasSections = false) : string
    {
        $content = "";
        foreach ($params as $k => $v) {
            if ($hasSections) {
                $content .= "[".$k."]\n";
                foreach ($v as $var => $val) {
                    $content .= "$var = \"$val\"\n";
                }
                $content .= "\n";
            } else {
                $content .= "$k = \"$v\"\n";
            }
        }
        return trim($content); 
    }
}