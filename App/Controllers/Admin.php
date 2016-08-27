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
class Admin extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $browsers = ['chrome','opera','firefox','ie','safari'];
        $browser = array();
        foreach($browsers as $b):
            $browser[$b] = Model::select("SELECT count(*) as c FROM statistics WHERE user_browser LIKE '%$b%'");
        endforeach;

        $statistics = Model::select('SELECT * FROM statistics');
        $products = Model::select('SELECT * FROM products');
        $allproducts = count($products);
        $uniquevisit = Model::select('SELECT count(DISTINCT user_ip) as c FROM statistics');
        $unique = "9,6,7,5,9,5,9,7,5,6,3,7,7,6,7,8,8,5";
        var_dump($unique);
        $allvisits = count($statistics);
		View::renderTemplate('Admin/panel.html', [
        
            'allvisits' => $allvisits,
            'allproducts' => $allproducts,
            'uniquevisit' => $uniquevisit,
            'browser' => $browser,
            'unique' => $unique

        ]);

		// without twig. Using extract() function and render to *.php file. Remamber to use escape html spacial char, echoing var inhtml page
		//		View::render('Posts/index.php', [
    	// 'lang' => Lang::get('simple text', 'simple text')
    }
}
