<?php

class IDH13SDK {

    private $soapClient;

    public function __construct($wsdl, array $options = array()) {

        $this->soapClient = new SoapClient($wsdl, $options);
    }

    public function find() {
        $resultGetTranslation = $this->soapClient->findCountries();
        $soapXMLResult = $this->soapClient->__getLastResponse();
        $soap = simplexml_load_string($soapXMLResult);
        return $response = $soap->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children()->CmnCountriesCollection;
    }

    public function create($code, $name, $tailCode = '') {
        return $this->soapClient->createCountry(
            array('NewCountry' =>
                array(
                    'code' => $code,
                    'name' => $name,
                    'tailcode' => $tailCode,
                )
            )
        );
    }

}

