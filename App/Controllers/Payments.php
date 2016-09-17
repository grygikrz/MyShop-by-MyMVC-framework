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

    public function __construct(){

        \Braintree_Configuration::environment('sandbox');
        \Braintree_Configuration::merchantId('75gvtcjwgjqnfwcs');
        \Braintree_Configuration::publicKey('5sb9xmg4y3frdrw6');
        \Braintree_Configuration::privateKey('3df58b89c842df67a73bbf027ea9da31');
    }

    public function indexAction()
    {
        
		$basket = B::getBasket();
        $count = B::countBasket();

        View::renderTemplate('Basket/payments.html', 
            [
            'basket' => $basket,
            'count' => $count
            ]);

    }


    public function statusAction()
    {

            $basket = B::getBasket();
            var_dump($basket);

            $amount = $_POST["amount"];
            $nonce = $_POST["payment_method_nonce"];

            $result = \Braintree\Transaction::sale([
                'amount' => $amount,
                'paymentMethodNonce' => $nonce
            ]);

            if ($result->success || !is_null($result->transaction)) {
                $transaction = $result->transaction;
                // header("Location: ./status/" . $transaction->id);

                //Transaction and DB stock update
                foreach ($basket['item'] as $item){ 
                    
                    $data = [ 
                    'id' => '', 
                    'product' => $item['name'], 
                    'user_id' => 1, 
                    'transaction_id' => $transaction->id
                    ];
                    Model::insert('orders', $data);

                    $update = ["product_count" => "product_count - 1"];
                    Model::update("products", $update, "idproduct=".$item['idproduct']); 

                }

                $order = Model::select("SELECT id FROM orders WHERE `transaction_id` = '$transaction->id'");
                $data2 = [
                    'id' => '', 
                    'order_id' => $order[0]['id'], 
                    'user_id' => 1,
                    'failed' => '',
                    'transaction_id' => $transaction->id
                ];
                Model::insert('payments',$data2);
            

            } else {
                $errorString = "";

                foreach($result->errors->deepAll() as $error) {
                    $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
                }

                $_SESSION["errors"] = $errorString;
                header("Location: /status");
            }



/*

        if(isset($_SESSION['basket']['pay'])) {

                    switch($_SESSION['basket']['pay']['name']){

                    case 'Mastercard':
                        $result = \Braintree_Transaction::sale([
                          'amount' => $_SESSION['basket']['pay']['price'],
                          'paymentMethodNonce' => 'fake-valid-mastercard-nonce',
                          'options' => [
                            'submitForSettlement' => True ]
                        ]);
                        var_dump($result);
                    break;

                    case 'Android Pay':
                        $result = \Braintree_Transaction::sale([
                          'amount' => $_SESSION['basket']['pay']['price'],
                          'paymentMethodNonce' => 'fake-android-pay-nonce',
                          'options' => [
                            'submitForSettlement' => True ]
                        ]);
                        var_dump($result);
                    break;

                    case 'Apple Pay':
                        $result = \Braintree_Transaction::sale([
                          'amount' => $_SESSION['basket']['pay']['price'],
                          'paymentMethodNonce' => 'fake-apple-pay-amex-nonce',
                          'options' => [
                            'submitForSettlement' => True ]
                        ]);
                        var_dump($result);
                    break;

                    case 'Visa':
                        $result = \Braintree_Transaction::sale([
                          'amount' => $_SESSION['basket']['pay']['price'],
                          'paymentMethodNonce' => 'fake-valid-visa-nonce',
                          'options' => [
                            'submitForSettlement' => True ]
                        ]);
                        var_dump($result);
                    break;

                    case 'Paypal':
                        $result = \Braintree_Transaction::sale([
                          'amount' => $_SESSION['basket']['pay']['price'],
                          'paymentMethodNonce' => 'fake-paypal-one-time-nonce',
                          'options' => [
                            'submitForSettlement' => True ]
                        ]);
                        var_dump($result);
                    break;

                    default:
                        $result = \Braintree_Transaction::sale([
                          'amount' => $_SESSION['basket']['pay']['price'],
                          'paymentMethodNonce' => 'fake-invalid-nonce',
                          'options' => [
                            'submitForSettlement' => True ]
                        ]);
                        var_dump($result);

                    }

                }else{
                        $result = \Braintree_Transaction::sale([
                          'amount' => '10.00',
                          'paymentMethodNonce' => 'fake-invalid-nonce',
                          'options' => [
                            'submitForSettlement' => True ]
                        ]);
                        var_dump($result);
                }
*/

        View::renderTemplate('Basket/status.html', [
                'result' => $result
        ]);

    }

    public function tokenAction()
    {
        
        echo json_encode($clientToken = \Braintree_ClientToken::generate());

    }

}

        
