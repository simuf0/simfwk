<?php

namespace SimFWKLib\File;

/**
 * FileHandler class
 * 
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
class FileHandler
{
    use \SimFWKLib\Factory\Instance, \SimFWKLib\Factory\Thrower;
    
    /** @var \SplFileObject Filename. */
    protected $file;

    public function __construct (string $filename, string $mode = "r")
    {
        $this->open($filename, $mode);
    }

    final public static function exists (string $filename) : bool
    {
        return is_file($filename);
    }

    public function getContent ()
    {
        $content = $this->file->fread($this->file->getSize());
        return $content;
    }

    public function setContent ($content)
    {
        return $this->write($content);
    }

    final public function open (string $filename, string $mode = "r")
    {
        if (!self::exists($filename)) {
            $this->throws("E_MISSING_FILE", $filename);
        }
        $this->file = new \SplFileObject($filename, $mode);
    }

    final public function write (string $content, string $eol = PHP_EOL)
    {
        $this->file->flock(LOCK_EX);
        $this->file->fwrite($content . $eol);
        $this->file->flock(LOCK_UN);
    }
}

/**
 * FileHandler exception class
 *
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
class FileHandlerException extends \LogicException
{
    use \SimFWKLib\Factory\Instance;

    const E_MISSING_FILE = "Failed opening file : missing file `%s`";
}
