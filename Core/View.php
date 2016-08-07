<?php

namespace Core;

/**
 * View
 *
 * PHP version 5.4
 */
class View
{

    /**
     * Render a view file
     *
     * @param string $view  The view file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = "../App/Views/$view";  // relative to Core directory

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    /**
     * Render a view template using Twig
     *
     * @param string $template  The template file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem('../App/Views');
            $twig = new \Twig_Environment($loader);

            /**
            *
            *   Add global variables eg to Base.html view.
            *
            */
                
            $twig->addGlobal('categories', Model::select('SELECT * FROM categories'));
            $twig->addGlobal('url', Config::get('URL'));
            $twig->addGlobal('url', Config::get('URL'));
            $twig->addGlobal('lang', Lang::get('simple text', 'simple text'));
        }

        echo $twig->render($template, $args);
    }
}
