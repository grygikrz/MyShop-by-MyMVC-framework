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
            *   Add global variables to Base.html view.
            *
            */

            $cat = Model::select('SELECT * FROM categories');


            if(Controller::getID(0)[0] == 'category'){

            $subcat = Controller::getSubCat(2, 'categories', 'idcategories');
            $subcat = trim($subcat[0]['id_cat']);
                
            $subcategories = Model::select("SELECT * FROM subcategories WHERE subcategories_id LIKE '$subcat%'");
            }else{
                
                $subcategories = false;

            }


            $twig->addGlobal('CountBasket', Basket::countBasket());
            $twig->addGlobal('currentPage', Controller::getID(false));
            $twig->addGlobal('categories', $cat);
            $twig->addGlobal('subcategories', $subcategories);
            $twig->addGlobal('url', Config::get('URL'));
            $twig->addGlobal('lang', Lang::get('simple text', 'simple text'));

            /**
            *
            *   Add statistics.
            *
            */


            $info['user_browser'] = (!empty($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : null;
            $ip = (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : null;
            if($ip == '::1') {$ip = '127.0.0.1';}
            $info['user_ip'] = (!empty($ip)) ? $ip : "No ip";
            $info['from_page'] = (!empty($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : null;
            $info['visit_page'] = (!empty($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : null;
            $info['language'] = (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : null;
            Model::insert('statistics', $info);

        }

            echo $twig->render($template, $args);
    }
}
