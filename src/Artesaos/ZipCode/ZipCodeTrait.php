<?php namespace Artesaos\ZipCode;

trait ZipCodeTrait {

    /**
     * Traits ZipCode
     *
     * @param $value (string)
     * @param $renew (bool)
     * @return Artesaos\ZipCode\ZipCodeInfo
     * @throws Artesaos\ZipCode\ZipCodeException
     */
    public function zipcode($value, $renew = false)
    {
        return zipcode($value, $renew);
    }
}
