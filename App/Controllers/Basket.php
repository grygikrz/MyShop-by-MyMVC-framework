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
class Basket extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {

        $basket = B::getBasket();
        $count = B::countBasket();


        if(isset($_POST['remove'])){

            B::unsetBasket();
            header('Location: ./basket');
        }

        if(self::getID(1) == 'delete'){

            B::unsetBasketItem(self::getID(2));
            header('Location: ../../basket');
        }

		View::renderTemplate('Basket/index.html', [
            'basket' => $basket,
            'count' => $count
        ]);

		// without twig. Using extract() function and render to *.php file. Remamber to use escape html spacial char, echoing var inhtml page
		//		View::render('Posts/index.php', [
    	// 'lang' => Lang::get('simple text', 'simple text')
    }
}
