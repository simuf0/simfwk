<?php

namespace SimFWKLib\Core;

 /**
 * Configuration class
 * 
 * This class performs the global configuration statements of the application.
 * It loads the config.ini file located into the asset's root location.
 * This class is a part of the FWKCore system. 
 *
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
final class Conf
{
    use \SimFWKLib\Factory\Singleton, \SimFWKLib\Factory\Thrower;

    const RESERVED_SECTIONS = ["environment", "encrypt", "database", "smtp"];

    /** @var string[][] $conf Configuration variables. */
    private $conf;

    /** @var string $conf Configuration filename. */
    private $filename;

    /**
     * @param  string $filename config.ini file to load.
     * @throws SimFWKLib\Core\ConfException When the config.ini file is missing.
     */
    private function __construct (string $filename)
    {
        $this->filename = $filename;
        $this->setConf();
    }

    private function setConf ()
    {
        if (!\SimFWKLib\File\IniFileHandler::exists($this->filename)) {
            $this->throws("E_MISSING_INI_FILE", $this->filename);
        }
        $fh = \SimFWKLib\File\IniFileHandler::getInstance($this->filename);
        if (!$conf = @$fh->getContent(true)) {
            $this->throws("E_BAD_INI_FILE", $this->filename);
        }
        $this->conf = $conf;
    }

    public function __invoke (string $section, string $confname = "")
    {
        return $this->get($section, $confname);
    }

    /**
     * Test if a configuration variable exists.
     * 
     * Test if a configuration variable exists into a section. Sections are
     * defined into the config.ini file. Default section are : environment,
     * encrypt, database, smtp.
     *
     * @param  string $section Name of the section.
     * @param  string $confname Name of the configuration variable.
     * @return bool Indicated if the configuration variable exists.
     */
    public function exists (string $section, string $confname = "")
    {
        if (array_key_exists($section, $this->conf)) {
            if ($confname === "" || isset($this->conf[$section][$confname])) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * Get a configuration variable.
     * 
     * Get a configuration variable if exists into a section. Sections are
     * defined into the config.ini file. Default sections are : environment,
     * encrypt, database, smtp.
     *
     * @param  string $section Name of the section.
     * @param  string $confname Name of the configuration variable.
     * @return bool Returns the configuration value if exists else return FALSE.
     */
    public function get (string $section, string $confname = "")
    {
        if ($this->exists($section)) {
            if (isset($this->conf[$section][$confname])) {
                return $this->conf[$section][$confname];
            } else {
                return $this->conf[$section];
            }
        }
        return false;
    }

    /**
     * Set a configuration variable.
     * 
     * Creates the specified section if not exists. Sections are defined into
     * the config.ini file. Default section are : environment, encrypt,
     * database, smtp.
     *
     * @param  string $section Name of the section.
     * @param  string $confname Name of the configuration variable.
     * @param  string $value Value of the configuration variable.
     */
    public function set (string $section, string $confname, string $value)
    {
        if (in_array($section, self::RESERVED_SECTIONS)) {
            $this->throws("E_RESERVED_SECTION", "set", $section);
        }
        $this->conf[$section][$confname] = $value;
        \SimFWKLib\File\IniFileHandler::getInstance($this->filename, "w")
                                      ->setContent($this->conf, true);
        // $this->setConf();
    }

    /**
     * Unset a configuration variable.
     *
     * @param  string $section Name of the section.
     * @param  string $confname Name of the configuration variable.
     * @param  string $value Value of the configuration variable.
     */
    public function unset (string $section, string $confname = "")
    {
        if (in_array($section, self::RESERVED_SECTIONS)) {
            $this->throws("E_RESERVED_SECTION", "unset", $section);
        }
        if (!isset($this->conf[$section])) {
            $this->throws("E_MISSING_SECTION", "unset", $section);
        }
        if ($confname === "") {
            unset($this->conf[$section]);
        } else {
            if (!isset($this->conf[$section][$confname])) {
                $this->throws("E_MISSING_CONFNAME", "unset", $confname);
            }
            unset($this->conf[$section][$confname]);
        }
        \SimFWKLib\File\IniFileHandler::getInstance($this->filename, "w")
                                      ->setContent($this->conf, true);
        // $this->setConf();
    }
}

/**
 * Conf exception class
 *
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
class ConfException extends \LogicException
{
    use \SimFWKLib\Factory\Instance;
    
    const E_MISSING_INI_FILE = "Failed Loading configuration : missing file `%s`";
    const E_BAD_INI_FILE = "Failed loading configuration : error parsing ini file `%s`";
    const E_RESERVED_SECTION = "Failed executing configuration statement `%s` : `%s` is a reserved section";
    const E_MISSING_SECTION = "Failed executing configuration statement `%s` : missing section `%s`";
    const E_MISSING_CONFNAME = "Failed executing configuration statement `%s` : missing configuration name `%s`";
}
