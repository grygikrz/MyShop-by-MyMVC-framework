<?php

namespace Core;

/**
 * Users class
 *
 * 
 */
class Users
{



    public function __construct()
    {

        if (empty($_SESSION['users']['login']))
        
        {
            $_SESSION['user']['login'] = '';
        
        }
    
    }



    public static function addUser($user)
    {

        $_SESSION['user'] = $user;

    }


    public static function getUserLogin() 
    {

        return $_SESSION['user'];
    
    }

    public static function isLogIn()
    {

            if(isset($_SESSION['user']['logedIn']))
            {
                return true;

            }else{

                return false;

            }
            
    }

    public static function unsetUser() 
    {

            unset($_SESSION['users']);
            $_SESSION['user'] = array();

    }

}

