<?php

namespace SimFWKLib\Core;

 /**
 * Controller class
 *
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class Controller extends ApplicationComponent implements \SplSubject
{
    use \SimFWKLib\Factory\Instance,
        \SimFWKLib\Factory\Subject,
        \SimFWKLib\Factory\Thrower;

    /**
     * @var string Name of the controller.
     */
    protected $name;
    
    /**
     * @var string Path of the controller.
     */
    protected $path;

    public function __construct (Application $app)
    {
        parent::__construct($app);
        $this->setName();
        $this->setPath();
    }

    private function setName ()
    {
        $pos = strrpos(get_class($this), "\\") + 1;
        $this->name = substr(get_class($this), $pos);
    }

    private function setPath ()
    {
        $this->path = dirname((new \ReflectionClass($this))->getFilename());
    }

    /**
     * Execute the controller action.
     *
     * @param string $action Controller's action to execute.
     * @param array[] ...$params Parameters passed to the action method.
     */
    public function execute (string $action, ...$params)
    {
        $action = \SimFWKLib\Utils\Formatter::toMethodName("execute-$action");
        if(!is_callable([$this, $action])) {
            $this->throws("E_MISSING_ACTION", $this->name, $action);
        }
        return $this->$action(...$params);
    }

    /**
     * Load a model.
     * @param string $name Name of the model.
     * @return FWKCore\Model Return a model instance.
     */
    final public function loadModel (string $name) : \FWKCore\Model
    {
        $class = '\\Models\\' . Utils\Formatter::toClassName($name);
        return new $class($this);
    }

    // final public function loadBusiness (string $name) //: \FWKCore\Business
    // {
    //     $class = '\\Models\\' . Utils\Formatter::toClassName($name);
    //     return new $class($this);
    // }

    // final public function getApp () : \FWKCore\Application
    // {
    //     return $this->app;
    // }
}

/**
 * Controller exception class
 *
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
class ControllerException extends \LogicException
{
    use \SimFWKLib\Factory\Instance;
    
    const E_MISSING_ACTION = "Failed execute action : missing method `%s::%s()`";
    const E_MISSING_VIEW = "Failed loading view : missing file `%s`";
}
