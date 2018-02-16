<?php

namespace SimFWKLib\Factory;

/**
 * Defines a subject class (in pattern observer)
 *
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
trait Subject
{
    private $observers = [];

    private $data = [];

    public function __construct (\SimFWKLib\Core\Application $app)
    {
        parent::__construct($app);
    }

    final public function attach (\SplObserver $observer)
    {
        $this->observers[] = $observer;
    }

    final public function detach (\SplObserver $observer)
    {
        if(($key = array_search($observer, $this->observers, true)) !== false) {
            unset($this->observers[$key]);
        }
    }

    final public function notify ()
    {
        foreach($this->observers as $observer) {
            $observer->update($this);
            $this->detach($observer);
        }
    }
}
