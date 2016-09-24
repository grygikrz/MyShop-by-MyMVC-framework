<?php

namespace Core;

/**
 * Base controller
 *
 * PHP version 5.4
 */
abstract class Controller
{

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $route_params = [];

    /**
     * Class constructor
     *
     * @param array $route_params  Parameters from the route
     *
     * @return void
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param string $name  Method name
     * @param array $args Arguments passed to the method
     *
     * @return void
     */
    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before()
    {
    	// before - here chceck if user is logged in. If not - return false and another code wont be executed';
    }

    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after()
    {
    	// "after - do something if he is logged";
    }

    public static function getID($i)
    {
        $id = htmlspecialchars(key($_GET));
        $id = explode('/',$id);
        
        if ($i == false){

                return $id;
            }
            
            if(isset($i)){

                if(empty($id[$i])){

                    return false;

                }else{

                    return $id[$i];
                }

            }
    }

    public static function getSubCat($i, $from, $where)
    {
        $id = self::getID($i);
        $subcat = Model::select("SELECT * FROM `$from` WHERE `$where` = '$id'");
        return $subcat;
    }

    

    
    public static function allegroSoap(){


    $options['features'] = SOAP_SINGLE_ELEMENT_ARRAYS;

                //Allegro call
                try 

                {

                $soapClient = new \SoapClient('https://webapi.allegro.pl.webapisandbox.pl/service.php?wsdl', $options);

                    } catch(Exception $e) {
                        echo $e;
                    }

                    return $soapClient;
    }

    public static function allegroSession(){

        $configuration = Model::select('SELECT * FROM allegro WHERE id = 1');


        foreach($configuration as $con):

                    $request = array(
                        'countryId' => $con['COUNTRY_CODE'],
                        'webapiKey' => $con['WEBAPI_KEY']
                    );

                    $result = self::allegroSoap()->doQueryAllSysStatus($request);

                    $versionKeys = array();
                    foreach ($result->sysCountryStatus->item as $row) {
                        $versionKeys[$row->countryId] = $row;
                    }

                    $requests = array(
                        'userLogin' => $con['WEBAPI_USER_LOGIN'],
                        'userHashPassword' => base64_encode(hash('sha256', $con['WEBAPI_USER_ENCODED_PASSWORD'], true)),
                        'countryCode' => $con['COUNTRY_CODE'],
                        'webapiKey' => $con['WEBAPI_KEY'],
                        'localVersion' => $versionKeys[$con['COUNTRY_CODE']]->verKey,
                    );
                    $session = self::allegroSoap()->doLoginEnc($requests);


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

        endforeach;

        return $session;
    }

       public static function allegroTemplate(){

        $configuration = Model::select('SELECT * FROM allegro WHERE id = 1');
            
            foreach($configuration as $con):

            $gettemplates = array(
               'sessionId' => self::allegroSession()->sessionHandlePart,
               'itemTemplateIds' => array($con['itemTemplateId'])
               );
            endforeach;

            

            $templateDesc = self::allegroSoap()->doGetItemTemplates($gettemplates);

            return $templateDesc;
       }



    public static function allegroAddItem($array, $itemTemplateId, $itemTemplateOption, $itemTemplateName){

       $send = array(
        'sessionHandle' => self::allegroSession()->sessionHandlePart, 
        'fields' => 
            array(
                array(
                 'fid' => 1,   // Tytuł [Oferta testowa]
                 'fvalueString' => $array[1]),
                array(
                 'fid' => 2,   // Kategoria [Pozostałe > Pozostałe > Pozostałe]
                 'fvalueString' => '',
                 'fvalueInt' => (int)$array[2]),
                array(
                 'fid' => 4,   // Czas trwania [7]
                 'fvalueString' => '',
                 'fvalueInt' => (int)$array[4]),
                array(
                 'fid' => 5,   // Liczba sztuk [1]
                 'fvalueString' => '',
                 'fvalueInt' => (int)$array[5]),
                array(
                 'fid' => 8,   // Cena Kup Teraz! [10.00]
                 'fvalueString' => '',
                 'fvalueInt' => 0,    
                 'fvalueFloat' => (float)$array[8]),
                array(
                 'fid' => 9,   // Kraj [Polska]
                 'fvalueString' => '',
                 'fvalueInt' => (int)$array[9]),
                array(
                 'fid' => 10,  // Województwo [wielkopolskie]
                 'fvalueString' => '',
                 'fvalueInt' => (int)$array[10]),
                array(
                 'fid' => 11,  // Miejscowość [Poznań]
                 'fvalueString' => $array[11]),
                array(
                 'fid' => 12,  // Transport [Kupujący pokrywa koszty transportu]
                 'fvalueString' => '',
                 'fvalueInt' => (int)$array[12]),
                array(
                 'fid' => 14,  // Formy płatności [Wystawiam faktury VAT]
                 'fvalueString' => '',
                 'fvalueInt' => (int)$array[14]),
                array(
                 'fid' => 24,  // Opis [Opis testowej oferty.]
                 'fvalueString' => $array[24]),
                array(
                 'fid' => 28,  // Sztuki/Komplety/Pary [Sztuk]
                 'fvalueString' => '',
                 'fvalueInt' => (int)$array[28]),
                array(
                 'fid' => 29,  // Format sprzedaży [Licytacja lub Kup Teraz!]
                 'fvalueString' => '',
                 'fvalueInt' => (int)$array[29]),
                array(
                 'fid' => 32,  // Kod pocztowy
                 'fvalueString' => $array[32]),
                array(
                 'fid' => 35,  // Darmowe opcje przesyłki [Przesyłka elektroniczna (e-mail)]
                 'fvalueString' => '',
                 'fvalueInt' => (int)$array[35]),
                array(
                 'fid' => 38,  // Paczka pocztowa priorytetowa (pierwsza sztuka) [11.00]
                 'fvalueString' => '',
                 'fvalueInt' => 0,
                 'fvalueFloat' => (float)$array[38]),
                array(
                 'fid' => 22991,  // Stan
                 'fvalueString' => '',
                 'fvalueInt' => (int)$array[22991])
                ),

                    'itemTemplateId' => (int)$itemTemplateId,
                    'localId' => 656657
                   /* 'itemTemplateCreate' => array(
                        'itemTemplateOption' => $itemTemplateOption,
                        'itemTemplateName' => $itemTemplateName),
                    'variants' => array(
                            'fid' => 23604,
                            'quantities' => array(
                                'mask' => 256,
                                'quantity' => 5 )),
                    'tags' => array(
                        'tagName' => 'test')*/
                );
              echo "<pre>";
              var_dump($send);
                self::allegroSoap()->doNewAuctionExt($send);

       }



}

