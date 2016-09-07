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
        
        try 

        {
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



            $dogetmysellitems = array(
                'sessionId' => $session->sessionHandlePart
                );
            $ItemsInfo = $soapClient->doGetMySellItems($dogetmysellitems);



            $dogetitemtemplates_request = array(
               'sessionId' => $session->sessionHandlePart
               );
            $templateInfo = $soapClient->doGetItemTemplates($dogetitemtemplates_request);

                

            } catch(Exception $e) {
                echo $e;
            }





if(isset($_POST['add'])){

    $_POST['add'] = true;
    $add = $_POST['add'];
    var_dump($_POST);

}else{

$add = false;

}

if(isset($_POST['additem'])){

    $send = array(
        'sessionHandle' => $session->sessionHandlePart, 
        'fields' => 
            array(
                array(
                 'fid' => 1,   // Tytuł [Oferta testowa]
                 'fvalueString' => $_POST['fid'][1]),
                array(
                 'fid' => 2,   // Kategoria [Pozostałe > Pozostałe > Pozostałe]
                 'fvalueString' => '',
                 'fvalueInt' => $_POST['fid'][2]),
                array(
                 'fid' => 4,   // Czas trwania [7]
                 'fvalueString' => '',
                 'fvalueInt' => $_POST['fid'][4]),
                array(
                 'fid' => 5,   // Liczba sztuk [1]
                 'fvalueString' => '',
                 'fvalueInt' => $_POST['fid'][5]),
                array(
                 'fid' => 8,   // Cena Kup Teraz! [10.00]
                 'fvalueString' => '',
                 'fvalueInt' => 0,    
                 'fvalueFloat' => $_POST['fid'][8]),
                array(
                 'fid' => 9,   // Kraj [Polska]
                 'fvalueString' => '',
                 'fvalueInt' => $_POST['fid'][9]),
                array(
                 'fid' => 10,  // Województwo [wielkopolskie]
                 'fvalueString' => '',
                 'fvalueInt' => $_POST['fid'][10]),
                array(
                 'fid' => 11,  // Miejscowość [Poznań]
                 'fvalueString' => $_POST['fid'][11]),
                array(
                 'fid' => 12,  // Transport [Kupujący pokrywa koszty transportu]
                 'fvalueString' => '',
                 'fvalueInt' => $_POST['fid'][12]),
                array(
                 'fid' => 14,  // Formy płatności [Wystawiam faktury VAT]
                 'fvalueString' => '',
                 'fvalueInt' => $_POST['fid'][14]),
                array(
                 'fid' => 24,  // Opis [Opis testowej oferty.]
                 'fvalueString' => $_POST['fid'][24]),
                array(
                 'fid' => 28,  // Sztuki/Komplety/Pary [Sztuk]
                 'fvalueString' => '',
                 'fvalueInt' => 0),
                array(
                 'fid' => 29,  // Format sprzedaży [Licytacja lub Kup Teraz!]
                 'fvalueString' => '',
                 'fvalueInt' => 0),
                array(
                 'fid' => 32,  // Kod pocztowy
                 'fvalueString' => $_POST['fid'][32]),
                array(
                 'fid' => 35,  // Darmowe opcje przesyłki [Przesyłka elektroniczna (e-mail)]
                 'fvalueString' => '',
                 'fvalueInt' => $_POST['fid'][35]),
                array(
                 'fid' => 38,  // Paczka pocztowa priorytetowa (pierwsza sztuka) [11.00]
                 'fvalueString' => '',
                 'fvalueInt' => 0,
                 'fvalueFloat' => $_POST['fid'][38]),
                array(
                 'fid' => 22991,  // Stan
                 'fvalueString' => '',
                 'fvalueInt' => $_POST['fid'][22991])
                ),

                    'itemTemplateId' => 0,
                    'localId' => 432,
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
}
if(isset($_POST['deletetemplate'])){
$key = key($_POST['deletetemplate']);
$doremoveitemtemplates_request = array(
   'sessionId' => $session->sessionHandlePart,
   'itemTemplateIds' => array($key)
);


$soapClient->doRemoveItemTemplates($doremoveitemtemplates_request);

header("Refresh:0");
}


if(isset($_POST['addtemplate'])){

    $_POST['addtemplate'] = true;
    $addtemplate = $_POST['addtemplate'];

}else{

$addtemplate = false;

}


if(isset($_POST['addtem'])){

             $docreateitemtemplate_request = array(
               'sessionId' => $session->sessionHandlePart,
               'itemTemplateName' => $_POST['templatetTitle'],
               'itemTemplateFields' => array(
                  array(
                     'fid' => 1,
                     'fvalueString' => $_POST['templatetDescription']
                     )),
                  array(
                     'fid' => 2,
                     'fvalueString' => '',
                     'fvalueInt' => 92906
                     ));   


                $soapClient->doCreateItemTemplate($docreateitemtemplate_request);

header("Refresh:0");

}


		View::renderTemplate('Admin/IntegrationAllegro.html', [
            'loginIdinfo' => $loginIdinfo,
            'logininfo' => $logininfo,
            'add' => $add,
            'ItemsInfo' => $ItemsInfo,
            'templateInfo' => $templateInfo,
            'addtemplate' => $addtemplate

        ]);

		// without twig. Using extract() function and render to *.php file. Remamber to use escape html spacial char, echoing var inhtml page
		//		View::render('Posts/index.php', [
    	// 'lang' => Lang::get('simple text', 'simple text')
    }
}
