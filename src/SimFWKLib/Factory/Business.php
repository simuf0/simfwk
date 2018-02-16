<?php

namespace SimFWKLib\Factory;

/**
 * It represents the business layer. This is an abstract class and must be
 * inherited by the business classes instances. It implements the observer
 * pattern.
 *
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class Business implements \SplObserver
{
    /** @var mixed[] $data Reference to the subject data. */
    protected $data = [];

    /**
     * Initialize the business class's instance
     * 
     * Uses the {@see Subject::$data} property to communicate data values
     * between different business services.
     *
     * @param mixed[] $data Data reference.
     */
    public function __construct(array &$data)
    {
        $this->data =& $data;
    }
}
