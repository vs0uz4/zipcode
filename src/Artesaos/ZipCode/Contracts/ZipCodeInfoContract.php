<?php namespace Artesaos\ZipCode\Contracts;

interface ZipCodeInfoContract {

	/**
     * return JSON Javascript 
     *
     * @return JSON Javascript
     * @throws Artesaos\ZipCode\ZipCodeException
     */
    public function getJson();

    /**
     * return Array
     *
     * @return Array
     * @throws Artesaos\ZipCode\ZipCodeException
     */
    public function getArray();

    /**
     * return stdClass (Object)
     *
     * @return \stdClass
     * @throws Artesaos\ZipCode\ZipCodeException
     */
    public function getObject();   
    
}
