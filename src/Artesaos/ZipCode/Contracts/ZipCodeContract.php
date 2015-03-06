<?php namespace Artesaos\ZipCode\Contracts;

interface ZipCodeContract {
    
    /**     
     * return ZipCodeInfo
     *
     * @param $value (string)
     * @param $renew (bool)
     * @return Artesaos\ZipCode\ZipCodeInfo
     * @throws Artesaos\ZipCode\ZipCodeException
     */
    public function find($value, $renew = false);

}