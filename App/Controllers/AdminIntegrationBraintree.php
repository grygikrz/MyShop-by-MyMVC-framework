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
class AdminIntegrationBraintree extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
\Braintree_Configuration::environment('sandbox');
\Braintree_Configuration::merchantId('75gvtcjwgjqnfwcs');
\Braintree_Configuration::publicKey('5sb9xmg4y3frdrw6');
\Braintree_Configuration::privateKey('3df58b89c842df67a73bbf027ea9da31');

echo($clientToken = \Braintree_ClientToken::generate());


$result = \Braintree_Transaction::sale([
  'amount' => '10.00',
  'paymentMethodNonce' => 'fake-valid-nonce',
  'options' => [
    'submitForSettlement' => True
  ]
]);

var_dump($result);


		View::renderTemplate('Admin/IntegrationBraintree.html', [


        ]);

		// without twig. Using extract() function and render to *.php file. Remamber to use escape html spacial char, echoing var inhtml page
		//		View::render('Posts/index.php', [
    	// 'lang' => Lang::get('simple text', 'simple text')
    }
}
