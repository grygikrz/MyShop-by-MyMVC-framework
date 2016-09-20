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

            if(empty($_SESSION['basket']['item'][$i])){

            $_SESSION['basket']['item'][$i] = $item[0];
            $_SESSION['basket']['item'][$i]['inBasketProduct'] = 1;

            }else{

                $_SESSION['basket']['item'][$i]['inBasketProduct'] += 1;

                }


    }

    public static function addBasketPay($item) 
    {
            $payments = [
            array('name'=>'Mastercard','price'=>1.00),
            array('name'=>'Android Pay','price'=>1.00),
            array('name'=>'Apple Pay','price'=>1.00),
            array('name'=>'Visa','price'=>1.00),
            array('name'=>'Paypal','price'=>1.00)
            ];
            $_SESSION['basket']['pay'] = $payments[$item];

    }

    public static function addBasketTransport($item) 
    {
            $transport = [
            array('name'=>'DPD','price'=>10.00),
            array('name'=>'DHL','price'=>10.00),
            array('name'=>'FEDEX','price'=>10.00),
            array('name'=>'POLISH POST','price'=>8.00),
            array('name'=>'Collection in person','price'=>0.00)
            ];
            $_SESSION['basket']['transport'] = $transport[$item];

    }

    public static function getBasket() 
    {

                return $_SESSION['basket'];
    }



    public static function getPriceBasket()
    {

            $price = (empty($_SESSION['basket']['all_price'])) ?  0 : $_SESSION['basket']['all_price'] ;

            return $price;
    }

    public static function setPriceBasket($price, $count = false)
    {

           if(isset($_SESSION['basket']['all_price']) && $count == false)

            { 
                $_SESSION['basket']['all_price'] += $price;

            }elseif($count  == true){  

                $_SESSION['basket']['all_price'] = $price;

            }else{  

                $_SESSION['basket']['all_price'] = 0;
                $_SESSION['basket']['all_price'] += $price;

            }

    }

    public static function countBasket()
    {

            $basket = (empty(self::getBasket())) ? 0 : count($_SESSION['basket']['item']);

            return $basket;
    }

    public static function unsetBasket() 
    {

            unset($_SESSION['basket']);
            $_SESSION['basket'] = array();

    }



    public static function unsetBasketItem($id) 
    {

            unset($_SESSION['basket']['item'][$id]);

    }

}

