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
class AdminIntegrationAllegroDefault extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        
        $templateDesc =  self::allegroTemplate();
        $configuration = Model::select('SELECT * FROM allegro WHERE id = 1');

		View::renderTemplate('Admin/IntegrationAllegroDefault.html', [
            'configuration' => $configuration,
            'templateDesc' => $templateDesc

        ]);

		// without twig. Using extract() function and render to *.php file. Remamber to use escape html spacial char, echoing var inhtml page
		//		View::render('Posts/index.php', [
    	// 'lang' => Lang::get('simple text', 'simple text')
    }
}
