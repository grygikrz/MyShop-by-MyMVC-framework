<?php

namespace App\Controllers;

use \Core\View;
use \Core\Lang;
use \Core\Model;
use \Core\Config;
use \Core\Basket as B;
/**
 * Home controller
 *
 * PHP version 5.4
 */
class Payments extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        
		$basket = B::getBasket();
        $count = B::countBasket();

if(isset($_POST['pay'])) {

\Braintree_Configuration::environment('sandbox');
\Braintree_Configuration::merchantId('75gvtcjwgjqnfwcs');
\Braintree_Configuration::publicKey('5sb9xmg4y3frdrw6');
\Braintree_Configuration::privateKey('3df58b89c842df67a73bbf027ea9da31');

$result = \Braintree_Transaction::sale([
  'amount' => '10.00',
  'paymentMethodNonce' => 'fake-valid-nonce',
  'options' => [
    'submitForSettlement' => True
  ]
]);
var_dump($result);
}

        View::renderTemplate('Basket/payments.html', [
            'basket' => $basket,
            'count' => $count
        ]);

		// without twig. Using extract() function and render to *.php file. Remamber to use escape html spacial char, echoing var inhtml page
		//		View::render('Posts/index.php', [
    	// 'lang' => Lang::get('simple text', 'simple text')
    }

        public function statusAction()
    {
\Braintree_Configuration::environment('sandbox');
\Braintree_Configuration::merchantId('75gvtcjwgjqnfwcs');
\Braintree_Configuration::publicKey('5sb9xmg4y3frdrw6');
\Braintree_Configuration::privateKey('3df58b89c842df67a73bbf027ea9da31');

/* On production. When braintree can fire from their site to send weebhook notyfication by POST method
if(
    isset($_POST["bt_signature"]) &&
    isset($_POST["bt_payload"])
) {
    $webhookNotification = Braintree_WebhookNotification::parse(
        $_POST["bt_signature"], $_POST["bt_payload"]
    );

    $message =
        "[Webhook Received " . $webhookNotification->timestamp->format('Y-m-d H:i:s') . "] "
        . "Kind: " . $webhookNotification->kind . " | ";

    echo $message;
}
*/

//For testing 

$sampleNotification = \Braintree_WebhookTesting::sampleNotification(
    \Braintree_WebhookNotification::SUBSCRIPTION_WENT_PAST_DUE,
    $id
);

$webhookNotification = \Braintree_WebhookNotification::parse(
    $sampleNotification['bt_signature'],
    $sampleNotification['bt_payload']
);

echo $webhookNotification->subscription->id;


        View::renderTemplate('Basket/status.html', [

        ]);

        // without twig. Using extract() function and render to *.php file. Remamber to use escape html spacial char, echoing var inhtml page
        //      View::render('Posts/index.php', [
        // 'lang' => Lang::get('simple text', 'simple text')
    }
}
