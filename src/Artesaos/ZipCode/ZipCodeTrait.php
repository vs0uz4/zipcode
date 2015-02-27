<?php namespace Artesaos\ZipCode;

trait ZipCodeTrait
{
    /**
     * @param $value
     * @return Artesaos\ZipCode\ZipCode
     * @throws Artesaos\ZipCode\ZipCodeException
     */
    public function zipcode($value)
    {
        return zipcode($value);
    }
}
