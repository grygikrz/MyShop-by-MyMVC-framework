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
class AdminItems extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $id = self::getId(3);
        $id = (!$id) ? 0 : $id * 20;

        $items = Model::select("SELECT * FROM products LIMIT $id, 20");
        $countAll = Model::select("SELECT count(*) as count FROM products");
        //$perPage = $countAll[0]['count'] / 5;

		View::renderTemplate('Admin/Items.html', [
        'items' => $items,
        'countAll' => $countAll[0]['count']
        //'perPage' => $perPage

        ]);

		// without twig. Using extract() function and render to *.php file. Remamber to use escape html spacial char, echoing var inhtml page
		//		View::render('Posts/index.php', [
    	// 'lang' => Lang::get('simple text', 'simple text')
    }
}
