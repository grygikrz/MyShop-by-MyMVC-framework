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
        $price = B::getPriceBasket();

        View::renderTemplate('Basket/payments.html', 
            [
            'basket' => $basket,
            'price' => $price
            ]);

    }


    public function statusAction()
    {

            $basket = B::getBasket();

            $amount = $_POST["amount"];
            $nonce = $_POST["payment_method_nonce"];

            $result = \Braintree\Transaction::sale([
                'amount' => $amount,
                'paymentMethodNonce' => $nonce
            ]);

            if ($result->success || !is_null($result->transaction)) {
                $transaction = $result->transaction;
                // header("Location: ./status/" . $transaction->id);
                
                    $ip = (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : null;
                    if($ip == '::1') {$ip = '127.0.0.1';}
                //Transaction and DB stock update
                    $orders = [ 
                    'id' => '',
                    'transaction_id' => $transaction->id,
                    'user_id' => 1,
                    'price' => $amount,
                    'transport_name' => $basket['transport']['name'],
                    'transport_price' => $basket['transport']['price'],
                    'computer_ip' => $ip
                    ];
                    Model::insert('orders', $orders);
                    
                    $order = Model::select("SELECT id FROM orders WHERE `transaction_id` = '$transaction->id'");

                foreach ($basket['item'] as $item){ 
                    
                    $data = [ 
                    'id' => '',
                    'order_id' => $order[0]['id'],
                    'product' => $item['name'],
                    'product_number' => $item['product_number'],
                    'product_price' => $item['price'],
                    'user_id' => 1, 
                    'transaction_id' => $transaction->id,
                    'product_count' => $_SESSION['basket']['item'][$item['idproduct']]['inBasketProduct']
                    ];
                    Model::insert('product_orders', $data);

                    $product_count = $item['product_count'] - 1;
                    $update = ["product_count" => $product_count];
                    Model::update("products", $update, "idproduct=".$item['idproduct']); 

                }

                
                $data2 = [
                    'id' => '', 
                    'order_id' => $order[0]['id'], 
                    'user_id' => 1,
                    'failed' => '',
                    'transaction_id' => $transaction->id,
                    'price' => $amount,
                    'paymentMethodNonce' => $nonce
                ];
                Model::insert('payments',$data2);

                B::unsetBasket();

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

        
