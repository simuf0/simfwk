<?php

namespace SimFWKLib\Utils;

/**
 * Cache class
 * 
 * Performs cache methods.
 *
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
final class Cache
{
    use \SimFWKLib\Factory\Instance;

    /**
     * @var \SimFWKLib\Core\Conf Instance of the configuration handler.
     */
    private $conf;

    /**
     * @var \SimFWKLib\Utils\Security Instance of the security handler.
     */
    private $security;

    private $filename;

    private $expire;

    public function __construct (string $filename = ROOT.DS.".cache")
    {
        $this->conf = \SimFWKLib\Core\Conf::getInstance(ROOT.DS."config.ini");
        $this->security = Security::getInstance($this->conf);
        $this->filename = $filename;
    }

    public function get ()
    {
        $data = [];
        $serialized = $this->security->decryptAES(
            file_get_contents($this->filename),
            $this->conf->get("encrypt", "key-storage")
        );
        foreach (unserialize($serialized) as $id => $content) {
            if ($content['expire'] > time()) {
                $data[$id] = $content;
            }
        }
        // $this->clean();
        return $data;
    }

    public function put ($id, $content, int $expire = 60)
    {
        if (!empty($content)) {
            $data = $this->get();
            $data[$id] = [
                'value' => $content,
                'expire' => time() + $expire,
            ];
            file_put_contents($this->filename, $this->security->encryptAES(
                serialize($data),
                $this->conf->get("encrypt", "key-storage")
            ));
        }
    }

    public function clean ()
    {
        file_put_contents($this->filename, $this->security->encryptAES(
            serialize([]),
            $this->conf->get("encrypt", "key-storage")
        ));
    }

    public function flush ()
    {
        $data = $this->get();
        $this->clean();
        return $data;
    }
}
