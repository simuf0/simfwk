<?php

namespace SimFWKLib;

/**
 * Error exception class
 *
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
class ErrorException extends \ErrorException
{
    use \FWKCore\Factory\Instance;
}
