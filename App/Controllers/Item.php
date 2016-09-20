<?php

namespace App\Controllers;

use \Core\View;
use \Core\Lang;
use \Core\Model;
use \Core\Config;
use \Core\Basket as B;
/**
 * Home controller
 *
 * PHP version 5.4
 */
class Item extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {

        $id = self::getId(2);
        $item = Model::select("SELECT * FROM products WHERE idproduct = $id");
        $group = $item[0]['group'];

        if(isset($_POST['add'])){

            B::addBasket($item);
            B::setPriceBasket($_SESSION['basket']['item'] [$item[0]['idproduct']] ['price']);
        }

		
        View::renderTemplate('Item/index.html', [
            'item' => $item,
            'related' => Model::select("SELECT * FROM products WHERE `group` = '$group' LIMIT 4")
        ]);

		// without twig. Using extract() function and render to *.php file. Remamber to use escape html spacial char, echoing var inhtml page
		//		View::render('Posts/index.php', [
    	// 'lang' => Lang::get('simple text', 'simple text')
    }
}
