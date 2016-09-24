<?php

namespace Core;


/**
 * View
 *
 * PHP version 5.4
 */
class View
{

    /**
     * Render a view file
     *
     * @param string $view  The view file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */



    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = "../App/Views/$view";  // relative to Core directory

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    /**
     * Render a view template using Twig
     *
     * @param string $template  The template file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;
        $errors = null;
        $flash = null;

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem('../App/Views');
            $twig = new \Twig_Environment($loader);



            if(isset($_POST['logout']))
            {

                Users::unsetUser();

                Session::flash('info', '<div class="alert alert-info">
                        <strong>Info!</strong> You logged out!.
                    </div>');
                $flash = Session::flash('info');
                Redirect::to(404);

            }

            if(isset($_POST['usermenu']))
            {

                header('Location: '.Config::get('URL').'/usermenu');

            }



            if(isset($_POST['username']))
            {

                if(Token::check($_POST['token']))
                {


                $validate = new Validation();
                $validate = $validate->check($_POST, array(
                    'username' => array(
                        'required'  => true,
                        'min'       => 3),
                    'password' => array(
                        'required'  => true,
                        'min'       => 3)
                    ));
               // var_dump($_POST);


                if ($validate->passed()) {


                $login = $_POST['username'];
                $password = md5($_POST['password']);

                $user = Model::select("SELECT * FROM users WHERE login = '$login' AND password = '$password'");
                $users = count($user);

                    if($users == 1) {
                
                    $loginUser['id'] = $user[0]['idusers'];
                    $loginUser['login'] = $login;
                    $loginUser['logedIn'] = true;

                    Users::addUser($loginUser);
                
                    Session::flash('success', '<div class="alert alert-success">
                            <strong>Success!</strong> You are now logged in!</div>');

                    $flash = Session::flash('success');

                }else{

                    Session::flash('warning', '<div class="alert alert-danger">
                            <strong>Warning!</strong> You enter wrong username or password.
                        </div>');

                    $flash = Session::flash('warning');

                    }

                    }else{
                    Session::flash('danger', '<div class="alert alert-danger">
                            <strong>Warning!</strong> You enter with some errors:</div>');
                    $flash = Session::flash('danger');

                    $errors = $validate->errors();
                    }
                }
            }
            /**
            *
            *   Add global variables to Base.html view.
            *
            */

            $cat = Model::select('SELECT * FROM categories');

            if(Controller::getID(0)[0] == 'category'){

                $subcat = Controller::getSubCat(2, 'categories', 'idcategories');
                $subcat = trim($subcat[0]['id_cat']);
                    
                $subcategories = Model::select("SELECT * FROM subcategories WHERE subcategories_id LIKE '$subcat%'");
           
            }else{
                
                $subcategories = false;

            }

            $token = Token::generate();

            $twig->addGlobal('CountBasket', Basket::countBasket());
            $twig->addGlobal('currentPage', Controller::getID(false));
            $twig->addGlobal('categories', $cat);
            $twig->addGlobal('token', $token);
            $twig->addGlobal('flash', $flash);
            $twig->addGlobal('errors', $errors);
            $twig->addGlobal('subcategories', $subcategories);
            $twig->addGlobal('url', Config::get('URL'));
            $twig->addGlobal('isLogIn', Users::isLogIn());
            $twig->addGlobal('lang', Lang::get('simple text', 'simple text'));




            /**
            *
            *   Add statistics.
            *
            */


            $info['user_browser'] = (!empty($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : null;
            $ip = (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : null;
            if($ip == '::1') {$ip = '127.0.0.1';}
            $info['user_ip'] = (!empty($ip)) ? $ip : "No ip";
            $info['from_page'] = (!empty($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : null;
            $info['visit_page'] = (!empty($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : null;
            $info['language'] = (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : null;
            Model::insert('statistics', $info);

        }




            echo $twig->render($template, $args);
    }
}
