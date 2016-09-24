<?php

namespace Core;

/**
 * Token class
 *
 * CSRF Protection
 */
class Token
{



    public function __construct()
    {


    
    }



    public static function generate()
    {

        return Session::put('token', md5(uniqid()));

    }

   
    public static function check($token){

        if (Session::exists('token') && $token === Session::get('token')){

            Session::delete('token');
            
            return true;
        }

        return false;

    }
}

