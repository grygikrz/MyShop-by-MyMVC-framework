<?php

namespace Core;

/**
 * Basket controller
 *
 * PHP version 5.4
 */
class Basket
{



    public function __construct()
    {

        if (!isset($_SESSION['basket']))
        
        {
            $_SESSION['basket'] = array();
        
        }
    
    }



    public static function addBasket($item) 
    {

            
            $i = $item[0]['idproduct'];
            $_SESSION['basket'][$i] = $item;

    }



    public static function getBasket() 
    {

            
                return $_SESSION['basket'];

    }



    public static function countBasket()
    {

            $basket = (empty(self::getBasket())) ? 0 : count(self::getBasket());

            return $basket;
    }



    public static function unsetBasket() 
    {

            unset($_SESSION['basket']);
            $_SESSION['basket'] = array();
    }



    public static function unsetBasketItem($id) 
    {

            unset($_SESSION['basket'][$id]);

    }

}

