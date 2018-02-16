<?php

namespace Assets\Core\Modules;

/**
 * Index module
 * 
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
final class Index extends \SimFWKLib\Controllers\ViewController
{
    protected function executeMain ()
    {
        return [
            'lang' => $this->app->loadService("language")->getCurrent(),
            'head' => [
                'title' => "Page d'accueil - SimFWK",
                'meta' => [
                    'charset'  => "UTF-8",
                    'viewport' => "width=device-width, initial-scale=1.0",
                    'description' => "SimFWK, un framework PHP du tonnerre.",
                ],
            ],
            'header' => [
                'navigation' => "<nav><ul><li>Section 1</li><li>Section 2</li></ul></nav>",
            ],
            'page' => [
                'title' => "Bienvenue sur la page d'accueil",
            ]
        ];
    }
}