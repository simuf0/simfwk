<?php

namespace SimFWKLib\Core;

 /**
 * View class
 *
 * !Description here...
 * 
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
class View
{
    use \SimFWKLib\Factory\Thrower;

    /** @var string Html filename. */
    private $filename;

    /** @var mixed[] Variables accessible from the view. */
    private $vars = [];

    public function __construct (string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * Add a variable to the view.
     * @param string $name Name of the variable.
     * @param mixed $value Value of the variable.
     */
    public function addVar (string $name, $value)
    {
        $this->vars[$name] = $value;
    }

    /**
     * Add many variables to the view.
     * @param array $vars Variables array.
     */
    public function addVars (array $vars)
    {
        $this->vars = array_merge($this->vars, $vars);
    }

    /**
     * Load a template.
     * @param string $name Name of the template to load.
     * @param array $data Parameters passed to the template.
     * @return string Return the html template.
     */
    public function loadTemplate (string $name, array $data) : string
    {
        $filename = PATHS['views'] . DS . "__templates" . DS . "$name.html";
        if(!is_file($filename)) {
            $this->throws("E_MISSING_TEMPLATE", $filename);
        }
        $template = new \SimFWKLib\Views\TemplateView($filename, $name);
        $template->addVars($data);
        return $template->render();
    }
    
    /**
     * Render the view.
     * @return string Return the html file to string.
     */
    public function render () : string
    {
        extract($this->vars);
        ob_start();
        require $this->filename;
        return ob_get_clean();
    }
}

/**
 * View exception class
 *
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
class ViewException extends \LogicException
{
    use \SimFWKLib\Factory\Instance;
    
    const E_MISSING_TEMPLATE = "Failed loading template : missing file `%s`";
}
