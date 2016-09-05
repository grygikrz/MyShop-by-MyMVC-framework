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
class AdminItem extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $id = self::getId(2);
        $id = (!$id) ? 0 : $id;

        $items = Model::select("SELECT * FROM products WHERE idproduct = $id");
        //$perPage = $countAll[0]['count'] / 5;

		View::renderTemplate('Admin/Item.html', [
        'items' => $items
        //'perPage' => $perPage

        ]);

		// without twig. Using extract() function and render to *.php file. Remamber to use escape html spacial char, echoing var inhtml page
		//		View::render('Posts/index.php', [
    	// 'lang' => Lang::get('simple text', 'simple text')
    }
}
