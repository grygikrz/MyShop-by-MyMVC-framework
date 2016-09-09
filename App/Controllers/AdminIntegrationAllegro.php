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


        $configuration = Model::select('SELECT * FROM allegro WHERE id = 1');
            
            foreach($configuration as $con):


            $dogetuserid_request = array(
                       'countryId' => $con['COUNTRY_CODE'],
                       'userLogin' => $con['WEBAPI_USER_LOGIN'],
                       'userEmail' => '',
                       'webapiKey' => $con['WEBAPI_KEY']
                    );

            $loginIdinfo = self::allegroSoap()->doGetUserID($dogetuserid_request);

                        $request = array(
                        'countryId' => $con['COUNTRY_CODE'],
                        'userId' => $con['WEBAPI_USER_ID'],
                        'webapiKey' => $con['WEBAPI_KEY']
                );

            $logininfo = self::allegroSoap()->doGetUserLogin($request);



            $dogetmysellitems = array(
                'sessionId' => self::allegroSession()->sessionHandlePart
                );

            $ItemsInfo = self::allegroSoap()->doGetMySellItems($dogetmysellitems);



            $dogetitemtemplates_request = array(
               'sessionId' => self::allegroSession()->sessionHandlePart
               );
            $templateInfo = self::allegroSoap()->doGetItemTemplates($dogetitemtemplates_request);

            endforeach;



if(isset($_POST['add'])){

    $_POST['add'] = true;
    $add = $_POST['add'];

}else{

$add = false;

}

if(isset($_POST['additem'])){

    self::allegroAddItem($_POST['fid'], $_POST['templateid'], $_POST['itemTemplateOption'], $_POST['itemTemplateN']);
}


if(isset($_POST['deletetemplate'])){

    $key = key($_POST['deletetemplate']);
    $doremoveitemtemplates_request = array(
       'sessionId' => self::allegroSession()->sessionHandlePart,
       'itemTemplateIds' => array($key)
);


self::allegroSoap()->doRemoveItemTemplates($doremoveitemtemplates_request);

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
               'sessionId' => self::allegroSession()->sessionHandlePart,
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


if(isset($_POST['check'])){

    $_POST['check'] = true;
    $checktemplate = $_POST['check'];

            $gettemplates = array(
               'sessionId' => self::allegroSession()->sessionHandlePart,
               'itemTemplateIds' => array($_POST['idcheck'])
               );
            
            $templateDesc = self::allegroSoap()->doGetItemTemplates($gettemplates);

}else{

    $checktemplate = false;
    $templateDesc = '';

}

		View::renderTemplate('Admin/IntegrationAllegro.html', [
            'loginIdinfo' => $loginIdinfo,
            'logininfo' => $logininfo,
            'add' => $add,
            'ItemsInfo' => $ItemsInfo,
            'templateInfo' => $templateInfo,
            'addtemplate' => $addtemplate,
            'templateDesc' => $templateDesc

        ]);

		// without twig. Using extract() function and render to *.php file. Remamber to use escape html spacial char, echoing var inhtml page
		//		View::render('Posts/index.php', [
    	// 'lang' => Lang::get('simple text', 'simple text')
    }
}
