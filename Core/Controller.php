<?php

namespace Core;

/**
 * Base controller
 *
 * PHP version 5.4
 */
abstract class Controller
{

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $route_params = [];

    /**
     * Class constructor
     *
     * @param array $route_params  Parameters from the route
     *
     * @return void
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param string $name  Method name
     * @param array $args Arguments passed to the method
     *
     * @return void
     */
    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before()
    {
    	// before - here chceck if user is logged in. If not - return false and another code wont be executed';
    }

    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after()
    {
    	// "after - do something if he is logged";
    }

    public static function getID($i)
    {
        $id = htmlspecialchars(key($_GET));
        $id = explode('/',$id);
        
        if ($i == false){

                return $id;
            }
            
            if(isset($i)){

                if(empty($id[$i])){

                    return false;

                }else{

                    return $id[$i];
                }

            }
    }

    public static function getSubCat($i, $from, $where)
    {
        $id = self::getID($i);
        $subcat = Model::select("SELECT * FROM `$from` WHERE `$where` = '$id'");
        return $subcat;
    }

}

