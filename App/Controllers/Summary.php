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
        $price = B::getPriceBasket();


        if(isset($_POST['pay'])){

            B::addBasketPay(key($_POST['pay']));
            B::setPriceBasket($_SESSION['basket']['pay']['price']);
            header('Location: ../basket/summary');

        }

        if(isset($_POST['transport'])){

            B::addBasketTransport(key($_POST['transport']));
            B::setPriceBasket($_SESSION['basket']['transport']['price']);
            header('Location: ../basket/summary');

        }

        View::renderTemplate('Basket/summary.html', [
            'basket' => $basket,
            'price' => $price
        ]);


		// without twig. Using extract() function and render to *.php file. Remamber to use escape html spacial char, echoing var inhtml page
		//		View::render('Posts/index.php', [
    	// 'lang' => Lang::get('simple text', 'simple text')
    }
}
