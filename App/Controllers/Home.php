<?php

namespace App\Controllers;

use \Core\View;
use \Core\Lang;
use \Core\Model;
use \Core\Config;
/**
 * Home controller
 *
 * PHP version 5.4
 */
class Home extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('Home/index.html', [
        'items' => Model::select('SELECT * FROM products ORDER BY RAND() Limit 5')/*,
        'fotos' => Model::select('SELECT image FROM products ORDER BY RAND() Limit 3')*/
    	]);
    }
}
