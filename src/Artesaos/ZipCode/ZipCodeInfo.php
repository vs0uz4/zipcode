<?php namespace Artesaos\ZipCode;

use Artesaos\ZipCode\Contracts\ZipCodeInfoContract;

class ZipCodeInfo implements ZipCodeInfoContract {


    /**
     * @var string $valueJson
     */
    private $valueJson = null;

    /**
     * Construct ZipCodeInfo
     *
     * @param string $valueJson
     * @throws ZipCodeException
     */
    public function __construct($valueJson) 
    {
        if (is_string($valueJson))
        {
            $this->valueJson = $valueJson;
            if ($this->json_validate_zipcode() === false) {
                throw new ZipCodeException("Invalid JSON ZipCode");
            }
        }
        else
        {
            throw new ZipCodeException("Invalid Format to Type string");
        }
    }


    /**
     * return JSON Javascript
     *
     * @return JSON Javascript
     */
    public function getJson()
    {
        if (!is_null($this->valueJson))
        {
            return $this->valueJson;    
        }
        return null;        
    }

    /**
     * return Array
     *
     * @return Array
     */
    public function getArray()
    {
        if (!is_null($this->valueJson))
        {
		    return json_decode($this->getJson(), true);
        }
        return null;
    }

    /**
     * return stdClass (Object)
     *
     * @return \stdClass
     */
    public function getObject()
    {
        if (!is_null($this->valueJson))
        {
	   	    return json_decode($this->getJson(), false);
        }   
        return null;
    }
	
    /**     
     * validate zipcode format
     *
     * @return bool
     */
    private function json_validate_zipcode() 
    {        
        if (is_string($this->valueJson)) 
        {
            $ret = @json_decode($this->valueJson, true);            
            return (json_last_error() === JSON_ERROR_NONE && 
                    isset($ret['cep']) &&
                    isset($ret['logradouro']) &&
                    isset($ret['complemento']) &&
                    isset($ret['bairro']) &&
                    isset($ret['localidade']) &&
                    isset($ret['uf']) &&
                    isset($ret['ibge'])
                   );
        }
        return false;
    }
}
