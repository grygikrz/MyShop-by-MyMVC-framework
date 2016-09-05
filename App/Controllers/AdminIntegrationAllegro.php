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
         
            $requests = array(
                'userLogin' => WEBAPI_USER_LOGIN,
                'userHashPassword' => WEBAPI_USER_ENCODED_PASSWORD,
                'countryCode' => COUNTRY_CODE,
                'webapiKey' => WEBAPI_KEY,
                'localVersion' => $versionKeys[COUNTRY_CODE]->verKey,
            );
            $session = $soapClient->doLoginEnc($requests);
         

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


/*
            $send = 
array(
    'sessionHandle' => $session->sessionHandlePart, 
    'fields' => 
            array(
                array(
                 'fid' => 1,   // Tytuł [Oferta testowa]
                 'fvalueString' => 'Oferta testowa',
                 'fvalueInt' => 0,
                 'fvalueFloat' => 0,
                 'fvalueImage' => 0,
                 'fvalueDatetime' => 0,
                 'fvalueDate' => '',
                 'fvalueRangeInt' => array(
                        'fvalueRangeIntMin' => 0,
                        'fvalueRangeIntMax' => 0),
                 'fvalueRangeFloat' => array(
                        'fvalueRangeFloatMin' => 0,
                        'fvalueRangeFloatMax' => 0),
                 'fvalueRangeDate' => array(
                        'fvalueRangeDateMin' => '',
                        'fvalueRangeDateMax' => '')),
                array(
                 'fid' => 2,   // Kategoria [Pozostałe > Pozostałe > Pozostałe]
                 'fvalueString' => '',
                 'fvalueInt' => 122607,
                 'fvalueFloat' => 0,
                 'fvalueImage' => 0,
                 'fvalueDatetime' => 0,
                 'fvalueDate' => '',
                 'fvalueRangeInt' => array(
                        'fvalueRangeIntMin' => 0,
                        'fvalueRangeIntMax' => 0),
                 'fvalueRangeFloat' => array(
                        'fvalueRangeFloatMin' => 0,
                        'fvalueRangeFloatMax' => 0),
                 'fvalueRangeDate' => array(
                        'fvalueRangeDateMin' => '',
                        'fvalueRangeDateMax' => '')),
                array(
                 'fid' => 4,   // Czas trwania [7]
                 'fvalueString' => '',
                 'fvalueInt' => 2,
                 'fvalueFloat' => 0,
                 'fvalueImage' => 0,
                 'fvalueDatetime' => 0,
                 'fvalueDate' => '',
                 'fvalueRangeInt' => array(
                        'fvalueRangeIntMin' => 0,
                        'fvalueRangeIntMax' => 0),
                 'fvalueRangeFloat' => array(
                        'fvalueRangeFloatMin' => 0,
                        'fvalueRangeFloatMax' => 0),
                 'fvalueRangeDate' => array(
                        'fvalueRangeDateMin' => '',
                        'fvalueRangeDateMax' => '')),
                array(
                 'fid' => 5,   // Liczba sztuk [1]
                 'fvalueString' => '',
                 'fvalueInt' => 1,    
                 'fvalueFloat' => 0,
                 'fvalueImage' => 0,
                 'fvalueDatetime' => 0,
                 'fvalueDate' => '',
                 'fvalueRangeInt' => array(
                        'fvalueRangeIntMin' => 0,
                        'fvalueRangeIntMax' => 0),
                 'fvalueRangeFloat' => array(
                        'fvalueRangeFloatMin' => 0,
                        'fvalueRangeFloatMax' => 0),
                 'fvalueRangeDate' => array(
                        'fvalueRangeDateMin' => '',
                        'fvalueRangeDateMax' => '')),
                array(
                 'fid' => 8,   // Cena Kup Teraz! [10.00]
                 'fvalueString' => '',
                 'fvalueInt' => 0,    
                 'fvalueFloat' => 10.00,
                 'fvalueImage' => 0,
                 'fvalueDatetime' => 0,
                 'fvalueDate' => '',
                 'fvalueRangeInt' => array(
                        'fvalueRangeIntMin' => 0,
                        'fvalueRangeIntMax' => 0),
                 'fvalueRangeFloat' => array(
                        'fvalueRangeFloatMin' => 0,
                        'fvalueRangeFloatMax' => 0),
                 'fvalueRangeDate' => array(
                        'fvalueRangeDateMin' => '',
                        'fvalueRangeDateMax' => '')),
                array(
                 'fid' => 9,   // Kraj [Polska]
                 'fvalueString' => '',
                 'fvalueInt' => 1,
                 'fvalueFloat' => 0,
                 'fvalueImage' => 0,
                 'fvalueDatetime' => 0,
                 'fvalueDate' => '',
                 'fvalueRangeInt' => array(
                        'fvalueRangeIntMin' => 0,
                        'fvalueRangeIntMax' => 0),
                 'fvalueRangeFloat' => array(
                        'fvalueRangeFloatMin' => 0,
                        'fvalueRangeFloatMax' => 0),
                 'fvalueRangeDate' => array(
                        'fvalueRangeDateMin' => '',
                        'fvalueRangeDateMax' => '')),
                array(
                 'fid' => 10,  // Województwo [wielkopolskie]
                 'fvalueString' => '',
                 'fvalueInt' => 15,
                 'fvalueFloat' => 0,
                 'fvalueImage' => 0,
                 'fvalueDatetime' => 0,
                 'fvalueDate' => '',
                 'fvalueRangeInt' => array(
                        'fvalueRangeIntMin' => 0,
                        'fvalueRangeIntMax' => 0),
                 'fvalueRangeFloat' => array(
                        'fvalueRangeFloatMin' => 0,
                        'fvalueRangeFloatMax' => 0),
                 'fvalueRangeDate' => array(
                        'fvalueRangeDateMin' => '',
                        'fvalueRangeDateMax' => '')),
                array(
                 'fid' => 11,  // Miejscowość [Poznań]
                 'fvalueString' => 'Poznań',
                 'fvalueInt' => 0,
                 'fvalueFloat' => 0,
                 'fvalueImage' => 0,
                 'fvalueDatetime' => 0,
                 'fvalueDate' => '',
                 'fvalueRangeInt' => array(
                        'fvalueRangeIntMin' => 0,
                        'fvalueRangeIntMax' => 0),
                 'fvalueRangeFloat' => array(
                        'fvalueRangeFloatMin' => 0,
                        'fvalueRangeFloatMax' => 0),
                 'fvalueRangeDate' => array(
                        'fvalueRangeDateMin' => '',
                        'fvalueRangeDateMax' => '')),
                array(
                 'fid' => 12,  // Transport [Kupujący pokrywa koszty transportu]
                 'fvalueString' => '',
                 'fvalueInt' => 1,
                 'fvalueFloat' => 0,
                 'fvalueImage' => 0,
                 'fvalueDatetime' => 0,
                 'fvalueDate' => '',
                 'fvalueRangeInt' => array(
                        'fvalueRangeIntMin' => 0,
                        'fvalueRangeIntMax' => 0),
                 'fvalueRangeFloat' => array(
                        'fvalueRangeFloatMin' => 0,
                        'fvalueRangeFloatMax' => 0),
                 'fvalueRangeDate' => array(
                        'fvalueRangeDateMin' => '',
                        'fvalueRangeDateMax' => '')),
                array(
                 'fid' => 14,  // Formy płatności [Wystawiam faktury VAT]
                 'fvalueString' => '',
                 'fvalueInt' => 32,
                 'fvalueFloat' => 0,
                 'fvalueImage' => 0,
                 'fvalueDatetime' => 0,
                 'fvalueDate' => '',
                 'fvalueRangeInt' => array(
                        'fvalueRangeIntMin' => 0,
                        'fvalueRangeIntMax' => 0),
                 'fvalueRangeFloat' => array(
                        'fvalueRangeFloatMin' => 0,
                        'fvalueRangeFloatMax' => 0),
                 'fvalueRangeDate' => array(
                        'fvalueRangeDateMin' => '',
                        'fvalueRangeDateMax' => '')),
                array(
                 'fid' => 24,  // Opis [Opis testowej oferty.]
                 'fvalueString' => 'Opis <b>testowej</b> oferty.',
                 'fvalueInt' => 0,
                 'fvalueFloat' => 0,
                 'fvalueImage' => 0,
                 'fvalueDatetime' => 0,
                 'fvalueDate' => '',
                 'fvalueRangeInt' => array(
                        'fvalueRangeIntMin' => 0,
                        'fvalueRangeIntMax' => 0),
                 'fvalueRangeFloat' => array(
                        'fvalueRangeFloatMin' => 0,
                        'fvalueRangeFloatMax' => 0),
                 'fvalueRangeDate' => array(
                        'fvalueRangeDateMin' => '',
                        'fvalueRangeDateMax' => '')),
                array(
                 'fid' => 28,  // Sztuki/Komplety/Pary [Sztuk]
                 'fvalueString' => '',
                 'fvalueInt' => 0,
                 'fvalueFloat' => 0,
                 'fvalueImage' => 0,
                 'fvalueDatetime' => 0,
                 'fvalueDate' => '',
                 'fvalueRangeInt' => array(
                        'fvalueRangeIntMin' => 0,
                        'fvalueRangeIntMax' => 0),
                 'fvalueRangeFloat' => array(
                        'fvalueRangeFloatMin' => 0,
                        'fvalueRangeFloatMax' => 0),
                 'fvalueRangeDate' => array(
                        'fvalueRangeDateMin' => '',
                        'fvalueRangeDateMax' => '')),
                array(
                 'fid' => 29,  // Format sprzedaży [Licytacja lub Kup Teraz!]
                 'fvalueString' => '',
                 'fvalueInt' => 0,
                 'fvalueFloat' => 0,
                 'fvalueImage' => 0,
                 'fvalueDatetime' => 0,
                 'fvalueDate' => '',
                 'fvalueRangeInt' => array(
                        'fvalueRangeIntMin' => 0,
                        'fvalueRangeIntMax' => 0),
                 'fvalueRangeFloat' => array(
                        'fvalueRangeFloatMin' => 0,
                        'fvalueRangeFloatMax' => 0),
                 'fvalueRangeDate' => array(
                        'fvalueRangeDateMin' => '',
                        'fvalueRangeDateMax' => '')),
                array(
                 'fid' => 32,  // Kod pocztowy
                 'fvalueString' => '60-687',
                 'fvalueInt' => 0,
                 'fvalueFloat' => 0,
                 'fvalueImage' => 0,
                 'fvalueDatetime' => 0,
                 'fvalueDate' => '',
                 'fvalueRangeInt' => array(
                        'fvalueRangeIntMin' => 0,
                        'fvalueRangeIntMax' => 0),
                 'fvalueRangeFloat' => array(
                        'fvalueRangeFloatMin' => 0,
                        'fvalueRangeFloatMax' => 0),
                 'fvalueRangeDate' => array(
                        'fvalueRangeDateMin' => '',
                        'fvalueRangeDateMax' => '')),
                array(
                 'fid' => 35,  // Darmowe opcje przesyłki [Przesyłka elektroniczna (e-mail)]
                 'fvalueString' => '',
                 'fvalueInt' => 2,
                 'fvalueFloat' => 0,
                 'fvalueImage' => 0,
                 'fvalueDatetime' => 0,
                 'fvalueDate' => '',
                 'fvalueRangeInt' => array(
                        'fvalueRangeIntMin' => 0,
                        'fvalueRangeIntMax' => 0),
                 'fvalueRangeFloat' => array(
                        'fvalueRangeFloatMin' => 0,
                        'fvalueRangeFloatMax' => 0),
                 'fvalueRangeDate' => array(
                        'fvalueRangeDateMin' => '',
                        'fvalueRangeDateMax' => '')),
                array(
                 'fid' => 38,  // Paczka pocztowa priorytetowa (pierwsza sztuka) [11.00]
                 'fvalueString' => '',
                 'fvalueInt' => 0,
                 'fvalueFloat' => 11.00,
                 'fvalueImage' => 0,
                 'fvalueDatetime' => 0,
                 'fvalueDate' => '',
                 'fvalueRangeInt' => array(
                        'fvalueRangeIntMin' => 0,
                        'fvalueRangeIntMax' => 0),
                 'fvalueRangeFloat' => array(
                        'fvalueRangeFloatMin' => 0,
                        'fvalueRangeFloatMax' => 0),
                 'fvalueRangeDate' => array(
                        'fvalueRangeDateMin' => '',
                        'fvalueRangeDateMax' => '')),
                array(
                 'fid' => 22991,  // Stan
                 'fvalueString' => '',
                 'fvalueInt' => 1,
                 'fvalueFloat' => 0,
                 'fvalueImage' => 0,
                 'fvalueDatetime' => 0,
                 'fvalueDate' => '',
                 'fvalueRangeInt' => array(
                        'fvalueRangeIntMin' => 0,
                        'fvalueRangeIntMax' => 0),
                 'fvalueRangeFloat' => array(
                        'fvalueRangeFloatMin' => 0,
                        'fvalueRangeFloatMax' => 0),
                 'fvalueRangeDate' => array(
                        'fvalueRangeDateMin' => '',
                        'fvalueRangeDateMax' => ''))


                ),
    'itemTemplateId' => 0,
    'localId' => 123123123,
    'itemTemplateCreate' => array(
        'itemTemplateOption' => 1,
        'itemTemplateName' => 'Nazwa szablonu'),
    'variants' => array(
            'fid' => 23604,
            'quantities' => array(
                'mask' => 256,
                'quantity' => 5 )),
    'tags' => array(
        'tagName' => 'test'),
);
         
                $sendItems = $soapClient->doNewAuctionExt($send);
*/

                $dogetmysellitems = array(
                    'sessionId' => $session->sessionHandlePart);
            
            $ItemsInfo = $soapClient->doGetMySellItems($dogetmysellitems);

            echo "<pre>";
            var_dump($ItemsInfo);
            echo "</pre>";
            } catch(Exception $e) {
                echo $e;
            }



		View::renderTemplate('Admin/IntegrationAllegro.html', [
            'loginIdinfo' => $loginIdinfo,
            'logininfo' => $logininfo,
            'myWonItems' => $myWonItems,
            'ItemsInfo' => $ItemsInfo

        ]);

		// without twig. Using extract() function and render to *.php file. Remamber to use escape html spacial char, echoing var inhtml page
		//		View::render('Posts/index.php', [
    	// 'lang' => Lang::get('simple text', 'simple text')
    }
}
