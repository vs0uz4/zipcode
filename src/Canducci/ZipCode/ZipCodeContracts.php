<?php namespace Canducci\ZipCode;

interface ZipCodeContracts
{
    /**
     * @param $value
     * @return Canducci\ZipCode\ZipCode
     * @throws Canducci\ZipCode\ZipCodeException
     */
    public function find($value);

    /**
     * @return JSON Javascript
     * @throws Canducci\ZipCode\ZipCodeException
     */
    public function toJson();

    /**
     * @return Array
     * @throws Canducci\ZipCode\ZipCodeException
     */
    public function toArray();

    /**
     * @return \stdClass
     * @throws Canducci\ZipCode\ZipCodeException
     */
    public function toObject();

    /**
     * Remove item from cache
     * @return Canducci\ZipCode\ZipCode
     */
    public function renew();

}
