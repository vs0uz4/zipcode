<?php namespace Artesaos\ZipCode;

interface ZipCodeContracts {
    
    /**
     * @param $value
     * @return Artesaos\ZipCode\ZipCode
     * @throws Artesaos\ZipCode\ZipCodeException
     */
    public function find($value);

    /**
     * @return JSON Javascript
     * @throws Artesaos\ZipCode\ZipCodeException
     */
    public function toJson();

    /**
     * @return Array
     * @throws Artesaos\ZipCode\ZipCodeException
     */
    public function toArray();

    /**
     * @return \stdClass
     * @throws Artesaos\ZipCode\ZipCodeException
     */
    public function toObject();

    /**
     * Remove item from cache
     * @return Artesaos\ZipCode\ZipCode
     */
    public function renew();

}
