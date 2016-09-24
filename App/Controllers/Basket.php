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
        $price = B::getPriceBasket();

        if(isset($_POST['remove'])){

            B::unsetBasket();
            header('Location: ./basket');
        }

        if(isset($_POST['countProduct'])){

            $productPrice = 0;
    
            $i = key($_POST['edit']);
            $_SESSION['basket']['item'][$i]['inBasketProduct'] = $_POST['countProduct'];

            foreach($_SESSION['basket']['item'] as $item){
            $productPrice += $item['price'] * $item['inBasketProduct'];
            }

            B::setPriceBasket($productPrice, true);

            header('Location: ./basket');
        }

		View::renderTemplate('Basket/index.html', [
            'basket' => $basket,
            'price' => $price
        ]);
    }
		// without twig. Using extract() function and render to *.php file. Remamber to use escape html spacial char, echoing var inhtml page
		//		View::render('Posts/index.php', [
    	// 'lang' => Lang::get('simple text', 'simple text')


    public function deleteAction()
    {

        B::unsetBasketItem(self::getID(2));
        $productPrice = 0;

        foreach($_SESSION['basket']['item'] as $item){
            $productPrice += $item['price'] * $item['inBasketProduct'];
            }

        B::setPriceBasket($productPrice, true);

        header('Location: ../../basket');

    }


}