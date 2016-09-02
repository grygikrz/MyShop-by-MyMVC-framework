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
class AdminIntegrationAllegro extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        
        define('COUNTRY_CODE', 1);
        define('WEBAPI_USER_LOGIN', 'neutronikpl');
        define('WEBAPI_USER_ID', '48648772');
        define('WEBAPI_USER_ENCODED_PASSWORD', base64_encode(hash('sha256', '497282e7f846da64', true)));
        define('WEBAPI_KEY', 's497282e');
         
        $options['features'] = SOAP_SINGLE_ELEMENT_ARRAYS;
        try {
            $soapClient = new \SoapClient('https://webapi.allegro.pl.webapisandbox.pl/service.php?wsdl', $options);
            $request = array(
                'countryId' => COUNTRY_CODE,
                'webapiKey' => WEBAPI_KEY
            );
            $result = $soapClient->doQueryAllSysStatus($request);
         
            $versionKeys = array();
            foreach ($result->sysCountryStatus->item as $row) {
                $versionKeys[$row->countryId] = $row;
            }
         
            $request = array(
                'userLogin' => WEBAPI_USER_LOGIN,
                'userHashPassword' => WEBAPI_USER_ENCODED_PASSWORD,
                'countryCode' => COUNTRY_CODE,
                'webapiKey' => WEBAPI_KEY,
                'localVersion' => $versionKeys[COUNTRY_CODE]->verKey,
            );
            $session = $soapClient->doLoginEnc($request);
         

            $request = array(
                'sessionId' => $session->sessionHandlePart,
                'pageSize' => 50
            );
         
                $myWonItems = $soapClient->doGetMyWonItems($request);


            $dogetuserid_request = array(
               'countryId' => COUNTRY_CODE,
               'userLogin' => WEBAPI_USER_LOGIN,
               'userEmail' => '',
               'webapiKey' => WEBAPI_KEY
            );
            $loginIdinfo = $soapClient->doGetUserID($dogetuserid_request);

                $request = array(
                'countryId' => COUNTRY_CODE,
            'userId' => WEBAPI_USER_ID,
                'webapiKey' => WEBAPI_KEY
                );
            
            $logininfo = $soapClient->doGetUserLogin($request);

            } catch(Exception $e) {
                echo $e;
            }



		View::renderTemplate('Admin/IntegrationAllegro.html', [
            'loginIdinfo' => $loginIdinfo,
            'logininfo' => $logininfo,
            'myWonItems' => $myWonItems
        ]);

		// without twig. Using extract() function and render to *.php file. Remamber to use escape html spacial char, echoing var inhtml page
		//		View::render('Posts/index.php', [
    	// 'lang' => Lang::get('simple text', 'simple text')
    }
}
