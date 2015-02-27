<?php namespace Canducci\ZipCode;

trait ZipCodeTrait
{
    /**
     * @param $value
     * @return Canducci\ZipCode\ZipCode
     * @throws Canducci\ZipCode\ZipCodeException
     */
    public function zipcode($value)
    {
        return zipcode($value);
    }
}
