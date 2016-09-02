<?php

namespace App\Controllers;

use \Core\View;
use \Core\Lang;
use \Core\Model;
use \Core\Config;
/**
 * Home controller
 *
 * PHP version 5.4
 */
class AdminUsers extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $users = Model::select('SELECT * FROM users');

        $edit = (isset($_POST['edit'])) ? $_POST['edit'] : null;

        $add = (isset($_POST['add'])) ? $_POST['add'] : null;

        $item = '';

        if(isset($_POST['edit'])){

            $ed = key($_POST['edit']);
            $item = Model::select("SELECT * FROM users WHERE idusers = '$ed'");
        }

        if(isset($_POST['remove'])){

            $id = key($_POST['remove']);
            Model::delete('users','idusers = '.$id);
            header('Location: ./users');
        }

        if(isset($_POST['add'])){

            $id = key($_POST['remove']);
            Model::insert('users','idusers = '.$id);
            header('Location: ./users');
        }
       
        if(isset($_POST['update'])){

            $id = key($_POST['remove']);
            Model::update('users','idusers = '.$id);
            header('Location: ./users');
        }

		View::renderTemplate('Admin/users.html', [
            'users' => $users,
            'edit' => $edit,
            'add' => $add,
            'item' => $item
        ]);

		// without twig. Using extract() function and render to *.php file. Remamber to use escape html spacial char, echoing var inhtml page
		//		View::render('Posts/index.php', [
    	// 'lang' => Lang::get('simple text', 'simple text')
    }
}
