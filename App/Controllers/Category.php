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
class Category extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {

            if(!self::getID(4) || self::getID(4) == 'page'){

            $subcat = self::getSubCat(2, 'categories', 'idcategories');
            $subcat = trim($subcat[0]['id_cat']);
            $countAll = Model::select("SELECT count(*) as count FROM products WHERE `group` LIKE '$subcat%'");

            $id = self::getId(5);
            $id = (!$id) ? 0 : $id * 10;
            $items = Model::select("SELECT * FROM products WHERE `group` LIKE '$subcat%' LIMIT $id, 10");

            }else{

            $subcat = self::getSubCat(4, 'subcategories', 'idsubcategories');
            $subcat = trim($subcat[0]['subcategories_id']);
            $countAll = Model::select("SELECT count(*) as count FROM products WHERE `group` = '$subcat'");
            
            $id = self::getId(7);
            $id = (!$id) ? 0 : $id * 10;
            $items = Model::select("SELECT * FROM products WHERE `group` = '$subcat' LIMIT $id, 10");

            }

        
		
        View::renderTemplate('Category/index.html', [
        
            'items' => $items,
            'countAll' => $countAll[0]['count']

        ]);

		// without twig. Using extract() function and render to *.php file. Remamber to use escape html spacial char, echoing var inhtml page
		//		View::render('Posts/index.php', [
    	// 'lang' => Lang::get('simple text', 'simple text')
    }
}
