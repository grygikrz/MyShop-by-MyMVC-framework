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
            $_SESSION['basket']['item'][$i] = $item[0];

    }

    public static function addBasketPay($item) 
    {
            $payments = [
            array('name'=>'paypal','price'=>1),
            array('name'=>'paypal2','price'=>1),
            array('name'=>'paypal3','price'=>1),
            array('name'=>'paypal4','price'=>1),
            array('name'=>'paypal5','price'=>1)
            ];
            $_SESSION['basket']['pay'] = $payments[$item];

    }

    public static function addBasketTransport($item) 
    {
            $transport = [
            array('name'=>'UPS','price'=>1),
            array('name'=>'UPS2','price'=>1),
            array('name'=>'UPS3','price'=>1),
            array('name'=>'UPS4','price'=>1),
            array('name'=>'UPS5','price'=>1)
            ];
            $_SESSION['basket']['transport'] = $transport[$item];

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

