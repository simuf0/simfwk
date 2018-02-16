<?php

namespace SimFWKLib\Controllers;

 /**
 * ViewController class
 *
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class ViewController extends \SimFWKLib\Core\Controller
{
    /**
     * @var FWKCore\View View associated to the controller.
     */
    protected $view;

    /**
     * Execute the controller action.
     *
     * @param string $action Controller's action to execute.
     * @param array[] ...$params Parameters passed to the action method.
     * @return string Return the html view.
     */
    final public function execute (string $action, ...$params) : string
    {
        $data = parent::execute($action, ...$params) ?? [];
        $this->setView($action);
        $this->view->addVars($data);
        return $this->view->render();
    }

    // /**
    //  * Load a template.
    //  * @param string $name Name of the template to load.
    //  * @param array $params Parameters passed to the template.
    //  * @return string Return the html template.
    //  */
    // final public function loadTemplate (string $name, ...$params) : string
    // {
    //     $controller = $this->app->loadController("template");
    //     return $controller->execute($name, ...$params);
    // }

    /**
     * Set the controller's view.
     * @param string $name Name of the view.
     * @return bool Return TRUE if the view is properly loaded.
     */
    protected function setView (string $name) : \SimFWKLib\Core\View
    {
        $module = strtolower($this->name);
        $filename = PATHS['views'] . DS . $module . DS . "$name.html";
        if(!is_file($filename)) {
            $this->throws("E_MISSING_VIEW", $filename);
        }
        return $this->view = new \SimFWKLib\Core\View($filename);
    }
}
