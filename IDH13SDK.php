<?php

class IDH13SDK {

    private $soapClient;

    public function __construct($wsdl, array $options = array()) {

        $this->soapClient = new SoapClient($wsdl, $options);
    }

    public function find() {
        return $this->soapClient->findCountries();
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

try {
    $test = new IDH13SDK('http://localhost:7101/reference/CountryService?wsdl');


    $test->create();
    $data = $test->find();
    var_dump($data);
} catch (\Exception $e) {
    echo 'exceptions' . "\r\n";
    echo $e->getMessage();
}


