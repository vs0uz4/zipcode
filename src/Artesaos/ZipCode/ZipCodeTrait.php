<?php namespace Artesaos\ZipCode;

trait ZipCodeTrait {

    /**
     * Traits ZipCode
     *
     * @param string $value
     * @param bool $renew
     * @return Artesaos\ZipCode\ZipCodeInfo
     * @throws Artesaos\ZipCode\ZipCodeException
     */
    public function zipcode($value, $renew = false)
    {
        return zipcode($value, $renew);
    }
}