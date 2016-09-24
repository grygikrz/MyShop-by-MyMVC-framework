<?php

namespace Core;

/**
 * Redirect class
 *
 * 
 */
class Redirect
{



    public function __construct()
    {

    
    }



    public static function to($location = null)
    {
            
        if($location) {

            if(is_numeric($location)){
                switch($location){
                case 404:
                    View::renderTemplate("$location.html");
                    exit();
                break;

                case 500:
                    View::renderTemplate("$location.html");
                    exit();
                break;
                }
            }

            header('Location: ' . $location);
            exit();
        }

    }


}

