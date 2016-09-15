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
class Summary extends \Core\Controller
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
        var_dump($basket);

        if(isset($_POST['pay'])){

            B::addBasketPay(key($_POST['pay']));
            header('Location: ../basket/summary');

        }

        if(isset($_POST['transport'])){

            B::addBasketTransport(key($_POST['transport']));
            header('Location: ../basket/summary');

        }
        View::renderTemplate('Basket/summary.html', [
            'basket' => $basket,
            'count' => $count
        ]);


		// without twig. Using extract() function and render to *.php file. Remamber to use escape html spacial char, echoing var inhtml page
		//		View::render('Posts/index.php', [
    	// 'lang' => Lang::get('simple text', 'simple text')
    }
}
